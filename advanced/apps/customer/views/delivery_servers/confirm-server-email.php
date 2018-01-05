<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * This file is part of the MailWizz EMA application.
 * 
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com> 
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.3.3.1
 */
 
?>

<?php 
echo Yii::t('servers', 'Your confirmation key for the server "<em>{hostname}</em>" is:', array(
    '{hostname}' => $server->hostname,
));
?>
<br />
<a href="<?php echo ($url = $this->createAbsoluteUrl('delivery_servers/confirm', array('key' => $server->confirmation_key)));?>"><?php echo $server->confirmation_key;?></a><br />
<br />
<?php echo Yii::t('servers', 'If for some reason the above link does not work, please type the following url in your browser address bar:');?><br />
<?php echo $url;?>