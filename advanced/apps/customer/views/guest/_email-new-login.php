<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * This file is part of the MailWizz EMA application.
 * 
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com> 
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.0
 */
 
?>

<!-- START CONTENT -->
<?php $url = Yii::app()->createAbsoluteUrl('guest/index');?>
<?php echo Yii::t('customers', 'Your new login is:');?><br />
<?php echo Yii::t('customers', 'Email');?>: <?php echo CHtml::encode($customer->email);?><br />
<?php echo Yii::t('customers', 'Password');?>: <?php echo $randPassword;?><br /><br />
<?php echo Yii::t('customers', 'You can login by clicking <a href="{loginUrl}">here</a>.', array(
    '{loginUrl}' => $url,
));?><br />
<?php echo Yii::t('customers', 'If for some reason the link doesn\'t work, please copy the following url into your browser address bar:');?><br />
<?php echo $url;?>
<!-- END CONTENT-->
