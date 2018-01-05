<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * CampaignTrackingTopClickedLinksWidget
 * 
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com> 
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.0
 */
 
class CampaignTrackingTopClickedLinksWidget extends CWidget 
{
    public $campaign;
    
    public $showDetailLinks = true;
    
    public function run() 
    {
        $campaign = $this->campaign;
        
        if ($campaign->status == Campaign::STATUS_DRAFT) {
            return;
        }
        
        if ($campaign->option->url_tracking != CampaignOption::TEXT_YES) {
            return;
        }
        
        $criteria = new CDbCriteria();
        $criteria->select = 't.*, (SELECT COUNT(*) FROM {{campaign_track_url}} WHERE url_id = t.url_id) as counter';
        $criteria->compare('t.campaign_id', $campaign->campaign_id);
        $criteria->order = 'counter DESC';
        $criteria->limit = 10;
        
        $models = CampaignUrl::model()->findAll($criteria);
        if (empty($models)) {
            return;
        }
        
        $this->render('top-clicked-links', compact('campaign', 'models'));
    }
}