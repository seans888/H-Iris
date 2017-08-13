<?php

use yii\helpers\ArrayHelper; 
use yii\widgets\ActiveForm; 
use app\models\Customer;

/* @var $this yii\web\View */
/* @var $model app\models\Recipient */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipient-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'recipient_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recipient_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recipient_fname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recipient_mname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recipient_lname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recipient_contact_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_id')->dropDownList(  
    ArrayHelper::map(Customer::find()->all(),'id'), 
    ['prompt'=>'Select Customer'] 
    ) ?>  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
