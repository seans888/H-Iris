<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * This file is part of the MailWizz EMA application.
 *
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com>
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.4.4
 */

?>

<?php echo Yii::t('campaigns', 'Hello');?>,<br />
<?php echo Yii::t('campaigns', 'You have been invited to view reports for the campaign "{campaign}".', array(
    '{campaign}' => $shareReports->campaign->name,
));?><br />
<?php echo Yii::t('campaigns', 'Url');?>: <a href="<?php echo $shareReports->getShareUrl();?>"><?php echo $shareReports->getShareUrl();?></a><br />
<?php echo Yii::t('campaigns', 'Password');?>: <?php echo $shareReports->share_reports_password; ?><br />
