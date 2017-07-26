<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MarketeerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="marketeer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'marketeer_fname') ?>

    <?= $form->field($model, 'marketeer_mname') ?>

    <?= $form->field($model, 'marketeer_lname') ?>

    <?= $form->field($model, 'marketeer_birthdate') ?>

    <?php // echo $form->field($model, 'marketeer_contact_number') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
