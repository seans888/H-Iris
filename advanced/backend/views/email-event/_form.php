<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper; 
use yii\widgets\ActiveForm; 
use app\models\Event; 
use app\models\Email; 
/* @var $this yii\web\View */
/* @var $model app\models\EmailEvent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-event-form">

    <?php $form = ActiveForm::begin(); ?>

       <?= $form->field($model, 'event_id')->dropDownList(  
    ArrayHelper::map(Event::find()->all(),'id','event_description'), 
    ['prompt'=>'Select Event'] 
    ) ?>  
     <?= $form->field($model, 'email_id')->dropDownList(  
    ArrayHelper::map(Email::find()->all(),'id','information'), 
    ['prompt'=>'Select Email'] 
    ) ?>  
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
