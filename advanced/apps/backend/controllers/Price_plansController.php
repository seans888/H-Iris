<?php defined('MW_PATH') || exit('No direct script access allowed');



class Price_plansController extends Controller
{
    public function init()
    {
        parent::init();
    }

    /**
     * Define the filters for various controller actions
     * Merge the filters with the ones from parent implementation
     */
    public function filters()
    {
        $filters = array(
            'postOnly + delete',
        );

        return CMap::mergeArray($filters, parent::filters());
    }

    /**
     * List all available price plans
     */
    public function actionIndex()
    {
        $request    = Yii::app()->request;
        $pricePlan  = new PricePlan('search');
        $pricePlan->unsetAttributes();

        $pricePlan->attributes = (array)$request->getQuery($pricePlan->modelName, array());

        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | '. Yii::t('price_plans', 'View price plans'),
            'pageHeading'       => Yii::t('price_plans', 'View price plans'),
            'pageBreadcrumbs'   => array(
                Yii::t('price_plans', 'Price plans') => $this->createUrl('price_plans/index'),
                Yii::t('app', 'View all')
            )
        ));

        $this->render('list', compact('pricePlan'));
    }

    /**
     * Create a new price plan
     */
    public function actionCreate()
    {
        $pricePlan  = new PricePlan();
        $request    = Yii::app()->request;
        $notify     = Yii::app()->notify;

        if ($request->isPostRequest && ($attributes = (array)$request->getPost($pricePlan->modelName, array()))) {
            $pricePlan->attributes = $attributes;
            if (isset(Yii::app()->params['POST'][$pricePlan->modelName]['description'])) {
                $pricePlan->description = Yii::app()->ioFilter->purify(Yii::app()->params['POST'][$pricePlan->modelName]['description']);
            }
            if (!$pricePlan->save()) {
                $notify->addError(Yii::t('app', 'Your form has a few errors, please fix them and try again!'));
            } else {
                $notify->addSuccess(Yii::t('app', 'Your form has been successfully saved!'));
            }

            Yii::app()->hooks->doAction('controller_action_save_data', $collection = new CAttributeCollection(array(
                'controller'=> $this,
                'success'   => $notify->hasSuccess,
                'pricePlan' => $pricePlan,
            )));

            if ($collection->success) {
                $this->redirect(array('price_plans/index'));
            }
        }

        $pricePlan->fieldDecorator->onHtmlOptionsSetup = array($this, '_addEditorOptions');

        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | '. Yii::t('price_plans', 'Create new price plan'),
            'pageHeading'       => Yii::t('price_plans', 'Create new price plan'),
            'pageBreadcrumbs'   => array(
                Yii::t('price_plans', 'Price plans') => $this->createUrl('price_plans/index'),
                Yii::t('app', 'Create new'),
            )
        ));

        $this->render('form', compact('pricePlan'));
    }

    /**
     * Update existing price plan
     */
    public function actionUpdate($id)
    {
        $pricePlan = PricePlan::model()->findByPk((int)$id);

        if (empty($pricePlan)) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;

        if ($request->isPostRequest && ($attributes = (array)$request->getPost($pricePlan->modelName, array()))) {
            $pricePlan->attributes = $attributes;
            if (isset(Yii::app()->params['POST'][$pricePlan->modelName]['description'])) {
                $pricePlan->description = Yii::app()->ioFilter->purify(Yii::app()->params['POST'][$pricePlan->modelName]['description']);
            }
            if (!$pricePlan->save()) {
                $notify->addError(Yii::t('app', 'Your form has a few errors, please fix them and try again!'));
            } else {
                $notify->addSuccess(Yii::t('app', 'Your form has been successfully saved!'));
            }

            Yii::app()->hooks->doAction('controller_action_save_data', $collection = new CAttributeCollection(array(
                'controller'=> $this,
                'success'   => $notify->hasSuccess,
                'pricePlan' => $pricePlan,
            )));

            if ($collection->success) {
                $this->redirect(array('price_plans/index'));
            }
        }

        $pricePlan->fieldDecorator->onHtmlOptionsSetup = array($this, '_addEditorOptions');

        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | '. Yii::t('price_plans', 'Update price plan'),
            'pageHeading'       => Yii::t('price_plans', 'Update price plan'),
            'pageBreadcrumbs'   => array(
                Yii::t('price_plans', 'Price plans') => $this->createUrl('price_plans/index'),
                Yii::t('app', 'Update'),
            )
        ));

        $this->render('form', compact('pricePlan'));
    }

    /**
     * Delete existing price plan
     */
    public function actionDelete($id)
    {
        $pricePlan = PricePlan::model()->findByPk((int)$id);

        if (empty($pricePlan)) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        $pricePlan->delete();

        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;

        $redirect = null;
        if (!$request->getQuery('ajax')) {
            $notify->addSuccess(Yii::t('app', 'The item has been successfully deleted!'));
            $redirect = $request->getPost('returnUrl', array('price_plans/index'));
        }

        // since 1.3.5.9
        Yii::app()->hooks->doAction('controller_action_delete_data', $collection = new CAttributeCollection(array(
            'controller' => $this,
            'model'      => $pricePlan,
            'redirect'   => $redirect,
        )));

        if ($collection->redirect) {
            $this->redirect($collection->redirect);
        }
    }

    /**
     * Autocomplete for price plans
     */
    public function actionAutocomplete($term)
    {
        $request = Yii::app()->request;
        if (!$request->isAjaxRequest) {
            $this->redirect(array('price_plans/index'));
        }

        $criteria = new CDbCriteria();
        $criteria->select = 'plan_id, name';
        $criteria->compare('name', $term, true);
        $criteria->limit = 10;

        $models = PricePlan::model()->findAll($criteria);
        $results = array();

        foreach ($models as $model) {
            $results[] = array(
                'plan_id' => $model->plan_id,
                'value'   => $model->name,
            );
        }

        return $this->renderJson($results);
    }

    /**
     * Callback method to setup the editor
     */
    public function _addEditorOptions(CEvent $event)
    {
        if (!in_array($event->params['attribute'], array('description'))) {
            return;
        }

        $options = array();
        if ($event->params['htmlOptions']->contains('wysiwyg_editor_options')) {
            $options = (array)$event->params['htmlOptions']->itemAt('wysiwyg_editor_options');
        }
        $options['id'] = CHtml::activeId($event->sender->owner, $event->params['attribute']);
        $event->params['htmlOptions']->add('wysiwyg_editor_options', $options);
    }
}
