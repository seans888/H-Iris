<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * This file is part of the MailWizz EMA application.
 *
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com>
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.4.5
 */

?>
<div class="box box-primary borderless">
    <div class="box-header">
        <h3 class="box-title"><?php echo IconHelper::make('fa-cog') . Yii::t('settings', 'Settings for processing email box monitors')?></h3>
    </div>
    <div class="box-body">
        <?php
        /**
         * This hook gives a chance to prepend content before the active form fields.
         * Please note that from inside the action callback you can access all the controller view variables
         * via {@CAttributeCollection $collection->controller->data}
         * @since 1.3.3.1
         */
        $hooks->doAction('before_active_form_fields', new CAttributeCollection(array(
            'controller' => $this,
            'form'       => $form
        )));
        ?>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <?php echo $form->labelEx($cronEmailBoxModel, 'memory_limit');?>
                    <?php echo $form->dropDownList($cronEmailBoxModel, 'memory_limit', $cronEmailBoxModel->getMemoryLimitOptions(), $cronEmailBoxModel->getHtmlOptions('memory_limit', array('data-placement' => 'right'))); ?>
                    <?php echo $form->error($cronEmailBoxModel, 'memory_limit');?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <?php echo $form->labelEx($cronEmailBoxModel, 'servers_at_once');?>
                    <?php echo $form->numberField($cronEmailBoxModel, 'servers_at_once', $cronEmailBoxModel->getHtmlOptions('servers_at_once')); ?>
                    <?php echo $form->error($cronEmailBoxModel, 'servers_at_once');?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <?php echo $form->labelEx($cronEmailBoxModel, 'emails_at_once');?>
                    <?php echo $form->numberField($cronEmailBoxModel, 'emails_at_once', $cronEmailBoxModel->getHtmlOptions('emails_at_once')); ?>
                    <?php echo $form->error($cronEmailBoxModel, 'emails_at_once');?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <?php echo $form->labelEx($cronEmailBoxModel, 'pause');?>
                    <?php echo $form->numberField($cronEmailBoxModel, 'pause', $cronEmailBoxModel->getHtmlOptions('pause')); ?>
                    <?php echo $form->error($cronEmailBoxModel, 'pause');?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <?php echo $form->labelEx($cronBouncesModel, 'days_back');?>
                    <?php echo $form->numberField($cronEmailBoxModel, 'days_back', $cronEmailBoxModel->getHtmlOptions('days_back')); ?>
                    <?php echo $form->error($cronEmailBoxModel, 'days_back');?>
                </div>
            </div>
        </div>
        <?php
        /**
         * This hook gives a chance to append content after the active form fields.
         * Please note that from inside the action callback you can access all the controller view variables
         * via {@CAttributeCollection $collection->controller->data}
         * @since 1.3.3.1
         */
        $hooks->doAction('after_active_form_fields', new CAttributeCollection(array(
            'controller'        => $this,
            'form'              => $form
        )));
        ?>
        <div class="clearfix"><!-- --></div>
    </div>
</div>
<hr />