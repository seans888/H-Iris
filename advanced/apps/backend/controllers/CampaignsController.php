<?php defined('MW_PATH') || exit('No direct script access allowed');



class CampaignsController extends Controller
{
    // init
    public function init()
    {
        parent::init();
        $this->getData('pageScripts')->add(array('src' => AssetsUrl::js('campaigns.js')));
        $this->onBeforeAction = array($this, '_registerJuiBs');
    }

    /**
     * Define the filters for various controller actions
     * Merge the filters with the ones from parent implementation
     */
    public function filters()
    {
        return CMap::mergeArray(array(
            'postOnly + delete, pause_unpause, resume_sending',
        ), parent::filters());
    }

    /**
     * List available campaigns
     */
    public function actionIndex()
    {
        $campaign = new Campaign('search');
        $campaign->unsetAttributes();
        $campaign->stickySearchFilters->setStickySearchFilters();

        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | '. Yii::t('campaigns', 'Campaigns'),
            'pageHeading'       => Yii::t('campaigns', 'Campaigns'),
            'pageBreadcrumbs'   => array(
                Yii::t('campaigns', 'Campaigns') => $this->createUrl('campaigns/index'),
                Yii::t('app', 'View all')
            )
        ));

        $this->render('index', compact('campaign'));
    }

    /**
     * Show the overview for a campaign
     */
    public function actionOverview($campaign_uid)
    {
        $campaign = $this->loadCampaignModel($campaign_uid);
        $request = Yii::app()->request;

        if (!$campaign->accessOverview) {
            $this->redirect(array('campaigns/index'));
        }
        
        if ($recurring = $campaign->isRecurring) {
            Yii::import('common.vendors.JQCron.*');
            $cron = new JQCron($recurring);
            $this->setData('recurringInfo', $cron->getText(LanguageHelper::getAppLanguageCode()));
        }

        // since 1.3.5.9
        if ($campaign->isBlocked && !empty($campaign->option->blocked_reason)) {
            $message = array();
            $message[] = Yii::t('campaigns', 'This campaign is blocked because following reasons:');
            $reasons = explode("|", $campaign->option->blocked_reason);
            foreach ($reasons as $reason) {
                $message[] = Yii::t('campaigns', $reason);
            }
            $message[] = CHtml::link(Yii::t('campaigns', 'Click here to unblock it!'), $this->createUrl('campaigns/block_unblock', array('campaign_uid' => $campaign_uid)));
            Yii::app()->notify->addInfo($message);
        }
        //

        $options        = Yii::app()->options;
        $webVersionUrl  = $options->get('system.urls.frontend_absolute_url');
        $webVersionUrl .= 'campaigns/' . $campaign->campaign_uid;

        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | '. Yii::t('campaigns', 'Campaign overview'),
            'pageHeading'       => Yii::t('campaigns', 'Campaign overview'),
            'pageBreadcrumbs'   => array(
                Yii::t('campaigns', 'Campaigns') => $this->createUrl('campaigns/index'),
                $campaign->name => $this->createUrl('campaigns/overview', array('campaign_uid' => $campaign_uid)),
                Yii::t('campaigns', 'Overview')
            )
        ));
        
        $this->render('overview', compact('campaign', 'webVersionUrl'));
    }

    /**
     * Delete campaign, will remove all campaign related data
     */
    public function actionDelete($campaign_uid)
    {
        $campaign = $this->loadCampaignModel($campaign_uid);

        if ($campaign->removable) {
            $campaign->delete();
        }

        $request = Yii::app()->request;
        $notify = Yii::app()->notify;

        $redirect = null;
        if (!$request->getQuery('ajax')) {
            $notify->addSuccess(Yii::t('campaigns', 'Your campaign was successfully deleted!'));
            $redirect = $request->getPost('returnUrl', array('campaigns/index'));
        }

        // since 1.3.5.9
        Yii::app()->hooks->doAction('controller_action_delete_data', $collection = new CAttributeCollection(array(
            'controller' => $this,
            'model'      => $campaign,
            'redirect'   => $redirect,
        )));

        if ($collection->redirect) {
            $this->redirect($collection->redirect);
        }
    }

    /**
     * Allows to approve a campaign
     */
    public function actionApprove($campaign_uid)
    {
        $campaign = $this->loadCampaignModel($campaign_uid);

        if ($campaign->getCanBeApproved()) {
            $campaign->saveStatus(Campaign::STATUS_PENDING_SENDING);
        }

        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;

        if (!$request->getQuery('ajax')) {
            $notify->addSuccess(Yii::t('campaigns', 'Your campaign was successfully changed!'));
            $this->redirect($request->getPost('returnUrl', array('campaigns/index')));
        }
    }

    /**
     * Allows to block/unblock a campaign
     */
    public function actionBlock_unblock($campaign_uid)
    {
        $campaign = $this->loadCampaignModel($campaign_uid);

        $campaign->blockUnblock();

        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;

        if (!$request->getQuery('ajax')) {
            $notify->addSuccess(Yii::t('campaigns', 'Your campaign was successfully changed!'));
            $this->redirect($request->getPost('returnUrl', array('campaigns/index')));
        }
    }

    /**
     * Allows to pause/unpause the sending of a campaign
     */
    public function actionPause_unpause($campaign_uid)
    {
        $campaign = $this->loadCampaignModel($campaign_uid);

        $campaign->pauseUnpause();

        $request = Yii::app()->request;
        $notify = Yii::app()->notify;

        if (!$request->getQuery('ajax')) {
            $notify->addSuccess(Yii::t('campaigns', 'Your campaign was successfully changed!'));
            $this->redirect($request->getPost('returnUrl', array('campaigns/index')));
        }
    }

    /**
     * Allows to resume sending of a stuck campaign
     */
    public function actionResume_sending($campaign_uid)
    {
        $campaign = $this->loadCampaignModel($campaign_uid);

        if ($campaign->isProcessing) {
            $campaign->status = Campaign::STATUS_SENDING;
            $campaign->save(false);
        }

        $request = Yii::app()->request;
        $notify = Yii::app()->notify;

        if (!$request->isAjaxRequest) {
            $notify->addSuccess(Yii::t('campaigns', 'Your campaign was successfully changed!'));
            $this->redirect($request->getPost('returnUrl', array('campaigns/index')));
        }
    }

    /**
     * Allows to mark a campaign as sent
     */
    public function actionMarksent($campaign_uid)
    {
        $campaign = $this->loadCampaignModel($campaign_uid);
        $campaign->markAsSent();

        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;

        if (!$request->isAjaxRequest) {
            $notify->addSuccess(Yii::t('campaigns', 'Your campaign was successfully changed!'));
            $this->redirect($request->getPost('returnUrl', array('campaigns/index')));
        }
    }

    /**
     * Run a bulk action against the campaigns
     */
    public function actionBulk_action()
    {
        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;

        $action = $request->getPost('bulk_action');
        $items  = array_unique((array)$request->getPost('bulk_item', array()));

        if ($action == Campaign::BULK_ACTION_DELETE && count($items)) {
            $affected = 0;
            foreach ($items as $item) {
                if (!($campaign = $this->loadCampaignModel($item))) {
                    continue;
                }
                if (!$campaign->removable) {
                    continue;
                }
                $campaign->delete();
                $affected++;
                if ($logAction = $campaign->customer->asa('logAction')) {
                    $logAction->campaignDeleted($campaign);
                }
            }
            if ($affected) {
                $notify->addSuccess(Yii::t('app', 'The action has been successfully completed!'));
            }
        } elseif ($action == Campaign::BULK_ACTION_COPY && count($items)) {
            $affected = 0;
            foreach ($items as $item) {
                if (!($campaign = $this->loadCampaignModel($item))) {
                    continue;
                }
                $customer = $campaign->customer;
                if (($maxCampaigns = (int)$customer->getGroupOption('campaigns.max_campaigns', -1)) > -1) {
                    $criteria = new CDbCriteria();
                    $criteria->compare('customer_id', (int)$customer->customer_id);
                    $criteria->addNotInCondition('status', array(Campaign::STATUS_PENDING_DELETE));
                    $campaignsCount = Campaign::model()->count($criteria);
                    if ($campaignsCount >= $maxCampaigns) {
                        continue;
                    }
                }
                if (!$campaign->copy()) {
                    continue;
                }
                $affected++;
            }
            if ($affected) {
                $notify->addSuccess(Yii::t('app', 'The action has been successfully completed!'));
            }
        } elseif ($action == Campaign::BULK_ACTION_PAUSE_UNPAUSE && count($items)) {
            $affected = 0;
            foreach ($items as $item) {
                if (!($campaign = $this->loadCampaignModel($item))) {
                    continue;
                }
                $campaign->pauseUnpause();
                $affected++;
            }
            if ($affected) {
                $notify->addSuccess(Yii::t('app', 'The action has been successfully completed!'));
            }
        } elseif ($action == Campaign::BULK_ACTION_MARK_SENT && count($items)) {
            $affected = 0;
            foreach ($items as $item) {
                if (!($campaign = $this->loadCampaignModel($item))) {
                    continue;
                }
                if (!$campaign->markAsSent()) {
                    continue;
                }
                $affected++;
            }
            if ($affected) {
                $notify->addSuccess(Yii::t('app', 'The action has been successfully completed!'));
            }
        }

        $defaultReturn = $request->getServer('HTTP_REFERER', array('campaigns/index'));
        $this->redirect($request->getPost('returnUrl', $defaultReturn));
    }

    /**
     * Helper method to load the campaign AR model
     */
    public function loadCampaignModel($campaign_uid)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('campaign_uid', $campaign_uid);
        $criteria->addNotInCondition('status', array(Campaign::STATUS_PENDING_DELETE));

        $model = Campaign::model()->find($criteria);

        if($model === null) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        if ($model->isPendingDelete) {
            $this->redirect(array('campaigns/index'));
        }

        return $model;
    }

    /**
     * Callback to register Jquery ui bootstrap only for certain actions
     */
    public function _registerJuiBs($event)
    {
        if (in_array($event->params['action']->id, array('index'))) {
            $this->getData('pageStyles')->mergeWith(array(
                array('src' => Yii::app()->apps->getBaseUrl('assets/css/jui-bs/jquery-ui-1.10.3.custom.css'), 'priority' => -1001),
            ));
        }
    }
}
