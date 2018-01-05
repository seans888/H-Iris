<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class UpdateCommand extends ConsoleCommand 
{
    public function actionIndex() 
    {
        $options        = Yii::app()->options;
        $versionInFile  = MW_VERSION;
        $versionInDb    = $options->get('system.common.version');
        
        if (!version_compare($versionInFile, $versionInDb, '>')) {
            if ($options->get('system.common.site_status', 'online') != 'online') {
                $options->set('system.common.site_status', 'online');
            }
            echo Yii::t('update', "You are already at latest version!") . "\n";
            return 0;
        }
        
        $input = $this->confirm(Yii::t('update', 'Are you sure you want to update your Mailwizz application from version {vFrom} to version {vTo} ?', array(
            '{vFrom}' => $versionInDb,
            '{vTo}'   => $versionInFile,
        )));
        
        if (!$input) {
            echo "\n" . Yii::t('update', "Okay, aborting the update process!") . "\n";
            return 0;
        }
        
        // put the application offline
        $options->set('system.common.site_status', 'offline');
        
        $workersPath = Yii::getPathOfAlias('backend.components.update');
        require_once $workersPath . '/UpdateWorkerAbstract.php';
        
        $updateWorkers  = (array)FileSystemHelper::readDirectoryContents($workersPath);
            
        foreach ($updateWorkers as $index => $fileName) {
            $fileName = basename($fileName, '.php');
            if (strpos($fileName, 'UpdateWorkerFor_') !== 0) {
                unset($updateWorkers[$index]);
                continue;
            }
            
            $workerVersion = str_replace('UpdateWorkerFor_', '', $fileName);
            $workerVersion = str_replace('_', '.', $workerVersion);
            
            // previous versions ?
            if (version_compare($workerVersion, $versionInDb, '<=')) {
                unset($updateWorkers[$index]);
                continue;
            }
            
            // next versions ?
            if (version_compare($workerVersion, $versionInFile, '>')) {
                unset($updateWorkers[$index]);
                continue;
            }
            
            $updateWorkers[$index] = $workerVersion;
        }
        
        sort($updateWorkers, SORT_NUMERIC | SORT_ASC);
            
        $db = Yii::app()->getDb();
        $db->createCommand('SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0')->execute();
        $db->createCommand('SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0')->execute();
        $db->createCommand('SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE=""')->execute();
        
        $success = true;
        foreach ($updateWorkers as $workerVersion) {
            $transaction = $db->beginTransaction();
            try {
                echo Yii::t('update', 'Updating to version {version}.', array('{version}' => $workerVersion)) . "\n";
                $this->runWorker($workerVersion);
                echo Yii::t('update', 'Updated to version {version} successfully.', array('{version}' => $workerVersion)) . "\n";
                
                $options->set('system.common.version', $versionInFile);
                $options->set('system.common.version_update.current_version', $versionInFile);
                $transaction->commit();
            } catch (Exception $e) {
                $success = false;
                $transaction->rollBack();
                echo Yii::t('update', 'Updating to version {version} failed with: {message}', array(
                    '{version}' => $workerVersion, 
                    '{message}' => $e->getMessage()
                )) . "\n";
                break;
            }
        }
        
        $db->createCommand('SET SQL_MODE=@OLD_SQL_MODE')->execute();
        $db->createCommand('SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS')->execute();
        $db->createCommand('SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS')->execute();
        
        if (!$success) {
            exit(1);
        }
        
        $options->set('system.common.version', $versionInFile);
        $options->set('system.common.site_status', 'online');
        $options->set('system.common.version_update.current_version', $versionInFile);
        
        echo Yii::t('update', 'Congratulations, your application has been successfully updated to version {version}', array(
            '{version}' => $versionInFile,
        )) . "\n";
        
        // since 1.3.6.3 - update extensions
        $manager    = Yii::app()->extensionsManager;
        $extensions = $manager->getCoreExtensions();
        $errors     = array();
        foreach ($extensions as $id => $instance) {
            if ($manager->extensionMustUpdate($id) && !$manager->updateExtension($id)) {
                $errors[] = Yii::t('extensions', 'The extension "{name}" has failed to update!', array(
                    '{name}' => CHtml::encode($instance->name),
                ));
                $errors[] = "\n";
                $errors = CMap::mergeArray($errors, (array)$manager->getErrors());
                $errors[] = "\n";
                $manager->resetErrors();
            }
        }
        if (!empty($errors)) {
            echo implode("\n", $errors) . "\n\n";
        }
        //

        // clean directories of old asset files.
        $this->stdout(FileSystemHelper::clearCache());
        
        // remove the cache, can be redis for example
        Yii::app()->cache->flush();
        
        // rebuild the tables schema cache
        $this->stdout('Rebuilding database schema cache...');
        Yii::app()->db->schema->getTables();
        Yii::app()->db->schema->refresh();
        $this->stdout('Done.');
        
        // and done...
        return 0;
    }
    
    protected function runWorker($version)
    {
        $workersPath    = Yii::getPathOfAlias('backend.components.update');
        $version        = str_replace('.', '_', $version);
        $className      = 'UpdateWorkerFor_' . $version;
        
        if (!is_file($classFile = $workersPath . '/' . $className . '.php')) {
            return false;
        }
        
        require_once $classFile;
        $instance = new $className();
        
        if ($instance instanceof UpdateWorkerAbstract) {
            $instance->run();
        }
        
        return true;
    }
}