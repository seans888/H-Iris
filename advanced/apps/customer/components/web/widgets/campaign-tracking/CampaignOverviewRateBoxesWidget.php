<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * CampaignOverviewRateBoxesWidget
 * 
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com> 
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.3.7.3
 */
 
class CampaignOverviewRateBoxesWidget extends CWidget 
{
    public $campaign;
    
    public function run() 
    {
        $campaign = $this->campaign;
        
        if ($campaign->status == Campaign::STATUS_DRAFT) {
            return;
        }
        
        $this->render('overview-rate-boxes', compact('campaign'));
    }
}