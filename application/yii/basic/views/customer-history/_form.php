<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CustomerHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'customer_history_checkin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_history_checkout')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_history_numberdays')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
