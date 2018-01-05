<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * This file is part of the MailWizz EMA application.
 * 
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com> 
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.3.7.5
 */
 
?>

<div class="form-group country-field wrap-<?php echo strtolower($field->tag);?>">
    <?php echo CHtml::activeLabelEx($model, 'value');?>
    <?php echo CHtml::dropDownList($field->tag, $model->value, $countriesList, $model->getHtmlOptions('value', array(
        'data-states-url' => Yii::app()->createUrl('lists/fields_country_states_by_country_name'),
    ))); ?>
    <?php echo CHtml::error($model, 'value');?>
</div>