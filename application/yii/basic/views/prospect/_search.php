<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProspectSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prospect-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'prospect_email') ?>

    <?= $form->field($model, 'prospect_fname') ?>

    <?= $form->field($model, 'prospect_mname') ?>

    <?= $form->field($model, 'prospect_lname') ?>

    <?php // echo $form->field($model, 'prospect_contact_number') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
