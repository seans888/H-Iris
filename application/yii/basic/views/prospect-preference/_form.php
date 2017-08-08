<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Prospect;
use app\models\Preference;
/* @var $this yii\web\View */
/* @var $model app\models\ProspectPreference */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prospect-preference-form">

    <?php $form = ActiveForm::begin(); ?>

   
    
         <?= $form->field($model, 'prospect_id')->dropDownList( 
            ArrayHelper::map(Prospect::find()->all(),'id','name'),
            ['prompt'=>'Select Prospect']


        ) ?> 

   
     
         <?= $form->field($model, 'preference_id')->dropDownList( 
            ArrayHelper::map(Preference::find()->all(),'id','information'),
            ['prompt'=>'Select Preference']


        ) ?> 

        

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
