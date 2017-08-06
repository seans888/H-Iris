<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Customer;
use app\models\Preference;

/* @var $this yii\web\View */
/* @var $model app\models\CustomerPreference */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-preference-form">

    <?php $form = ActiveForm::begin(); ?>

<<<<<<< HEAD
    <?= $form->field($model, 'customer_id')->dropDownList( 
            ArrayHelper::map(Customer::find()->all(),'id','name'),
            ['prompt'=>'Select Customer'])
           ?> 

           <?= $form->field($model, 'preference_id')->dropDownList( 
            ArrayHelper::map(Preference::find()->all(),'id','information'),
            ['prompt'=>'Select Preference'])
           ?> 
=======

  <?php $form = ActiveForm::begin(); ?>
         <?= $form->field($model, 'customer_id')->dropDownList( 
            ArrayHelper::map(Customer::find()->all(),'id','name'),
            ['prompt'=>'Select Customer']


        ) ?> 

  <?php $form = ActiveForm::begin(); ?>
         <?= $form->field($model, 'preference_id')->dropDownList( 
            ArrayHelper::map(Preference::find()->all(),'id','information'),
            ['prompt'=>'Select Preference']


        ) ?> 
>>>>>>> 141ebc8666a9f8e04304c85e35d048ed5cbca640

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
