<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class Ip_location_services_ext_freegeoipController extends Controller
{
    // init the controller
    public function init()
    {
        parent::init();
        Yii::import('ext-ip-location-freegeoip.backend.models.*');
    }
    
    // move the view path
    public function getViewPath()
    {
        return Yii::getPathOfAlias('ext-ip-location-freegeoip.backend.views');
    }
    
    /**
     * Default action.
     */
    public function actionIndex()
    {
        $extensionInstance = Yii::app()->extensionsManager->getExtensionInstance('ip-location-freegeoip');
        
        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;
        
        $model = new IpLocationFreegeoipExtModel();
        $model->populate($extensionInstance);

        if ($request->isPostRequest && ($attributes = (array)$request->getPost($model->modelName, array()))) {
            $model->attributes = $attributes;
            if ($model->validate()) {
                $notify->addSuccess(Yii::t('app', 'Your form has been successfully saved!'));
                $model->save($extensionInstance);
            } else {
                $notify->addError(Yii::t('app', 'Your form has a few errors, please fix them and try again!'));
            }
        }
        
        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | '. Yii::t('ext_ip_location_freegeoip', 'Ip location service from Freegeoip.net'),
            'pageHeading'       => Yii::t('ext_ip_location_freegeoip', 'Ip location service from Freegeoip.net'),
            'pageBreadcrumbs'   => array(
                Yii::t('ip_location', 'Ip location services') => $this->createUrl('ip_location_services/index'),
                Yii::t('ext_ip_location_freegeoip', 'Ip location service from Freegeoip.net'),
            )
        ));

        $this->render('settings', compact('model'));
    }
}