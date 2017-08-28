<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper; 
use app\models\Email; 

/* @var $this yii\web\View */
/* @var $model app\models\Activity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'activity_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activity_description')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'email_id')->dropDownList(  
    ArrayHelper::map(Email::find()->all(),'id','information'), 
    ['prompt'=>'Select Information'] 
    ) ?> 
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
