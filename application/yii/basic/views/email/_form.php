<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Email */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'email_date')->textInput() ?>

    <?= $form->field($model, 'email_recipient')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_content')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_template')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'marketeer_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
