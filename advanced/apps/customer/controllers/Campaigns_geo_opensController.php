<?php defined('MW_PATH') || exit('No direct script access allowed');



class Campaigns_geo_opensController extends Controller
{
    /**
     * Default export limit
     */
    const DEFAULT_LIMIT = 300;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (Yii::app()->customer->getModel()->getGroupOption('campaigns.show_geo_opens', 'no') != 'yes') {
            $this->redirect(array('campaigns/index'));
        }
    }
    
    /**
     * List opens for all campaigns
     */
    public function actionIndex()
    {
        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | '. Yii::t('campaigns', 'Campaigns Geo Opens'),
            'pageHeading'       => Yii::t('campaigns', 'Campaigns Geo Opens'),
            'pageBreadcrumbs'   => array(
                Yii::t('campaigns', 'Campaigns') => $this->createUrl('campaigns/index'),
                Yii::t('campaigns', 'Geo Opens') => $this->createUrl('campaigns_geo_opens/index'),
                Yii::t('app', 'View all')
            )
        ));
        
        $this->render('index');
    }

    /**
     * Show all campaigns opens
     */
    public function actionAll()
    {
        $request  = Yii::app()->request;
        $customer = Yii::app()->customer->getModel();
        $model    = new CampaignTrackOpen();
        $model->unsetAttributes();

        $criteria = new CDbCriteria;
        $criteria->order = 't.id DESC';
        $criteria->with['campaign'] = array(
            'joinType' => 'INNER JOIN',
            'together' => true,
            'condition'=> 'campaign.customer_id = :cid',
            'params'   => array(
                ':cid' => (int)$customer->customer_id
            ),
        );

        if ($countryCode = $request->getQuery('country_code')) {
            $criteria->addInCondition('t.location_id', IpLocation::getIdsByCountryCode($countryCode));
        }

        $dataProvider = new CActiveDataProvider($model->modelName, array(
            'criteria'     => $criteria,
            'pagination'   => array(
                'pageSize' => (int)$model->paginationOptions->getPageSize(),
                'pageVar'  => 'page',
            ),
        ));

        $this->setData(array(
            'pageMetaTitle'   => $this->data->pageMetaTitle . ' | ' . Yii::t('campaign_reports', 'Campaigns Opens'),
            'pageHeading'     => Yii::t('campaign_reports', 'Campaigns Opens'),
            'pageBreadcrumbs' => array(
                Yii::t('campaigns', 'Campaigns') => $this->createUrl('campaigns/index'),
                Yii::t('campaigns', 'Geo Opens') => $this->createUrl('campaigns_geo_opens/index'),
                Yii::t('campaigns', 'View opens'),
            ),
        ));
        
        $this->setData('canExportStats', ($customer->getGroupOption('campaigns.can_export_stats', 'yes') == 'yes'));

        $this->render('open', compact('campaign', 'model', 'dataProvider'));
    }

    /**
     * Show campaigns unique opens
     */
    public function actionUnique()
    {
        $request  = Yii::app()->request;
        $customer = Yii::app()->customer->getModel();
        $model    = new CampaignTrackOpen();
        $model->unsetAttributes();

        $criteria = new CDbCriteria;
        $criteria->select = 't.*, COUNT(*) AS counter';
        $criteria->group  = 't.subscriber_id';
        $criteria->order  = 'counter DESC';

        $criteria->with['campaign'] = array(
            'joinType' => 'INNER JOIN',
            'together' => true,
            'condition'=> 'campaign.customer_id = :cid',
            'params'   => array(
                ':cid' => (int)$customer->customer_id
            ),
        );

        if ($countryCode = $request->getQuery('country_code')) {
            $criteria->addInCondition('t.location_id', IpLocation::getIdsByCountryCode($countryCode));
        }
        
        $dataProvider = new CActiveDataProvider($model->modelName, array(
            'criteria'     => $criteria,
            'pagination'   => array(
                'pageSize' => (int)$model->paginationOptions->getPageSize(),
                'pageVar'  => 'page',
            ),
        ));

        $this->setData(array(
            'pageMetaTitle'   => $this->data->pageMetaTitle . ' | ' . Yii::t('campaign_reports', 'Unique opens report'),
            'pageHeading'     => Yii::t('campaign_reports', 'Unique opens report'),
            'pageBreadcrumbs' => array(
                Yii::t('campaigns', 'Campaigns') => $this->createUrl('campaigns/index'),
                Yii::t('campaigns', 'Geo Opens') => $this->createUrl('campaigns_geo_opens/index'),
                Yii::t('campaigns', 'View opens'),
            ),
        ));
        
        $this->setData('canExportStats', ($customer->getGroupOption('campaigns.can_export_stats', 'yes') == 'yes'));

        $this->render('open-unique', compact('campaign', 'model', 'dataProvider'));
    }

    /**
     * Export campaigns opens
     */
    public function actionExport_all()
    {
        $customer = Yii::app()->customer->getModel();
        $notify   = Yii::app()->notify;
        $request  = Yii::app()->request;
        $redirect = array('campaigns_geo_opens/index');
        
        if ($customer->getGroupOption('campaigns.can_export_stats', 'yes') != 'yes') {
            $this->redirect($redirect);
        }

        if (!($fp = @fopen('php://output', 'w'))) {
            $notify->addError(Yii::t('campaign_reports', 'Cannot open export temporary file!'));
            $this->redirect($redirect);
        }

        $fileName = 'open-stats-' . $customer->customer_uid . '-' . date('Y-m-d-h-i-s') . '.csv';
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header('Content-type: application/csv');
        header("Content-Transfer-Encoding: Binary");
        header('Content-Disposition: attachment; filename="'.$fileName.'"');

        // columns
        $columns = array(
            Yii::t('campaign_reports', 'Campaign'),
            Yii::t('campaign_reports', 'Email'),
            Yii::t('campaign_reports', 'Ip address'),
            Yii::t('campaign_reports', 'User agent'),
            Yii::t('campaign_reports', 'Date added')
        );

        fputcsv($fp, $columns, ',', '"');

        // rows
        $limit  = self::DEFAULT_LIMIT;
        $offset = 0;
        
        $criteria = new CDbCriteria();
        $criteria->limit  = $limit;
        $criteria->offset = $offset;

        if ($countryCode = $request->getQuery('country_code')) {
            $criteria->addInCondition('t.location_id', IpLocation::getIdsByCountryCode($countryCode));
        }
        //

        $models = $this->getOpenModels($criteria);
        while (!empty($models)) {
            foreach ($models as $model) {
                $row = array(
                    $model->campaign->name,
                    $model->subscriber->displayEmail,
                    strip_tags($model->getIpWithLocationForGrid()),
                    $model->user_agent,
                    $model->dateAdded
                );
                fputcsv($fp, $row, ',', '"');
            }
            if (connection_status() != 0) {
                @fclose($fp);
                exit;
            }
            $criteria->offset = $criteria->offset + $criteria->limit;
            $models = $this->getOpenModels($criteria);
        }

        @fclose($fp);
        exit;
    }

    /**
     * @param CDbCriteria $defaultCriteria
     * @return CampaignTrackOpen[]
     */
    protected function getOpenModels(CDbCriteria $defaultCriteria)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 't.location_id, t.ip_address, t.user_agent, t.date_added';
        
        $criteria->with = array(
            'campaign'   => array(
                'joinType' => 'INNER JOIN',
                'together' => true,
                'condition'=> 'campaign.customer_id = :cid',
                'params'   => array(
                    ':cid' => (int)Yii::app()->customer->getId()
                ),
            ),
            'subscriber' => array(
                'select'    => 'subscriber.subscriber_id, subscriber.list_id, subscriber.email',
                'together'  => true,
                'joinType'  => 'INNER JOIN',
            ),
        );
        
        $criteria->mergeWith($defaultCriteria);
        
        return CampaignTrackOpen::model()->findAll($criteria);
    }

    /**
     * Export campaigns unique opens
     */
    public function actionExport_unique()
    {
        $customer = Yii::app()->customer->getModel();
        $notify   = Yii::app()->notify;
        $request  = Yii::app()->request;
        $redirect = array('campaigns_geo_opens/index');
        
        if ($customer->getGroupOption('campaigns.can_export_stats', 'yes') != 'yes') {
            $this->redirect($redirect);
        }

        if (!($fp = @fopen('php://output', 'w'))) {
            $notify->addError(Yii::t('campaign_reports', 'Cannot open export temporary file!'));
            $this->redirect($redirect);
        }

        $fileName = 'unique-open-stats-' . $customer->customer_uid . '-' . date('Y-m-d-h-i-s') . '.csv';
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header('Content-type: application/csv');
        header("Content-Transfer-Encoding: Binary");
        header('Content-Disposition: attachment; filename="'.$fileName.'"');

        // columns
        $columns = array(
            Yii::t('campaign_reports', 'Campaign'),
            Yii::t('campaign_reports', 'Email'),
            Yii::t('campaign_reports', 'Open times'),
            Yii::t('campaign_reports', 'Ip address'),
            Yii::t('campaign_reports', 'User agent'),
            Yii::t('campaign_reports', 'Date added')
        );

        fputcsv($fp, $columns, ',', '"');

        // rows
        $limit  = self::DEFAULT_LIMIT;
        $offset = 0;
        
        $criteria = new CDbCriteria();
        $criteria->limit  = $limit;
        $criteria->offset = $offset;

        if ($countryCode = $request->getQuery('country_code')) {
            $criteria->addInCondition('t.location_id', IpLocation::getIdsByCountryCode($countryCode));
        }

        $models = $this->getOpenUniqueModels($criteria);
        while (!empty($models)) {
            foreach ($models as $model) {
                $row = array(
                    $model->campaign->name,
                    $model->subscriber->displayEmail,
                    $model->counter,
                    strip_tags($model->getIpWithLocationForGrid()),
                    $model->user_agent,
                    $model->dateAdded
                );
                fputcsv($fp, $row, ',', '"');
            }
            if (connection_status() != 0) {
                @fclose($fp);
                exit;
            }
            $criteria->offset = $criteria->offset + $criteria->limit;
            $models = $this->getOpenUniqueModels($criteria);
        }

        @fclose($fp);
        exit;
    }

    /**
     * @param CDbCriteria $defaultCriteria
     * @return CampaignTrackOpen[]
     */
    protected function getOpenUniqueModels(CDbCriteria $defaultCriteria)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 't.location_id, t.ip_address, t.user_agent, t.date_added, COUNT(*) AS counter';
        $criteria->group  = 't.subscriber_id';
        $criteria->order  = 'counter DESC';

        $criteria->with = array(
            'campaign'   => array(
                'joinType' => 'INNER JOIN',
                'together' => true,
                'condition'=> 'campaign.customer_id = :cid',
                'params'   => array(
                    ':cid' => (int)Yii::app()->customer->getId()
                ),
            ),
            'subscriber' => array(
                'select'    => 'subscriber.subscriber_id, subscriber.list_id, subscriber.email',
                'together'  => true,
                'joinType'  => 'INNER JOIN',
            ),
        );

        $criteria->mergeWith($defaultCriteria);

        return CampaignTrackOpen::model()->findAll($criteria);
    }

}
