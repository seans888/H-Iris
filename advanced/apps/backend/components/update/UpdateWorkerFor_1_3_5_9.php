<?php defined('MW_PATH') || exit('No direct script access allowed');



class UpdateWorkerFor_1_3_5_9 extends UpdateWorkerAbstract
{
    public function run()
    {
        // run the sql from file
        $this->runQueriesFromSqlFile('1.3.5.9');

        $notify = Yii::app()->notify;
        $notify->addInfo(Yii::t('update', 'Please note that starting with this version update, we deprecated the redis queue feature!'));
    }
}
