<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Template;
use app\models\Customer;

/* @var $this yii\web\View */
/* @var $model app\models\Email */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email_status')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'template_id')->dropDownList(  
    ArrayHelper::map(Template::find()->all(),'id','information'), 
    ['prompt'=>'Select Template'] 
    ) ?>  

     <?= $form->field($model, 'customer_id')->dropDownList(  
    ArrayHelper::map(Customer::find()->all(),'id','email'), 
    ['prompt'=>'Select Customer'] 
    ) ?>  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
