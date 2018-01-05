<?php defined('MW_PATH') || exit('No direct script access allowed');


class CustomerActionLogBehavior extends CBehavior
{
    public function attach($owner)
    {
        if (!($owner instanceof Customer)) {
            throw new CException(Yii::t('customers', 'The {className} behavior can only be attach to a Customer model', array(
                '{className}' => get_class($this),
            )));
        }
        parent::attach($owner);
    }
    
    public function listCreated($list)
    {
        if (empty($this->owner->customer_id)) {
            return false;
        }
        
        $url        = Yii::app()->options->get('system.urls.customer_absolute_url');
        $url        = $url . sprintf('lists/%s/overview', $list->uid);
        $message    = 'The list "{listName}" has been successfully created!';
        $listLink   = CHtml::link($list->name, $url);
        $message    = Yii::t('lists', $message, array('{listName}' => $listLink)); 
        
        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = CustomerActionLog::CATEGORY_LISTS_CREATED;
        $model->reference_id = $list->list_id;
        $model->message = $message;
        return $model->save();
    }
    
    public function listUpdated($list)
    {
        if (empty($this->owner->customer_id)) {
            return false;
        }
        
        $url        = Yii::app()->options->get('system.urls.customer_absolute_url');
        $url        = $url . sprintf('lists/%s/overview', $list->uid);
        $message    = 'The list "{listName}" has been successfully updated!';
        $listLink   = CHtml::link($list->name, $url);
        $message    = Yii::t('lists', $message, array('{listName}' => $listLink)); 

        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = CustomerActionLog::CATEGORY_LISTS_UPDATED;
        $model->reference_id = $list->list_id;
        $model->message = $message;
        return $model->save();
    }

    public function listImportStart($list, $import)
    {
        if (empty($this->owner->customer_id)) {
            return false;
        }
        
        $url        = Yii::app()->options->get('system.urls.customer_absolute_url');
        $url        = $url . sprintf('lists/%s/overview', $list->uid);
        $message    = 'The import process for list "{listName}" has successfully started, counting {rowsCount} records!';
        $listLink   = CHtml::link($list->name, $url);
        $message    = Yii::t('list_import', $message, array('{listName}' => $listLink, '{rowsCount}' => $import->rows_count)); 

        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = CustomerActionLog::CATEGORY_LISTS_IMPORT_START;
        $model->reference_id = $list->list_id;
        $model->message = $message;
        return $model->save();
    }
    
    public function listImportEnd($list, $import)
    {
        if (empty($this->owner->customer_id)) {
            return false;
        }
        
        $url        = Yii::app()->options->get('system.urls.customer_absolute_url');
        $url        = $url . sprintf('lists/%s/overview', $list->uid);
        $message    = 'The import process for list "{listName}" has successfully ended, processing {rowsCount} records!';
        $listLink   = CHtml::link($list->name, $url);
        $message    = Yii::t('list_import', $message, array('{listName}' => $listLink, '{rowsCount}' => $import->rows_count)); 

        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = CustomerActionLog::CATEGORY_LISTS_IMPORT_END;
        $model->reference_id = $list->list_id;
        $model->message = $message;
        return $model->save();
    }
    
    public function listExportStart($list, $export)
    {
        if (empty($this->owner->customer_id)) {
            return false;
        }
        
        $url        = Yii::app()->options->get('system.urls.customer_absolute_url');
        $url        = $url . sprintf('lists/%s/overview', $list->uid);
        $message    = 'The export process for list "{listName}" has successfully started, counting {rowsCount} records!';
        $listLink   = CHtml::link($list->name, $url);
        $message    = Yii::t('list_export', $message, array('{listName}' => $listLink, '{rowsCount}' => $export->count)); 

        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = CustomerActionLog::CATEGORY_LISTS_EXPORT_START;
        $model->reference_id = $list->list_id;
        $model->message = $message;
        return $model->save();
    }
    
    public function listExportEnd($list, $export)
    {
        if (empty($this->owner->customer_id)) {
            return false;
        }
        
        $url        = Yii::app()->options->get('system.urls.customer_absolute_url');
        $url        = $url . sprintf('lists/%s/overview', $list->uid);
        $message    = 'The export process for list "{listName}" has successfully ended, processing {rowsCount} records!';
        $listLink   = CHtml::link($list->name, $url);
        $message    = Yii::t('list_export', $message, array('{listName}' => $listLink, '{rowsCount}' => $export->count)); 

        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = CustomerActionLog::CATEGORY_LISTS_EXPORT_END;
        $model->reference_id = $list->list_id;
        $model->message = $message;
        return $model->save();
    }
    
    public function listDeleted($list)
    {
        if (empty($this->owner->customer_id)) {
            return false;
        }
        
        // remove logs
        // remove list logs
        $criteria = new CDbCriteria();
        $criteria->compare('customer_id', (int)$this->owner->customer_id);
        $criteria->addInCondition('category', array(
            CustomerActionLog::CATEGORY_LISTS_CREATED, 
            CustomerActionLog::CATEGORY_LISTS_UPDATED,
            CustomerActionLog::CATEGORY_LISTS_IMPORT_START,
            CustomerActionLog::CATEGORY_LISTS_IMPORT_END,
            CustomerActionLog::CATEGORY_LISTS_EXPORT_START,
            CustomerActionLog::CATEGORY_LISTS_EXPORT_END,
        ));
        $criteria->compare('reference_id', (int)$list->list_id);
        CustomerActionLog::model()->deleteAll($criteria);
        
        // remove references
        $criteria = new CDbCriteria();
        $criteria->compare('customer_id', (int)$this->owner->customer_id);
        $criteria->addInCondition('category', array(
            // segments
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_CREATED, 
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_UPDATED,
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_DELETED,
            // campaigns
            CustomerActionLog::CATEGORY_LISTS_CAMPAIGNS_CREATED, 
            CustomerActionLog::CATEGORY_LISTS_CAMPAIGNS_UPDATED,
            CustomerActionLog::CATEGORY_LISTS_CAMPAIGNS_SCHEDULED,
            CustomerActionLog::CATEGORY_LISTS_CAMPAIGNS_SENT,
            CustomerActionLog::CATEGORY_LISTS_CAMPAIGNS_DELETED,
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_CAMPAIGNS_CREATED, 
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_CAMPAIGNS_UPDATED,
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_CAMPAIGNS_SCHEDULED,
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_CAMPAIGNS_SENT,
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_CAMPAIGNS_DELETED,
            // subscribers
            CustomerActionLog::CATEGORY_LISTS_SUBSCRIBERS_CREATED, 
            CustomerActionLog::CATEGORY_LISTS_SUBSCRIBERS_UPDATED,
            CustomerActionLog::CATEGORY_LISTS_SUBSCRIBERS_DELETED,
            CustomerActionLog::CATEGORY_LISTS_SUBSCRIBERS_UNSUBSCRIBED,
        ));
        $criteria->compare('reference_relation_id', (int)$list->list_id);
        CustomerActionLog::model()->deleteAll($criteria);

        // add logs
        $message = 'The list "{listName}" has been successfully deleted!';
        $message = Yii::t('lists', $message, array('{listName}' => $list->name,)); 

        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = CustomerActionLog::CATEGORY_LISTS_DELETED;
        $model->message = $message;
        return $model->save();
    }
    
    public function segmentCreated($segment)
    {
        if (empty($this->owner->customer_id)) {
            return false;
        }
        
        $segUrl = Yii::app()->options->get('system.urls.customer_absolute_url');
        $segUrl = $segUrl . sprintf('lists/%s/segments/%s/update', $segment->list->uid, $segment->segment_uid);
        
        $url = Yii::app()->options->get('system.urls.customer_absolute_url');
        $url = $url . sprintf('lists/%s/overview', $segment->list->uid);

        $message    = 'A new segment called "{segmentName}" has been added to the list "{listName}" successfully!';
        $segmLink   = CHtml::link($segment->name, $segUrl);
        $listLink   = CHtml::link($segment->list->name, $url);
        $message    = Yii::t('list_segments', $message, array('{segmentName}' => $segmLink, '{listName}' => $listLink)); 
        
        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = CustomerActionLog::CATEGORY_LISTS_SEGMENT_CREATED;
        $model->reference_id = $segment->segment_id;
        $model->reference_relation_id = $segment->list_id;
        $model->message = $message;
        return $model->save();
    }
    
    public function segmentUpdated($segment)
    {
        $segUrl = Yii::app()->options->get('system.urls.customer_absolute_url');
        $segUrl = $segUrl . sprintf('lists/%s/segments/%s/update', $segment->list->uid, $segment->segment_uid);
        
        $url = Yii::app()->options->get('system.urls.customer_absolute_url');
        $url = $url . sprintf('lists/%s/overview', $segment->list->uid);

        $message    = 'The segment called "{segmentName}" belonging to the list "{listName}" has been successfully updated!';
        $segmLink   = CHtml::link($segment->name, $segUrl);
        $listLink   = CHtml::link($segment->list->name, $url);
        $message    = Yii::t('list_segments', $message, array('{segmentName}' => $segmLink, '{listName}' => $listLink)); 
        
        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = CustomerActionLog::CATEGORY_LISTS_SEGMENT_UPDATED;
        $model->reference_id = $segment->segment_id;
        $model->reference_relation_id = $segment->list_id;
        $model->message = $message;
        return $model->save();
    }
    
    public function segmentDeleted($segment)
    {
        if (empty($this->owner->customer_id)) {
            return false;
        }

        // remove segment logs
        $criteria = new CDbCriteria();
        $criteria->compare('customer_id', (int)$this->owner->customer_id);
        $criteria->addInCondition('category', array(
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_CREATED, 
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_UPDATED,
        ));
        $criteria->compare('reference_id', (int)$segment->segment_id);
        $criteria->compare('reference_relation_id', (int)$segment->list_id);
        CustomerActionLog::model()->deleteAll($criteria);
        
        // remove segment campaigns logs
        $criteria = new CDbCriteria();
        $criteria->compare('customer_id', (int)$this->owner->customer_id);
        $criteria->addInCondition('category', array(
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_CAMPAIGNS_CREATED, 
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_CAMPAIGNS_UPDATED,
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_CAMPAIGNS_SCHEDULED,
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_CAMPAIGNS_SENT,
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_CAMPAIGNS_DELETED,
        ));
        $criteria->compare('reference_relation_id', (int)$segment->segment_id);
        CustomerActionLog::model()->deleteAll($criteria);
        
        $message = 'The segment {segmentName} belonging to the list "{listName}" has been successfully deleted!';
        $message = Yii::t('list_segments', $message, array('{segmentName}' => $segment->name, '{listName}' => $segment->list->name,)); 

        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = CustomerActionLog::CATEGORY_LISTS_SEGMENT_DELETED;
        $model->message = $message;
        return $model->save();
    }
    
    public function campaignCreated($campaign)
    {
        if (empty($this->owner->customer_id)) {
            return false;
        }
        
        $url            = Yii::app()->options->get('system.urls.customer_absolute_url');
        $url            = $url . sprintf('campaigns/%s/overview', $campaign->uid);
        $message        = 'A new campaign({type}) called "{campaignName}" has been created successfully!';
        $campaignLink   = CHtml::link($campaign->name, $url);
        $message        = Yii::t('campaigns', $message, array('{type}' => $campaign->type, '{campaignName}' => $campaignLink)); 
        
        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = empty($campaign->segment_id) ? CustomerActionLog::CATEGORY_LISTS_CAMPAIGNS_CREATED : CustomerActionLog::CATEGORY_LISTS_SEGMENT_CAMPAIGNS_CREATED;
        $model->reference_id = $campaign->campaign_id;
        $model->reference_relation_id = $campaign->list_id;
        $model->message = $message;
        return $model->save();
    }
    
    public function campaignUpdated($campaign)
    {
        if (empty($this->owner->customer_id)) {
            return false;
        }
        
        $url            = Yii::app()->options->get('system.urls.customer_absolute_url');
        $url            = $url . sprintf('campaigns/%s/overview', $campaign->uid);
        $message        = 'The campaign({type}) called "{campaignName}" has been updated!';
        $campaignLink   = CHtml::link($campaign->name, $url);
        $message        = Yii::t('campaigns', $message, array('{type}' => $campaign->type, '{campaignName}' => $campaignLink)); 
        
        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = empty($campaign->segment_id) ? CustomerActionLog::CATEGORY_LISTS_CAMPAIGNS_UPDATED : CustomerActionLog::CATEGORY_LISTS_SEGMENT_CAMPAIGNS_UPDATED;
        $model->reference_id = $campaign->campaign_id;
        $model->reference_relation_id = $campaign->list_id;
        if (!empty($campaign->segment_id)) {
            $model->reference_relation_id = $campaign->segment_id;
        }
        $model->message = $message;
        return $model->save();
    }
    
    public function campaignScheduled($campaign)
    {
        if (empty($this->owner->customer_id)) {
            return false;
        }
        
        $url            = Yii::app()->options->get('system.urls.customer_absolute_url');
        $url            = $url . sprintf('campaigns/%s/overview', $campaign->uid);
        $message        = 'The campaign({type}) called "{campaignName}" has been scheduled for sending!';
        $campaignLink   = CHtml::link($campaign->name, $url);
        $message        = Yii::t('campaigns', $message, array('{type}' => $campaign->type, '{campaignName}' => $campaignLink)); 
        
        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = empty($campaign->segment_id) ? CustomerActionLog::CATEGORY_LISTS_CAMPAIGNS_SCHEDULED : CustomerActionLog::CATEGORY_LISTS_SEGMENT_CAMPAIGNS_SCHEDULED;
        $model->reference_id = $campaign->campaign_id;
        $model->reference_relation_id = $campaign->list_id;
        $model->message = $message;
        return $model->save();
    }
    
    public function campaignSent($campaign)
    {
        if (empty($this->owner->customer_id)) {
            return false;
        }
        
        $url            = Yii::app()->options->get('system.urls.customer_absolute_url');
        $url            = $url . sprintf('campaigns/%s/overview', $campaign->uid);
        $message        = 'The campaign({type}) called "{campaignName}" has been sent!';
        $campaignLink   = CHtml::link($campaign->name, $url);
        $message        = Yii::t('campaigns', $message, array('{type}' => $campaign->type, '{campaignName}' => $campaignLink)); 
        
        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = empty($campaign->segment_id) ? CustomerActionLog::CATEGORY_LISTS_CAMPAIGNS_SENT : CustomerActionLog::CATEGORY_LISTS_SEGMENT_CAMPAIGNS_SENT;
        $model->reference_id = $campaign->campaign_id;
        $model->reference_relation_id = $campaign->list_id;
        $model->message = $message;
        return $model->save();
    }

    public function campaignDeleted($campaign)
    {
        if (empty($this->owner->customer_id)) {
            return false;
        }
        
        // remove campaign logs
        $criteria = new CDbCriteria();
        $criteria->compare('customer_id', (int)$this->owner->customer_id);
        $criteria->addInCondition('category', array(
            CustomerActionLog::CATEGORY_LISTS_CAMPAIGNS_CREATED, 
            CustomerActionLog::CATEGORY_LISTS_CAMPAIGNS_UPDATED,
            CustomerActionLog::CATEGORY_LISTS_CAMPAIGNS_SCHEDULED,
            CustomerActionLog::CATEGORY_LISTS_CAMPAIGNS_SENT,
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_CAMPAIGNS_CREATED, 
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_CAMPAIGNS_UPDATED,
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_CAMPAIGNS_SCHEDULED,
            CustomerActionLog::CATEGORY_LISTS_SEGMENT_CAMPAIGNS_SENT,
        ));
        $criteria->compare('reference_id', (int)$campaign->campaign_id);

        CustomerActionLog::model()->deleteAll($criteria);
        
        // add new logs 
        $message = 'The campaign({type}) called "{campaignName}" has been successfully deleted!';
        $message = Yii::t('campaigns', $message, array('{type}' => $campaign->type, '{campaignName}' => $campaign->name)); 
        
        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = CustomerActionLog::CATEGORY_LISTS_CAMPAIGNS_DELETED;
        $model->reference_id = $campaign->campaign_id;
        $model->reference_relation_id = $campaign->list_id;
        if (!empty($campaign->segment_id)) {
            $model->reference_relation_id = $campaign->segment_id;
        }
        $model->message = $message;
        return $model->save();
    }
    
    public function subscriberCreated($subscriber)
    {
        if (empty($this->owner->customer_id)) {
            return false;
        }
        
        $listUrl = Yii::app()->options->get('system.urls.customer_absolute_url');
        $listUrl = $listUrl . sprintf('lists/%s/overview', $subscriber->list->uid);
        
        $subUrl = Yii::app()->options->get('system.urls.customer_absolute_url');
        $subUrl = $subUrl . sprintf('lists/%s/subscribers/%s/update', $subscriber->list->uid, $subscriber->uid);

        $message    = 'A new subscriber having the email address "{email}" has been successfully added to the list "{listName}"!';
        $listLink   = CHtml::link($subscriber->list->name, $listUrl);
        $subLink    = CHtml::link($subscriber->displayEmail, $subUrl);
        $message    = Yii::t('list_subscribers', $message, array('{listName}' => $listLink, '{email}' => $subLink)); 
        
        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = CustomerActionLog::CATEGORY_LISTS_SUBSCRIBERS_CREATED;
        $model->reference_id = $subscriber->subscriber_id;
        $model->reference_relation_id = $subscriber->list_id;
        $model->message = $message;
        return $model->save();
    }
    
    public function subscriberUpdated($subscriber)
    {
        if (empty($this->owner->customer_id)) {
            return false;
        }
        
        $listUrl = Yii::app()->options->get('system.urls.customer_absolute_url');
        $listUrl = $listUrl . sprintf('lists/%s/overview', $subscriber->list->uid);
        
        $subUrl = Yii::app()->options->get('system.urls.customer_absolute_url');
        $subUrl = $subUrl . sprintf('lists/%s/subscribers/%s/update', $subscriber->list->uid, $subscriber->uid);

        $message    = 'The subscriber having the email address "{email}" has been successfully updated in the "{listName}" list!';
        $listLink   = CHtml::link($subscriber->list->name, $listUrl);
        $subLink    = CHtml::link($subscriber->displayEmail, $subUrl);
        $message    = Yii::t('list_subscribers', $message, array('{listName}' => $listLink, '{email}' => $subLink)); 
        
        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = CustomerActionLog::CATEGORY_LISTS_SUBSCRIBERS_UPDATED;
        $model->reference_id = $subscriber->subscriber_id;
        $model->reference_relation_id = $subscriber->list_id;
        $model->message = $message;
        return $model->save();
    }
    
    public function subscriberDeleted($subscriber)
    {
        if (empty($this->owner->customer_id)) {
            return false;
        }
        
        // remove subscriber logs
        $criteria = new CDbCriteria();
        $criteria->compare('customer_id', (int)$this->owner->customer_id);
        $criteria->addInCondition('category', array(
            CustomerActionLog::CATEGORY_LISTS_SUBSCRIBERS_CREATED, 
            CustomerActionLog::CATEGORY_LISTS_SUBSCRIBERS_UPDATED,
            CustomerActionLog::CATEGORY_LISTS_SUBSCRIBERS_UNSUBSCRIBED,
        ));
        $criteria->compare('reference_id', (int)$subscriber->subscriber_id);
        $criteria->compare('reference_relation_id', (int)$subscriber->list_id);
        CustomerActionLog::model()->deleteAll($criteria);
        
        // add new logs 
        $listUrl = Yii::app()->options->get('system.urls.customer_absolute_url');
        $listUrl = $listUrl . sprintf('lists/%s/overview', $subscriber->list->uid);

        $message    = 'The subscriber having the email address "{email}" has been successfully removed from the "{listName}" list!';
        $listLink   = CHtml::link($subscriber->list->name, $listUrl);
        $message    = Yii::t('list_subscribers', $message, array('{email}' => $subscriber->displayEmail, '{listName}' => $listLink)); 
        
        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = CustomerActionLog::CATEGORY_LISTS_SUBSCRIBERS_DELETED;
        $model->reference_relation_id = $subscriber->list_id;
        $model->message = $message;
        return $model->save();
    }
    
    public function subscriberUnsubscribed($subscriber)
    {
        if (empty($this->owner->customer_id)) {
            return false;
        }
        
        $listUrl = Yii::app()->options->get('system.urls.customer_absolute_url');
        $listUrl = $listUrl . sprintf('lists/%s/overview', $subscriber->list->uid);
        
        $subUrl = Yii::app()->options->get('system.urls.customer_absolute_url');
        $subUrl = $subUrl . sprintf('lists/%s/subscribers/%s/update', $subscriber->list->uid, $subscriber->uid);

        $message    = 'The subscriber having the email address "{email}" has been successfully unsubscribed from the "{listName}" list!';
        $listLink   = CHtml::link($subscriber->list->name, $listUrl);
        $subLink    = CHtml::link($subscriber->displayEmail, $subUrl);
        $message    = Yii::t('list_subscribers', $message, array('{listName}' => $listLink, '{email}' => $subLink)); 
        
        $model = new CustomerActionLog();
        $model->customer_id = $this->owner->customer_id;
        $model->category = CustomerActionLog::CATEGORY_LISTS_SUBSCRIBERS_UNSUBSCRIBED;
        $model->reference_id = $subscriber->subscriber_id;
        $model->reference_relation_id = $subscriber->list_id;
        $model->message = $message;
        return $model->save();
    }

}