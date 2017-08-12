<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper; 
use yii\widgets\ActiveForm; 
use app\models\Recipient;
/* @var $this yii\web\View */
/* @var $model app\models\WebvisitHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webvisit-history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'wvh_date')->textInput() ?>

    <?= $form->field($model, 'wvh_time')->textInput() ?>

    <?= $form->field($model, 'wvh_ip_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wvh_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wvh_cookie_information')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'recipient_id')->dropDownList(  
    ArrayHelper::map(Recipient::find()->all(),'id'), 
    ['prompt'=>'Select Recipient'] 
    ) ?> 
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
