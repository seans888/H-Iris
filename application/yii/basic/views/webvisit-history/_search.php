<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WebvisitHistorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webvisit-history-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'wvh_date') ?>

    <?= $form->field($model, 'wvh_time') ?>

    <?= $form->field($model, 'wvh_ip_address') ?>

    <?= $form->field($model, 'wvh_url') ?>

    <?php // echo $form->field($model, 'wvh_cookie_information') ?>

    <?php // echo $form->field($model, 'customer_id') ?>

    <?php // echo $form->field($model, 'Prospect_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
