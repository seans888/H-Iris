<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Customer;
use app\models\Email;

/* @var $this yii\web\View */
/* @var $model app\models\EmailCustomer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-customer-form">

    <?php $form = ActiveForm::begin(); ?>
	
	
       <?= $form->field($model, 'customer_id')->dropDownList(
    ArrayHelper::map(Customer::find()->all(),'id','name'),
    ['prompt'=>'Select Customer']) ?>


       <?= $form->field($model, 'email_id')->dropDownList(
    ArrayHelper::map(Email::find()->all(),'id','information'),
    ['prompt'=>'Select Email'])  ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
