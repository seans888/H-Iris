<?php if ( ! defined('MW_PATH')) exit('No direct script access allowed');?>

<?php echo Yii::t('list_import', 'Hello {name}', array(
    '{name}' => $list->customer->getFullName(),
));?>,
<br />
<?php echo Yii::t('list_import', 'This is a notification to let you know that the import process for the list "{list}" has finished!', array(
    '{list}' => $list->name,
));?>
<br />
<?php echo Yii::t('list_import', 'Click {here} to see the list overview page!', array(
    '{here}' => CHtml::link(Yii::t('list_import', 'here'), $listOverviewUrl),
));?>
