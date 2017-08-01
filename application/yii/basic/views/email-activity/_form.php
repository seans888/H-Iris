<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmailActivity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email_activity_status')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'email_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
