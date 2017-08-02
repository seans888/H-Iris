<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

<<<<<<< HEAD
<<<<<<< HEAD
=======
    <?= $form->field($model, 'id')->() ?>
>>>>>>> ff30e48954fe7a9786652e11e5841f73d20cad50

=======
>>>>>>> 57b125f4fb2a1bc3a82b331e3db02c1d01a1bd75
    <?= $form->field($model, 'customer_fname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_mname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_lname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_contact_number')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
