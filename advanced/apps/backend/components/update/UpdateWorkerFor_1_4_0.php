<?php defined('MW_PATH') || exit('No direct script access allowed');



class UpdateWorkerFor_1_4_0 extends UpdateWorkerAbstract
{
    public function run()
    {
        // run the sql from file
        $this->runQueriesFromSqlFile('1.4.0');
    }
}
