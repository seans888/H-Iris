<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'customer_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_fname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_mname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_lname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_contact_number')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
