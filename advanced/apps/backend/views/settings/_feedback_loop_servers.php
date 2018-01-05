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
        <h3 class="box-title"><?php echo IconHelper::make('fa-cog') . Yii::t('settings', 'Settings for processing feedback loop servers')?></h3>
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
                    <?php echo $form->labelEx($cronFeedbackModel, 'memory_limit');?>
                    <?php echo $form->dropDownList($cronFeedbackModel, 'memory_limit', $cronFeedbackModel->getMemoryLimitOptions(), $cronFeedbackModel->getHtmlOptions('memory_limit', array('data-placement' => 'right'))); ?>
                    <?php echo $form->error($cronFeedbackModel, 'memory_limit');?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <?php echo $form->labelEx($cronFeedbackModel, 'servers_at_once');?>
                    <?php echo $form->numberField($cronFeedbackModel, 'servers_at_once', $cronFeedbackModel->getHtmlOptions('servers_at_once')); ?>
                    <?php echo $form->error($cronFeedbackModel, 'servers_at_once');?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <?php echo $form->labelEx($cronFeedbackModel, 'emails_at_once');?>
                    <?php echo $form->numberField($cronFeedbackModel, 'emails_at_once', $cronFeedbackModel->getHtmlOptions('emails_at_once')); ?>
                    <?php echo $form->error($cronFeedbackModel, 'emails_at_once');?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <?php echo $form->labelEx($cronFeedbackModel, 'pause');?>
                    <?php echo $form->numberField($cronFeedbackModel, 'pause', $cronFeedbackModel->getHtmlOptions('pause')); ?>
                    <?php echo $form->error($cronFeedbackModel, 'pause');?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <?php echo $form->labelEx($cronBouncesModel, 'days_back');?>
                    <?php echo $form->numberField($cronFeedbackModel, 'days_back', $cronFeedbackModel->getHtmlOptions('days_back')); ?>
                    <?php echo $form->error($cronFeedbackModel, 'days_back');?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <?php echo $form->labelEx($cronFeedbackModel, 'subscriber_action');?>
                    <?php echo $form->dropDownList($cronFeedbackModel, 'subscriber_action', $cronFeedbackModel->getSubscriberActionOptions(), $cronFeedbackModel->getHtmlOptions('subscriber_action', array('data-placement' => 'left'))); ?>
                    <?php echo $form->error($cronFeedbackModel, 'subscriber_action');?>
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