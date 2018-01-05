<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * This file is part of the MailWizz EMA application.
 * 
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com> 
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.0
 */
 
?>

<div class="row">
    <div class="col-lg-12 related-articles">
        <h4><?php echo Yii::t('articles', 'Related articles');?></h4>
        <div class="row">
            <?php foreach ($columns as $index => $articles) { ?>
                <div class="column <?php echo $this->columnsCssClass;?>">
                    <?php foreach ($articles as $article) { ?>
                        <div class="article">
                            <div class="title"><?php echo CHtml::link(StringHelper::truncateLength($article->title, 30), Yii::app()->createUrl('articles/view', array('slug' => $article->slug)), array('title' => $article->title)); ?></div>
                            <div class="excerpt"><?php echo $article->getExcerpt((int)$this->excerptLength); ?></div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>