<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class Payment_gatewaysController extends Controller
{
    /**
     * Display available gateways
     */
    public function actionIndex()
    {
        $request = Yii::app()->request;
        $model = new PaymentGatewaysList();
        
        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | ' . Yii::t('payment_gateways', 'Payment gateways'), 
            'pageHeading'       => Yii::t('payment_gateways', 'Payment gateways'),
            'pageBreadcrumbs'   => array(
                Yii::t('payment_gateways', 'Payment gateways'),
            ),
        ));
        
        $this->render('index', compact('model'));
    }

}