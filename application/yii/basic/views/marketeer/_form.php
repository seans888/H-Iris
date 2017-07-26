<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Marketeer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="marketeer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'marketeer_fname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'marketeer_mname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'marketeer_lname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'marketeer_birthdate')->textInput() ?>

    <?= $form->field($model, 'marketeer_contact_number')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
