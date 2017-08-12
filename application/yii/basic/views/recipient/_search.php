<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecipientSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipient-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'recipient_type') ?>

    <?= $form->field($model, 'recipient_email') ?>

    <?= $form->field($model, 'recipient_fname') ?>

    <?= $form->field($model, 'recipient_mname') ?>

    <?php // echo $form->field($model, 'recipient_lname') ?>

    <?php // echo $form->field($model, 'recipient_contact_number') ?>

    <?php // echo $form->field($model, 'customer_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
