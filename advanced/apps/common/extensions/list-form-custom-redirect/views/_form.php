<?php defined('MW_PATH') || exit('No direct script access allowed');


?>
<hr />
<div class="row">
    <div class="col-lg-9">
        <div class="form-group">
            <label><?php echo Yii::t('lists', 'Instead of the above message, redirect the subscriber to the following url:')?></label>
            <?php echo $form->textField($model, 'url', $model->getHtmlOptions('url'));?>
            <?php echo $form->error($model, 'url');?>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label><?php echo Yii::t('lists', 'After this number of seconds:');?></label>
            <?php echo $form->numberField($model, 'timeout', $model->getHtmlOptions('timeout'));?>
            <?php echo $form->error($model, 'timeout');?>
        </div>
    </div>
</div>