<?php defined('MW_PATH') || exit('No direct script access allowed');



class UpdateWorkerFor_1_3_6_2 extends UpdateWorkerAbstract
{
    public function run()
    {
        // run the sql from file
        $this->runQueriesFromSqlFile('1.3.6.2');
    }
}
