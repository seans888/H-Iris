<?php defined('MW_PATH') || exit('No direct script access allowed');



class UpdateWorkerFor_1_3_7_4 extends UpdateWorkerAbstract
{
    public function run()
    {
        // run the sql from file
        $this->runQueriesFromSqlFile('1.3.7.4');
    }
}
