<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class Ip_location_servicesController extends Controller
{

    /**
     * Display available services
     */
    public function actionIndex()
    {
        $request = Yii::app()->request;
        $model = new IpLocationServicesList();
        
        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | ' . Yii::t('ip_location', 'Ip location services'), 
            'pageHeading'       => Yii::t('ip_location', 'Ip location services'),
            'pageBreadcrumbs'   => array(
                Yii::t('ip_location', 'Ip location services'),
            ),
        ));
        
        $this->render('index', compact('model'));
    }

}