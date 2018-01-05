<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class MaxmindController extends Controller
{
    /**
     * Maxmind DB info
     */
    public function actionIndex()
    {
        $model = new MaxmindDatabase();
        
        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | ' . Yii::t('ip_location', 'MaxMind.com database'), 
            'pageHeading'       => Yii::t('ip_location', 'MaxMind.com database'),
            'pageBreadcrumbs'   => array(
                Yii::t('ip_location', 'MaxMind.com database'),
            ),
        ));
        
        MaxmindDatabase::addNotifyErrorIfMissingDbFile();
        
        $this->render('index', compact('model'));
    }

}