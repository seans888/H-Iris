<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WebvisitHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webvisit-history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'wvh_date')->textInput() ?>

    <?= $form->field($model, 'wvh_time')->textInput() ?>

    <?= $form->field($model, 'wvh_ip_address')->textInput() ?>

    <?= $form->field($model, 'wvh_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wvh_cookie_information')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_id')->textInput() ?>

    <?= $form->field($model, 'Prospect_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
