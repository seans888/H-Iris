<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper; 
use yii\widgets\ActiveForm; 
use app\models\Customer;

/* @var $this yii\web\View */
/* @var $model app\models\CustomerHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ch_checkin')->textInput() ?>

    <?= $form->field($model, 'ch_checkout')->textInput() ?>

    <?= $form->field($model, 'ch_numberdays')->textInput() ?>

    <?= $form->field($model, 'customer_id')->dropDownList(  
    ArrayHelper::map(Customer::find()->all(),'id','name'), 
    ['prompt'=>'Select Customer'] 
    ) ?>  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
