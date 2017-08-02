<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Email;
/* @var $this yii\web\View */
/* @var $model app\models\EmailActivity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-activity-form">

    <?php $form = ActiveForm::begin(); ?>
    		<?= $form->field($model, 'email_id')->dropDownList( 
            ArrayHelper::map(Email::find()->all(),'id','information'),
            ['prompt'=>'Select Email']
) ?> 

    <?= $form->field($model, 'email_activity_status')->textInput(['maxlength' => true]) ?>




    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
