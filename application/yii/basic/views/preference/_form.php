<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Preference */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="preference-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'preference_category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'preference_description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
