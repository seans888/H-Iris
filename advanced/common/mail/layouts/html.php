<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <?= $content ?>
    <?php $this->endBody() ?>
</body>
</html>-->

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    </head>
    <body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <table id="Table_01" border="0" cellpadding="0" cellspacing="0" align="center" height="411" width="600" style="font-family:arial; font-size:14px;">
            <tbody>      
<tr>
                **<td colspan="4" style="border-bottom:1px solid #bc2744; height:1px">First</td>**
            </tr>  
                <tr>
                    <td colspan="2">
                       <?php
                       echo $content;                   
                       ?>
                    </td>
                </tr>
                **<td colspan="4" style="border-bottom:1px solid #bc2744; height:1px">Second</td>**
            </tbody>
        </table>   
    </body>
    </html>
<?php $this->endPage() ?>
