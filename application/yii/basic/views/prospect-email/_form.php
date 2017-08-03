<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Prospect;
use app\models\Email;

/* @var $this yii\web\View */
/* @var $model app\models\ProspectEmail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prospect-email-form">

  

     <?php $form = ActiveForm::begin(); ?>
         <?= $form->field($model, 'prospect_id')->dropDownList( 
            ArrayHelper::map(Prospect::find()->all(),'id','fullName'),
            ['prompt'=>'Select Prospect'])
           ?> 

           <?= $form->field($model, 'email_id')->dropDownList( 
            ArrayHelper::map(Email::find()->all(),'id','information'),
            ['prompt'=>'Select email_id'])
           ?> 

   


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
