<?php if ( ! defined('MW_PATH')) exit('No direct script access allowed');?>

<?php echo Yii::t('email_blacklist', 'The monitor {name} finished processing {count} records, {successCount} with success and {errorCount} with error!', array(
    '{name}'         => $monitor->name,
    '{count}'        => $modelsCount,
    '{successCount}' => $modelsDeletedSuccessCount,
    '{errorCount}'   => $modelsDeletedErrorCount,
));?>
