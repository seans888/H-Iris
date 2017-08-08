<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper; 
use yii\widgets\ActiveForm; 
use app\models\Activity; 

/* @var $this yii\web\View */
/* @var $model app\models\Email */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-form">
    <?php $form = ActiveForm::begin(); ?>
    


    <?= $form->field($model, 'email_recipient')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_content')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_template')->textInput(['maxlength' => true]) ?>


  
    <?= $form->field($model, 'email_activity_id')->dropDownList(  
    ArrayHelper::map(Activity::find()->all(),'id','activity_status'), 
    ['prompt'=>'Select Activity'] 
    ) ?>  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
