<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Marketeer;

/* @var $this yii\web\View */
/* @var $model app\models\Email */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-form">

    <?php $form = ActiveForm::begin(); ?>
         <?= $form->field($model, 'marketeer_id')->dropDownList( 
            ArrayHelper::map(Marketeer::find()->all(),'id','marketeer_fname'),
            ['prompt'=>'Select Marketeer'] 

        ) ?> 


    <?= $form->field($model, 'email_date')->textInput() ?>

    <?= $form->field($model, 'email_recipient')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_content')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_template')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
