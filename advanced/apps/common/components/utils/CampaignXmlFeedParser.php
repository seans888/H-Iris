<?php defined('MW_PATH') || exit('No direct script access allowed');



class CampaignXmlFeedParser
{
    public static $maxItemsCount = 100;

    public static $itemsCount = 10;

    public static function parseContent($content, Campaign $campaign, ListSubscriber $subscriber = null, $cache = false, $cacheKeySuffix = null, DeliveryServer $server = null)
    {
        if (!$cacheKeySuffix) {
            $cacheKeySuffix = $content;
        }
        $cacheKey = sha1(__METHOD__ . $campaign->campaign_uid . sha1($cacheKeySuffix));
        if ($cache && ($cachedContent = Yii::app()->cache->get($cacheKey))) {
            return $cachedContent;
        }
        
        $content = StringHelper::decodeSurroundingTags($content);
        if (!CampaignHelper::contentHasXmlFeed($content)) {
            return $content;
        }
        
        // $pattern = '/\[XML_FEED_BEGIN(.*?)\]((?!\[XML_FEED_END).)*\[XML_FEED_END\]/sx';
        $pattern = '/\[XML_FEED_BEGIN(.*?)\](.*?)\[XML_FEED_END\]/sx';
        if (!preg_match_all($pattern, $content, $multiMatches)) {
            return $content;
        }
        
        if (!isset($multiMatches[0], $multiMatches[0][0])) {
            return $content;
        }

        foreach ($multiMatches[0] as $fullFeedHtml) {
            $_fullFeedHtml = CHtml::decode($fullFeedHtml);
            $matchKeyBefore= sha1($_fullFeedHtml);
            $searchReplace = CampaignHelper::getCommonTagsSearchReplace($_fullFeedHtml, $campaign, $subscriber, $server);
            $_fullFeedHtml = str_replace(array_keys($searchReplace), array_values($searchReplace), $_fullFeedHtml);
            $_fullFeedHtml = CampaignHelper::getTagFilter()->apply($_fullFeedHtml, $searchReplace);
            $matchKeyAfter = sha1($_fullFeedHtml);

            if (!preg_match('/\[XML_FEED_BEGIN(.*?)\](.*?)\[XML_FEED_END\]/sx', $_fullFeedHtml, $matches)) {
                continue;
            }

            if (!isset($matches[0], $matches[2])) {
                continue;
            }

            $feedItemTemplate = $matches[2];

            preg_match('/\[XML_FEED_BEGIN(.*?)\]/', $_fullFeedHtml, $matches);
            if (empty($matches[1])) {
                continue;
            }

            $attributesPattern  = '/(\w+) *= *(?:([\'"])(.*?)\\2|([^ "\'>]+))/';
            preg_match_all($attributesPattern, $matches[1], $matches, PREG_SET_ORDER);
            if (empty($matches)) {
                continue;
            }

            $attributes = array();
            foreach ($matches as $match) {
                if (!isset($match[1], $match[3])) {
                    continue;
                }
                $attributes[strtolower($match[1])] = $match[3];
            }

            $attributes['url'] = isset($attributes['url']) ? str_replace('&amp;', '&', $attributes['url']) : null;
            if (!$attributes['url'] || !FilterVarHelper::url($attributes['url'])) {
                continue;
            }

            $count = self::$itemsCount;
            if (isset($attributes['count']) && (int)$attributes['count'] > 0 && (int)$attributes['count'] <= self::$maxItemsCount) {
                $count = (int)$attributes['count'];
            }

            $doCache   = $matchKeyBefore == $matchKeyAfter && !$campaign->isDraft && $cache;
            $feedItems = self::getRemoteFeedItems($attributes['url'], $count, $campaign, $doCache);
            
            if (empty($feedItems)) {
                continue;
            }

            $feedItemsMap = array(
                '[XML_FEED_ITEM_TITLE]'         => 'title',
                '[XML_FEED_ITEM_DESCRIPTION]'   => 'description',
                '[XML_FEED_ITEM_CONTENT]'       => 'content',
                '[XML_FEED_ITEM_IMAGE]'         => 'image',
                '[XML_FEED_ITEM_LINK]'          => 'link',
                '[XML_FEED_ITEM_PUBDATE]'       => 'pubDate',
                '[XML_FEED_ITEM_GUID]'          => 'guid',
            );

            $html = '';
            foreach ($feedItems as $feedItem) {
                $itemHtml = $feedItemTemplate;
                foreach ($feedItemsMap as $tag => $mapValue) {
                    if (!isset($feedItem[$mapValue]) || !is_string($feedItem[$mapValue])) {
                        continue;
                    }
                    $itemHtml = str_replace($tag, $feedItem[$mapValue], $itemHtml);
                }
                if (sha1($itemHtml) != sha1($feedItemTemplate)) {
                    $html .= $itemHtml;
                }
            }

            $content = str_replace($fullFeedHtml, $html, $content);
        }

        if ($doCache) {
            Yii::app()->cache->set($cacheKey, $content, MW_CACHE_TTL);
        }

        return $content;
    }

    public static function getRemoteFeedItems($url, $count = 10, Campaign $campaign, $cache = false)
    {
        $cacheKey = sha1(__METHOD__ . $campaign->campaign_uid . $url . $count);
        if ($cache && ($items = Yii::app()->cache->get($cacheKey))) {
            return $items;
        }

        $items  = array();
        $result = AppInitHelper::simpleCurlGet($url);
        if ($result['status'] != 'success' || empty($result['message'])) {
            return $items;
        }
        
        $useErrors = libxml_use_internal_errors(true);
        $xml       = simplexml_load_string($result['message'], 'SimpleXMLElement', LIBXML_NOCDATA);

        if (empty($xml)) {
            libxml_clear_errors();
            libxml_use_internal_errors($useErrors);
            return $items;
        }

        $namespaces = $xml->getNamespaces(true);

        if (empty($xml->channel) || empty($xml->channel->item)) {
            libxml_clear_errors();
            libxml_use_internal_errors($useErrors);
            return $items;
        }

        foreach($xml->channel->item as $item) {

            if (count($items) >= $count) {
                break;
            }

            $itemMap = array(
                'title'         => null,
                'description'   => null,
                'content'       => null,
                'image'         => null,
                'link'          => null,
                'pubDate'       => null,
                'guid'          => null,
            );

            if (isset($item->title)) {
                $itemMap['title'] = (string)$item->title;
            }

            if (isset($item->description)) {
                $itemMap['description'] = (string)$item->description;
            }

            $content = $item->children('content', true);
            if (isset($content->encoded)) {
                $itemMap['content'] = (string)$content->encoded;
            }
            
            if (empty($itemMap['image']) && isset($item->enclosure)) {
                $enclosure  = $item->enclosure;
                $attributes = $enclosure->attributes();
                $url  = isset($attributes->url)  ? (string)$attributes->url  : null;
                $type = isset($attributes->type) ? (string)$attributes->type : null;
                if (!empty($url) && strpos($type, 'image/') === 0) {
                    $itemMap['image'] = $url;    
                }
            }

            if (empty($itemMap['image']) && !empty($namespaces['media'])) {
                $media = $item->children($namespaces['media']);
                if (!empty($media) && isset($media->content)) {
                    $itemMap['image'] = (string)$media->content;
                }
            }

            if (isset($item->link)) {
                $itemMap['link'] = (string)$item->link;
            }

            if (isset($item->pubDate)) {
                $itemMap['pubDate'] = (string)$item->pubDate;
            }

            if (isset($item->guid)) {
                $itemMap['guid'] = (string)$item->guid;
            }

            $itemMap = array_map(array('CHtml', 'decode'), $itemMap);
            // $itemMap = array_map(array('CHtml', 'encode'), $itemMap);
            $items[] = $itemMap;
        }

        libxml_clear_errors();
        libxml_use_internal_errors($useErrors);

        if ($cache) {
            Yii::app()->cache->set($cacheKey, $items, MW_CACHE_TTL);
        }

        return $items;
    }
}
