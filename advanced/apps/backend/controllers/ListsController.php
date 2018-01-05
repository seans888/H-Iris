<?php defined('MW_PATH') || exit('No direct script access allowed');



class ListsController extends Controller
{
    public function init()
    {
        $this->getData('pageScripts')->add(array('src' => AssetsUrl::js('lists.js')));
        parent::init();
    }
    
    /**
     * Show available lists
     */
    public function actionIndex()
    {
        $request = Yii::app()->request;
        $list = new Lists('search');
        $list->unsetAttributes();
        $list->attributes = (array)$request->getQuery($list->modelName, array());
        
        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | ' . Yii::t('lists', 'Email lists'),
            'pageHeading'       => Yii::t('lists', 'Email lists'),
            'pageBreadcrumbs'   => array(
                Yii::t('lists', 'Email lists') => $this->createUrl('lists/index'),
                Yii::t('app', 'View all')
            )
        ));

        $this->render('list', compact('list'));
    }
    
    /**
     * Display list overview
     * This is a page containing shortcuts to the most important list features.
     */
    public function actionOverview($list_uid)
    {
        $list = $this->loadModel($list_uid);

        if ($list->isPendingDelete) {
            $this->redirect(array('lists/index'));
        }
        
        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | ' . Yii::t('lists', 'List overview'),
            'pageHeading'       => Yii::t('lists', 'List overview'),
            'pageBreadcrumbs'   => array(
                Yii::t('lists', 'Lists') => $this->createUrl('lists/index'),
                $list->name => $this->createUrl('lists/overview', array('list_uid' => $list->list_uid)),
                Yii::t('lists', 'Overview')
            )
        ));
        
        $confirmedSubscribersCount = $list->confirmedSubscribersCount;
        $subscribersCount          = $list->subscribersCount;
        $segmentsCount             = $list->activeSegmentsCount;
        $customFieldsCount         = $list->fieldsCount;
        $pagesCount                = ListPageType::model()->count();

        $this->render('overview', compact(
            'list', 
            'confirmedSubscribersCount', 
            'subscribersCount', 
            'segmentsCount', 
            'customFieldsCount', 
            'pagesCount'
        ));
    }

    /**
     * Delete existing list
     */
    public function actionDelete($list_uid)
    {
        $list    = $this->loadModel($list_uid);
        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;

        if (!$list->isRemovable) {
            $this->redirect(array('lists/index'));
        }

        if ($request->isPostRequest) {

            $list->delete();

            if ($logAction = Yii::app()->customer->getModel()->asa('logAction')) {
                $logAction->listDeleted($list);
            }

            $notify->addSuccess(Yii::t('app', 'Your item has been successfully deleted!'));
            $redirect = $request->getPost('returnUrl', array('lists/index'));

            // since 1.3.5.9
            Yii::app()->hooks->doAction('controller_action_delete_data', $collection = new CAttributeCollection(array(
                'controller' => $this,
                'model'      => $list,
                'redirect'   => $redirect,
            )));

            if ($collection->redirect) {
                $this->redirect($collection->redirect);
            }
        }

        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | ' . Yii::t('lists', 'Confirm list removal'),
            'pageHeading'       => Yii::t('lists', 'Confirm list removal'),
            'pageBreadcrumbs'   => array(
                Yii::t('lists', 'Lists') => $this->createUrl('lists/index'),
                $list->name => $this->createUrl('lists/overview', array('list_uid' => $list->list_uid)),
                Yii::t('lists', 'Confirm list removal')
            )
        ));

        $campaign = new Campaign();
        $campaign->unsetAttributes();
        $campaign->attributes  = (array)$request->getQuery($campaign->modelName, array());
        $campaign->list_id     = $list->list_id;

        $this->render('delete', compact('list', 'campaign'));
    }

    /**
     * Helper method to load the list AR model
     */
    public function loadModel($list_uid)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('list_uid', $list_uid);
        $criteria->addNotInCondition('status', array(Lists::STATUS_PENDING_DELETE));

        $model = Lists::model()->find($criteria);

        if ($model === null) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        if ($model->isPendingDelete) {
            $this->redirect(array('lists/index'));
        }

        return $model;
    }
}
