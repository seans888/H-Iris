<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmailCustomer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-customer-form">

    <?php $form = ActiveForm::begin(); ?>

       <?= $form->field($model, 'customer_id')->dropDownList(
    ArrayHelper::map(Customer::find()->all(),'id','full'),
    ['prompt'=>'Select Customer']


       <?= $form->field($model, 'email_id')->dropDownList(
    ArrayHelper::map(Email::find()->all(),'id','content'),
    ['prompt'=>'Select Email']

    <?= $form->field($model, 'email_id')->textInput() ?>

    <?= $form->field($model, 'customer_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
