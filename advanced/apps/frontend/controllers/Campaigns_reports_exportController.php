<?php defined('MW_PATH') || exit('No direct script access allowed');



require_once Yii::getPathOfAlias('customer.controllers.Campaign_reports_exportController') . '.php';

class Campaigns_reports_exportController extends Campaign_reports_exportController
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $campaign_uid = Yii::app()->request->getQuery('campaign_uid');
        $session      = Yii::app()->session;
        if (!isset($session['campaign_reports_access_' . $campaign_uid])) {
            return $this->redirect(array('campaigns_reports/login', 'campaign_uid' => $campaign_uid));
        }

        $campaign = Campaign::model()->findByUid($campaign_uid);
        if (empty($campaign)) {
            unset($session['campaign_reports_access_' . $campaign_uid]);
            return $this->redirect(array('campaigns_reports/login', 'campaign_uid' => $campaign_uid));
        }
        $this->customerId = $campaign->customer_id;
        
        parent::init();
    }
    
}
