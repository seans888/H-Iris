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
<div class="box box-primary borderless" id="store-box-wrapper">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title">
                <?php echo IconHelper::make('glyphicon-shopping-cart') .  $pageHeading;?>
            </h3>
        </div>
        <div class="pull-right"></div>
        <div class="clearfix"><!-- --></div>
    </div>
    <div class="box-body">

        <div class="container-fluid">
            <div class="row">
                <?php foreach ($items as $item) { ?>
                    <div class="col-lg-6">
                        
                        <div class="item">
                            <div class="image">
                                <a href="<?php echo $item->preview_url;?>" target="_blank" title="<?php echo $item->name;?>">
                                    <img src="<?php echo $item->thumbnail_image;?>" class="img-thumbnail"/>
                                </a>
                            </div>
                            <div class="details">
                                <h4><a href="<?php echo $item->preview_url;?>" target="_blank" title="<?php echo $item->name;?>"><?php echo $item->name;?></a></h4>
                                <p><?php echo StringHelper::truncateLength($item->description, 170);?></p>
                            </div>
                            <div class="actions">
                                <a href="<?php echo $item->buy_url;?>" class="btn btn-success btn-sm btn-flat" target="_blank"><i class="fa fa-usd" aria-hidden="true"></i> <?php echo $item->formatted_price;?></a>
                                <a href="<?php echo $item->buy_url;?>" class="btn btn-primary btn-sm btn-flat" target="_blank"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <?php echo Yii::t('store', 'Buy now!');?></a>
                            </div>
                        </div>
                        
                    </div>
                <?php } ?>
            </div>
        </div>
        
        <div class="clearfix"><!-- --></div>
    </div>
</div>