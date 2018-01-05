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
<div class="box box-primary borderless">
    <div class="box-header">
        <h3 class="box-title"><?php echo IconHelper::make('fa-cog') . Yii::t('settings', 'Settings for processing bounce servers')?></h3>
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
            'controller'        => $this,
            'form'              => $form
        )));
        ?>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <?php echo $form->labelEx($cronBouncesModel, 'memory_limit');?>
                    <?php echo $form->dropDownList($cronBouncesModel, 'memory_limit', $cronBouncesModel->getMemoryLimitOptions(), $cronBouncesModel->getHtmlOptions('memory_limit', array('data-placement' => 'right'))); ?>
                    <?php echo $form->error($cronBouncesModel, 'memory_limit');?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <?php echo $form->labelEx($cronBouncesModel, 'servers_at_once');?>
                    <?php echo $form->numberField($cronBouncesModel, 'servers_at_once', $cronBouncesModel->getHtmlOptions('servers_at_once')); ?>
                    <?php echo $form->error($cronBouncesModel, 'servers_at_once');?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <?php echo $form->labelEx($cronBouncesModel, 'emails_at_once');?>
                    <?php echo $form->numberField($cronBouncesModel, 'emails_at_once', $cronBouncesModel->getHtmlOptions('emails_at_once')); ?>
                    <?php echo $form->error($cronBouncesModel, 'emails_at_once');?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <?php echo $form->labelEx($cronBouncesModel, 'pause');?>
                    <?php echo $form->numberField($cronBouncesModel, 'pause', $cronBouncesModel->getHtmlOptions('pause')); ?>
                    <?php echo $form->error($cronBouncesModel, 'pause');?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <?php echo $form->labelEx($cronBouncesModel, 'days_back');?>
                    <?php echo $form->numberField($cronBouncesModel, 'days_back', $cronBouncesModel->getHtmlOptions('days_back')); ?>
                    <?php echo $form->error($cronBouncesModel, 'days_back');?>
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