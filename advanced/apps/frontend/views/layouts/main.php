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
<!DOCTYPE html>
<html dir="<?php echo $this->htmlOrientation;?>">
<head>
    <meta charset="<?php echo Yii::app()->charset;?>">
    <title><?php echo CHtml::encode($pageMetaTitle);?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo CHtml::encode($pageMetaDescription);?>">
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="//oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="<?php echo $this->bodyClasses;?>">
<?php $this->afterOpeningBodyTag;?>
<div class="wrapper">
    <header class="main-header">
        <nav class="navbar navbar-static-top"></nav>
    </header>
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-lg-10 col-lg-push-1 col-md-10 col-md-push-1 col-sm-12 col-xs-12">
                    <div id="notify-container">
                        <?php echo Yii::app()->notify->show();?>
                    </div>
                    <?php echo $content;?>
                </div>
            </div>
        </section>
    </div>
    <footer class="main-footer">
        <?php $hooks->doAction('layout_footer_html', $this);?>
        <div class="clearfix"><!-- --></div>
    </footer>
</div>
</body>
</html>