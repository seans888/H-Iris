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

/**
 * This hook gives a chance to prepend content or to replace the default view content with a custom content.
 * Please note that from inside the action callback you can access all the controller view
 * variables via {@CAttributeCollection $collection->controller->data}
 * In case the content is replaced, make sure to set {@CAttributeCollection $collection->renderContent} to false 
 * in order to stop rendering the default content.
 * @since 1.3.3.1
 */
$hooks->doAction('before_view_file_content', $viewCollection = new CAttributeCollection(array(
    'controller'    => $this,
    'renderContent' => true,
)));

// and render if allowed
if ($viewCollection->renderContent) {
    /**
     * @since 1.3.9.2
     */
    $itemsCount = EmailBoxMonitor::model()->countByAttributes(array(
        'customer_id' => $server->customer_id,
    ));
    ?>
    <div class="box box-primary borderless">
        <div class="box-header">
            <div class="pull-left">
                <?php BoxHeaderContent::make(BoxHeaderContent::LEFT)
                    ->add('<h3 class="box-title">' . IconHelper::make('glyphicon-transfer') . $pageHeading . '</h3>')
                    ->render();
                ?>
            </div>
            <div class="pull-right">
                <?php BoxHeaderContent::make(BoxHeaderContent::RIGHT)
                    ->addIf($this->widget('common.components.web.widgets.GridViewToggleColumns', array('model' => $server, 'columns' => array('hostname', 'username', 'service', 'port', 'protocol', 'status')), true), $itemsCount)
                    ->add(HtmlHelper::accessLink(IconHelper::make('create') . Yii::t('app', 'Create new'), array('email_box_monitors/create'), array('class' => 'btn btn-primary btn-flat', 'title' => Yii::t('app', 'Create new'))))
                    ->add(HtmlHelper::accessLink(IconHelper::make('refresh') . Yii::t('app', 'Refresh'), array('email_box_monitors/index'), array('class' => 'btn btn-primary btn-flat', 'title' => Yii::t('app', 'Refresh'))))
                    ->add(CHtml::link(IconHelper::make('info'), '#page-info', array('class' => 'btn btn-primary btn-flat', 'title' => Yii::t('app', 'Info'), 'data-toggle' => 'modal')))
                    ->render();
                ?>
            </div>
            <div class="clearfix"><!-- --></div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
            <?php 
            /**
             * This hook gives a chance to prepend content or to replace the default grid view content with a custom content.
             * Please note that from inside the action callback you can access all the controller view
             * variables via {@CAttributeCollection $collection->controller->data}
             * In case the content is replaced, make sure to set {@CAttributeCollection $collection->renderGrid} to false 
             * in order to stop rendering the default content.
             * @since 1.3.3.1
             */
            $hooks->doAction('before_grid_view', $collection = new CAttributeCollection(array(
                'controller'  => $this,
                'renderGrid'  => true,
            )));

            /**
             * This widget renders default getting started page for this particular section.
             * @since 1.3.9.2
             */
            $this->widget('common.components.web.widgets.StartPagesWidget', array(
                'collection' => $collection,
                'enabled'    => !$itemsCount,
            ));
            
            // and render if allowed
            if ($collection->renderGrid) {
                $this->widget('zii.widgets.grid.CGridView', $hooks->applyFilters('grid_view_properties', array(
                    'ajaxUrl'           => $this->createUrl($this->route),
                    'id'                => $server->modelName.'-grid',
                    'dataProvider'      => $server->search(),
                    'filter'            => $server,
                    'filterPosition'    => 'body',
                    'filterCssClass'    => 'grid-filter-cell',
                    'itemsCssClass'     => 'table table-hover',
                    'selectableRows'    => 0,
                    'enableSorting'     => false,
                    'cssFile'           => false,
                    'pagerCssClass'     => 'pagination pull-right',
                    'pager'             => array(
                        'class'         => 'CLinkPager',
                        'cssFile'       => false,
                        'header'        => false,
                        'htmlOptions'   => array('class' => 'pagination')
                    ),
                    'columns' => $hooks->applyFilters('grid_view_columns', array(
                        array(
                            'name'  => 'hostname',
                            'value' => 'HtmlHelper::accessLink($data->hostname, array("email_box_monitors/update", "id" => $data->server_id), array("fallbackText" => true))',
                            'type'  => 'raw',
                        ),
                        array(
                            'name'  => 'username',
                            'value' => '$data->username',
                        ),
                        array(
                            'name'  => 'service',
                            'value' => '$data->serviceName',
                            'filter'=> $server->getServicesArray(),
                        ),
                        array(
                            'name'  => 'port',
                            'value' => '$data->port',
                        ),
                        array(
                            'name'  => 'protocol',
                            'value' => '$data->protocolName',
                            'filter'=> $server->getProtocolsArray(),
                        ),
                        array(
                            'name'  => 'status',
                            'value' => 'ucfirst(Yii::t("app", $data->status))',
                            'filter'=> $server->getStatusesList(),
                        ),
                        array(
                            'class'     => 'CButtonColumn',
                            'header'    => Yii::t('app', 'Options'),
                            'footer'    => $server->paginationOptions->getGridFooterPagination(),
                            'buttons'   => array(
                                'update' => array(
                                    'label'     => IconHelper::make('update'),
                                    'url'       => 'Yii::app()->createUrl("email_box_monitors/update", array("id" => $data->server_id))',
                                    'imageUrl'  => null,
                                    'options'   => array('title' => Yii::t('app', 'Update'), 'class' => 'btn btn-primary btn-flat'),
                                ),
                                'copy'=> array(
                                    'label'     => IconHelper::make('copy'),
                                    'url'       => 'Yii::app()->createUrl("email_box_monitors/copy", array("id" => $data->server_id))',
                                    'imageUrl'  => null,
                                    'options'   => array('title' => Yii::t('app', 'Copy'), 'class' => 'btn btn-primary btn-flat copy-server'),
                                ),
                                'enable'=> array(
                                    'label'     => IconHelper::make('glyphicon-open'),
                                    'url'       => 'Yii::app()->createUrl("email_box_monitors/enable", array("id" => $data->server_id))',
                                    'imageUrl'  => null,
                                    'options'   => array('title' => Yii::t('app', 'Enable'), 'class' => 'btn btn-primary btn-flat enable-server'),
                                    'visible'   => '$data->getIsDisabled()',
                                ),
                                'disable'=> array(
                                    'label'     => IconHelper::make('save'),
                                    'url'       => 'Yii::app()->createUrl("email_box_monitors/disable", array("id" => $data->server_id))',
                                    'imageUrl'  => null,
                                    'options'   => array('title' => Yii::t('app', 'Disable'), 'class' => 'btn btn-primary btn-flat disable-server'),
                                    'visible'   => '$data->getIsActive()',
                                ),
                                'delete' => array(
                                    'label'     => IconHelper::make('delete'),
                                    'url'       => 'Yii::app()->createUrl("email_box_monitors/delete", array("id" => $data->server_id))',
                                    'imageUrl'  => null,
                                    'options'   => array('title' => Yii::t('app', 'Delete'), 'class' => 'btn btn-danger btn-flat delete'),
                                ),
                            ),
                            'headerHtmlOptions' => array('style' => 'text-align: right'),
                            'footerHtmlOptions' => array('align' => 'right'),
                            'htmlOptions'       => array('align' => 'right', 'class' => 'options'),
                            'template'          => '{update} {copy} {enable} {disable} {delete}'
                        ),
                    ), $this),
                ), $this));  
            }
            /**
             * This hook gives a chance to append content after the grid view content.
             * Please note that from inside the action callback you can access all the controller view
             * variables via {@CAttributeCollection $collection->controller->data}
             * @since 1.3.3.1
             */
            $hooks->doAction('after_grid_view', new CAttributeCollection(array(
                'controller'  => $this,
                'renderedGrid'=> $collection->renderGrid,
            )));
            ?>
            <div class="clearfix"><!-- --></div>
            </div>    
        </div>
    </div>
    <!-- modals -->
    <div class="modal modal-info fade" id="page-info" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo IconHelper::make('info') . Yii::t('app',  'Info');?></h4>
                </div>
                <div class="modal-body">
                    <?php
                    $text = 'Please note, when adding an email box monitor make sure the email address is used only for it, nothing more.<br />
                    This is important since the script that checks the emails needs to read all the emails from the account you specify and beside it can be time and memory consuming, it will also delete all the emails from the email account.';
                    echo Yii::t('servers', StringHelper::normalizeTranslationString($text));
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php 
}
/**
 * This hook gives a chance to append content after the view file default content.
 * Please note that from inside the action callback you can access all the controller view
 * variables via {@CAttributeCollection $collection->controller->data}
 * @since 1.3.3.1
 */
$hooks->doAction('after_view_file_content', new CAttributeCollection(array(
    'controller'        => $this,
    'renderedContent'   => $viewCollection->renderContent,
)));