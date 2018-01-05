<?php defined('MW_PATH') || exit('No direct script access allowed');



class UpdateWorkerFor_1_4_9 extends UpdateWorkerAbstract
{
    public function run()
    {
        // run the sql from file
        $this->runQueriesFromSqlFile('1.4.9');
    }
}
