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

<div class="form-group wrap-<?php echo strtolower($field->tag);?>">
    <?php echo CHtml::activeLabelEx($model, 'value');?>
    <?php echo CHtml::checkBoxList($field->tag, $values, $options, $model->getHtmlOptions('value', array(
        'template'  => '<div>{input} {label}</div>',
        'separator' => '',
    ))); ?>
    <?php echo CHtml::error($model, 'value');?>
</div>