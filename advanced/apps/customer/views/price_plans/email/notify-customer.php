<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * This file is part of the MailWizz EMA application.
 * 
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com> 
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.3.4.5
 */
 
?>

<?php echo Yii::t('orders', 'Hello {name}', array('{name}' => '{name}'));?>,<br />
<?php echo Yii::t('orders', 'Your new order has been placed on {site} website as follows:', array('{site}' => $options->get('system.common.site_name', 'Marketing website') ));?>
<br /><br />
<table>
    <tr>
        <th><?php echo Yii::t('orders', 'Price plan');?></th>
        <td><?php echo $order->plan->name;?></td>
    </tr>
    <tr>
        <th><?php echo Yii::t('orders', 'Subtotal')?>:</th>
        <td><?php echo $order->formattedSubtotal;?></td>
    </tr>
    <tr>
        <th><?php echo Yii::t('orders', 'Tax')?>:</th>
        <td><?php echo $order->formattedTaxValue;?></td>
    </tr>
    <tr>
        <th><?php echo Yii::t('orders', 'Discount')?>:</th>
        <td><?php echo $order->formattedDiscount;?></td>
    </tr>
    <tr>
        <th><?php echo Yii::t('orders', 'Total')?>:</th>
        <td><?php echo $order->formattedTotal;?></td>
    </tr>
    <tr>
        <th><?php echo Yii::t('orders', 'Status')?>:</th>
        <td><?php echo $order->statusName;?></td>
    </tr>
</table>
<br /><br />
<?php echo Yii::t('orders', 'You can view the full order if you login into the application at:');?><br />
<?php 
    $url = Yii::app()->apps->getAppUrl('customer', sprintf('price-plans/orders/%s', $order->order_uid), true);
    echo CHtml::link($url, $url);
?>
