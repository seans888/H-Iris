<?php defined('MW_PATH') || exit('No direct script access allowed');


class DeleteMutexesCommand extends ConsoleCommand
{
    public function actionIndex()
    {
        $folderName   = Yii::getPathOfAlias('common.runtime.mutex');
        $days         = 3 * 24 * 60 * 60; // 3 days 
        $now          = time();
        $allFiles     = 0;
        $deletedFiles = 0;
        
        foreach (new DirectoryIterator($folderName) as $fileInfo) {
            if ($fileInfo->isDot() || !$fileInfo->isFile()) {
                continue;
            }
            $allFiles++;
            if (($now - $fileInfo->getCTime()) >= $days) {
                $this->stdout('Deleting: ' . $fileInfo->getRealPath());
                unlink($fileInfo->getRealPath());
                $deletedFiles++;
            }
        }
        
        $this->stdout('Deleted ' . $deletedFiles . ' out of '. $allFiles .' mutex files!');
        
        return 0;
    }
}