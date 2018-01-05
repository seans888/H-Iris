<?php defined('MW_PATH') || exit('No direct script access allowed');



echo CHtml::form(array('price_plans/order'), 'post', array());
?>
<p class="text-muted well well-sm no-shadow" style="margin-top: 10px; padding: 16px">
    <?php echo Yii::t('ext_payment_gateway_offline', 'Offline payment');?><br />
</p>
<p><?php echo nl2br($model->description);?></p>
<p><button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> <?php echo Yii::t('price_plans', 'Place offline order')?></button></p>
<?php echo CHtml::endForm(); ?>