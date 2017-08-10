<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\ProspectEmailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prospect-email-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'prospect_fname') ?>
     
    <?= $form->field($model, 'email_id') ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>

        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
