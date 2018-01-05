<?php defined('MW_PATH') || exit('No direct script access allowed');



class SuppressionListImportCommand extends ConsoleCommand
{
    // the folder path from where we should load files
    public $folder_path;

    // max amount of files to process from the folder
    public $folder_process_files = 10;

    // the list where we want to import into
    public $list_uid;

    // the path where the import file is located
    public $file_path;

    // is verbose
    public $verbose = 0;

    // for external access maybe?
    public $lastMessage = array();

    /**
     * @return int
     */
    public function actionFolder()
    {
        if (empty($this->folder_path)) {
            $this->folder_path = Yii::getPathOfAlias('common.runtime.suppression-list-import-queue');
        }

        if (!is_dir($this->folder_path) || !is_readable($this->folder_path)) {
            return $this->renderMessage(array(
                'result'  => 'error',
                'message' => Yii::t('list_import', 'Call this command with the --folder_path=XYZ param where XYZ is the full path to the folder you want to monitor.'),
                'return'  => 1,
            ));
        }

        $this->renderMessage(array(
            'result'  => 'info',
            'message' => 'The folder path is: '. $this->folder_path,
        ));

        $files  = FileSystemHelper::readDirectoryContents($this->folder_path, true);
        $pcntl  = CommonHelper::functionExists('pcntl_fork') && CommonHelper::functionExists('pcntl_waitpid');
        $childs = array();

        if ($pcntl) {
            Yii::app()->getDb()->setActive(false);
        }

        if (count($files) > (int)$this->folder_process_files) {
            $files = array_slice($files, (int)$this->folder_process_files);
        }

        $this->renderMessage(array(
            'result'  => 'info',
            'message' => 'Found '. count($files) . ' files (some of them might be already processing)',
        ));

        foreach ($files as $file) {
            if (!$pcntl) {
                $this->processFile($file);
                continue;
            }

            //
            $pid = pcntl_fork();
            if($pid == -1) {
                continue;
            }

            // Parent
            if ($pid) {
                $childs[] = $pid;
            }

            // Child
            if (!$pid) {
                $this->processFile($file);
                exit;
            }
        }

        if ($pcntl) {
            while (count($childs) > 0) {
                foreach ($childs as $key => $pid) {
                    $res = pcntl_waitpid($pid, $status, WNOHANG);
                    if($res == -1 || $res > 0) {
                        unset($childs[$key]);
                    }
                }
                sleep(1);
            }
        }

        return 0;
    }

    /**
     * @param $file
     * @return int
     */
    protected function processFile($file)
    {
        $this->renderMessage(array(
            'result'  => 'info',
            'message' => 'Processing: ' . $file,
        ));

        $lockName = sha1($file);
        if (!Yii::app()->mutex->acquire($lockName, 5)) {
            return $this->renderMessage(array(
                'result'  => 'info',
                'message' => 'Cannot acquire lock for processing: ' . $file,
                'return'  => 1,
            ));
        }

        if (!is_file($file)) {
            Yii::app()->mutex->release($lockName);
            return $this->renderMessage(array(
                'result'  => 'info',
                'message' => 'The file: "' . $file . '" was removed by another process!',
                'return'  => 1,
            ));
        }

        $fileName  = basename($file);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $listName  = substr(trim(basename($fileName, $extension), '.'), 0, 13); // maybe uid-1.csv uid-2.txt

        Yii::app()->hooks->doAction('console_command_suppression_list_import_before_process', new CAttributeCollection(array(
            'command'    => $this,
            'importType' => $extension,
            'listUid'    => $listName,
            'filePath'   => $file,
        )));

        if ($extension == 'csv') {
            $this->processCsv(array(
                'list_uid'    => $listName,
                'file_path'   => $file,
            ));
        } elseif ($extension == 'txt') {
            $this->processText(array(
                'list_uid'    => $listName,
                'file_path'   => $file,
            ));
        }

        Yii::app()->hooks->doAction('console_command_suppression_list_import_after_process', new CAttributeCollection(array(
            'command'    => $this,
            'importType' => $extension,
            'listUid'    => $listName,
            'filePath'   => $file,
        )));

        if (in_array($extension, array('csv', 'txt')) && is_file($file)) {
            
            // remove the file
            @unlink($file);

            // 1.4.4
            $list = CustomerSuppressionList::model()->findByAttributes(array(
                'list_uid' => $listName,
            ));

            if (!empty($list) && ($server = DeliveryServer::pickServer())) {
                $options         = Yii::app()->options;
                $command         = Yii::app()->command;
                $listOverviewUrl = $options->get('system.urls.customer_absolute_url') . 'suppression-lists/' . $list->list_uid . '/emails/index';
                $viewData        = compact('list', 'listOverviewUrl');
                $emailTemplate   = $options->get('system.email_templates.common');
                $emailBody       = $command->renderFile(Yii::getPathOfAlias('console.views.suppression-list-import-finished').'.php', $viewData, true);
                $emailTemplate   = str_replace('[CONTENT]', $emailBody, $emailTemplate);

                $emailParams = array(
                    'subject' => Yii::t('list_import', 'Suppression list import has finished!'),
                    'body'    => $emailTemplate,
                    'to'      => array($list->customer->email => $list->customer->email),
                );

                $server->sendEmail($emailParams);
            }
            //
        }

        Yii::app()->mutex->release($lockName);

        $this->renderMessage(array(
            'result'  => 'info',
            'message' => 'The file: "' . $file . '" was processed!',
        ));
    }

    /**
     * @return int
     */
    public function actionCsv()
    {
        Yii::app()->hooks->doAction('console_command_suppression_list_import_before_process', new CAttributeCollection(array(
            'command'    => $this,
            'importType' => 'csv',
            'listUid'    => $this->list_uid,
            'filePath'   => $this->file_path,
        )));

        $result = $this->processCsv(array(
            'list_uid'    => $this->list_uid,
            'file_path'   => $this->file_path,
        ));

        Yii::app()->hooks->doAction('console_command_suppression_list_import_after_process', new CAttributeCollection(array(
            'command'    => $this,
            'importType' => 'csv',
            'listUid'    => $this->list_uid,
            'filePath'   => $this->file_path,
        )));

        return $result;
    }

    /**
     * @param array $params
     * @return int
     */
    protected function processCsv(array $params)
    {
        if (empty($params['list_uid'])) {
            return $this->renderMessage(array(
                'result'  => 'error',
                'message' => Yii::t('list_import', 'Call this command with the --list_uid=XYZ param where XYZ is the 13 chars unique list id.'),
                'return'  => 1,
            ));
        }

        $list = CustomerSuppressionList::model()->findByUid($params['list_uid']);
        if (empty($list)) {
            return $this->renderMessage(array(
                'result'  => 'error',
                'message' => Yii::t('list_import', 'The list with the uid {uid} was not found in database.', array(
                    '{uid}' => $params['list_uid'],
                )),
                'return' => 1,
            ));
        }

        if (empty($params['file_path']) || !is_file($params['file_path'])) {
            return $this->renderMessage(array(
                'result'  => 'error',
                'message' => Yii::t('list_import', 'Call this command with the --file_path=/some/file.csv param where /some/file.csv is the full path to the csv file to be imported.'),
                'return'  => 1,
            ));
        }

        $options      = Yii::app()->options;
        $importAtOnce = (int)$options->get('system.importer.import_at_once', 50);

        ini_set('auto_detect_line_endings', true);
        
        $file = new SplFileObject($params['file_path']);
        $file->setCsvControl(StringHelper::detectCsvDelimiter($params['file_path']));
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE | SplFileObject::READ_AHEAD);
        $columns = $file->current(); // the header

        if (empty($columns)) {
            return $this->renderMessage(array(
                'result'  => 'error',
                'message' => Yii::t('list_import', 'Your file does not contain the header with the fields title!'),
                'return'  => 1,
            ));
        }

        $linesCount       = iterator_count($file);
        $totalFileRecords = $linesCount - 1; // minus the header

        $file->seek(1);
        
        $ioFilter = Yii::app()->ioFilter;
        $columns  = (array)$ioFilter->stripPurify($columns);
        $columns  = array_map('strtolower', array_map('trim', $columns));
        
        if (array_search('email', $columns) === false) {
            return $this->renderMessage(array(
                'result'  => 'error',
                'message' => Yii::t('list_import', 'Cannot find the "email" column in your file!'),
                'return'  => 1,
            ));
        }
        
        $rounds      = $totalFileRecords > $importAtOnce ? round($totalFileRecords / $importAtOnce) : 1;
        $mainCounter = 0;
        
        for ($rCount = 1; $rCount <= $rounds; $rCount++) {
 
            $offset = $importAtOnce * ($rCount - 1);
            if ($offset >= $totalFileRecords) {
                return $this->renderMessage(array(
                    'result'  => 'success',
                    'message' => Yii::t('list_import', 'The import process has finished!'),
                    'return'  => 0,
                ));
            }
            
            $file->seek($offset);

            $columnCount = count($columns);
            $rows        = array();
            $i           = 0;

            while (!$file->eof()) {

                $row = $file->fgetcsv();
                if (empty($row)) {
                    continue;
                }

                $row      = (array)$ioFilter->stripPurify($row);
                $row      = array_map('trim', $row);
                $rowCount = count($row);

                
                if ($rowCount == 0) {
                    continue;
                }
                
                if ($columnCount > $rowCount) {
                    $fill = array_fill($rowCount, $columnCount - $rowCount, '');
                    $row  = array_merge($row, $fill);
                } elseif ($rowCount > $columnCount) {
                    $row  = array_slice($row, 0, $columnCount);
                }
                
                $row = array_combine($columns, $row);
                $rows[] = array('email' => $row['email']);

                ++$i;

                if ($i >= $importAtOnce) {
                    break;
                }
            }

            if (empty($rows)) {
                if ($rCount == 1) {
                    return $this->renderMessage(array(
                        'result'  => 'error',
                        'message' => Yii::t('list_import', 'Your file does not contain enough data to be imported!'),
                        'return'  => 1,
                    ));
                } else {
                    return $this->renderMessage(array(
                        'result'  => 'success',
                        'message' => Yii::t('list_import', 'The import process has finished!'),
                        'return'  => 0,
                    ));
                }
            }
            
            $finished    = false;
            $importCount = 0;
            $transaction = Yii::app()->getDb()->beginTransaction();
            
            $mustCommitTransaction = true;

            try {

                foreach ($rows as $row) {
                    
                    $mainCounter++;
                    $percent = round(($mainCounter / $totalFileRecords) * 100);

                    $this->renderMessage(array(
                        'type'    => 'info',
                        'message' => '['.$percent.'%] - ' . Yii::t('list_import', 'Checking the list for the email: "{email}"', array(
                            '{email}' => CHtml::encode($row['email']),
                        )),
                        'counter' => false,
                    ));
                    
                    $email = CustomerSuppressionListEmail::model()->findByAttributes(array(
                        'list_id' => $list->list_id,
                        'email'   => $row['email'],
                    ));
                    
                    if (!empty($email)) {
                        $this->renderMessage(array(
                            'type'    => 'info',
                            'message' => '['.$percent.'%] - ' . Yii::t('list_import', 'The email "{email}" exists in the list already.', array(
                                '{email}' => CHtml::encode($row['email']),
                            )),
                            'counter' => true,
                        ));
                        continue;
                    }

                    $email = new CustomerSuppressionListEmail();
                    $email->list_id = $list->list_id;
                    $email->email   = $row['email'];
                    
                    if (!$email->save()) {
                        $this->renderMessage(array(
                            'type'    => 'error',
                            'message' => '['.$percent.'%] - ' . Yii::t('list_import', 'Failed to save the email "{email}", reason: {reason}', array(
                                '{email}'  => CHtml::encode($row['email']),
                                '{reason}' => $email->shortErrors->getAllAsString("\n"),
                            )),
                            'counter' => true,
                        ));
                        continue;
                    }

                    $this->renderMessage(array(
                        'type'    => 'info',
                        'message' => '['.$percent.'%] - ' . Yii::t('list_import', 'The email "{email}" has been successfully added to the list.', array(
                                '{email}' => CHtml::encode($row['email']),
                            )),
                        'counter' => true,
                    ));
                    
                    ++$importCount;

                    if ($finished) {
                        break;
                    }
                }

                $transaction->commit();
                $mustCommitTransaction = false;

            } catch(Exception $e) {

                $transaction->rollback();
                $mustCommitTransaction = false;

                return $this->renderMessage(array(
                    'result'  => 'error',
                    'message' => $e->getMessage(),
                    'return'  => 1,
                ));
            }

            if ($mustCommitTransaction) {
                $transaction->commit();
            }

            if ($finished) {
                return $this->renderMessage(array(
                    'result'  => 'error',
                    'message' => $finished,
                    'return'  => 0,
                ));
            }
        }

        return $this->renderMessage(array(
            'result'  => 'success',
            'message' => Yii::t('list_import', 'The import process has finished!'),
            'return'  => 0,
        ));
    }

    /**
     * @return int
     */
    public function actionText()
    {
        Yii::app()->hooks->doAction('console_command_suppression_list_import_before_process', new CAttributeCollection(array(
            'command'    => $this,
            'importType' => 'text',
            'listUid'    => $this->list_uid,
            'filePath'   => $this->file_path,
        )));

        $result = $this->processText(array(
            'list_uid'    => $this->list_uid,
            'file_path'   => $this->file_path,
        ));

        Yii::app()->hooks->doAction('console_command_suppression_list_import_after_process', new CAttributeCollection(array(
            'command'    => $this,
            'importType' => 'text',
            'listUid'    => $this->list_uid,
            'filePath'   => $this->file_path,
        )));

        return $result;
    }

    /**
     * @param array $params
     * @return int
     */
    protected function processText(array $params)
    {
        if (empty($params['list_uid'])) {
            return $this->renderMessage(array(
                'result'  => 'error',
                'message' => Yii::t('list_import', 'Call this command with the --list_uid=XYZ param where XYZ is the 13 chars unique list id.'),
                'return'  => 1,
            ));
        }

        $list = CustomerSuppressionList::model()->findByUid($params['list_uid']);
        if (empty($list)) {
            return $this->renderMessage(array(
                'result'  => 'error',
                'message' => Yii::t('list_import', 'The list with the uid {uid} was not found in database.', array(
                    '{uid}' => $params['list_uid'],
                )),
                'return' => 1,
            ));
        }

        if (empty($params['file_path'])) {
            return $this->renderMessage(array(
                'result'  => 'error',
                'message' => Yii::t('list_import', 'Call this command with the --file_path=/some/file.txt param where /some/file.txt is the full path to the csv file to be imported.'),
                'return'  => 1,
            ));
        }

        $options      = Yii::app()->options;
        $importAtOnce = (int)$options->get('system.importer.import_at_once', 50);
        $mainCounter  = 0;
        
        $file = new SplFileObject($params['file_path']);
        // $file->setFlags(SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE | SplFileObject::READ_AHEAD);

        $file->seek($file->getSize());
        $totalFileRecords = $file->key() + 1;
        $file->seek(0);
        
        $rounds = round($totalFileRecords / $importAtOnce);
        for ($rCount = 1; $rCount <= $rounds; $rCount++) {

            $offset = $importAtOnce * ($rCount - 1);
            if ($offset >= $totalFileRecords) {
                return $this->renderMessage(array(
                    'result'  => 'success',
                    'message' => Yii::t('list_import', 'The import process has finished!'),
                    'return'  => 0,
                ));
            }
            $file->seek($offset > 0 ? $offset - 1 : 0);

            $ioFilter = Yii::app()->ioFilter;
            $rows     = array();
            $i        = 0;

            while (!$file->eof()) {
                $rows[] = array('email' => $ioFilter->stripPurify(trim($file->fgets())));
                ++$i;
                if ($i >= $importAtOnce) {
                    break;
                }
            }

            if (empty($rows)) {
                if ($rCount == 1) {
                    return $this->renderMessage(array(
                        'result'  => 'error',
                        'message' => Yii::t('list_import', 'Your file does not contain enough data to be imported!'),
                        'return'  => 1,
                    ));
                } else {
                    return $this->renderMessage(array(
                        'result'  => 'success',
                        'message' => Yii::t('list_import', 'The import process has finished!'),
                        'return'  => 0,
                    ));
                }
            }
            
            $finished    = false;
            $importCount = 0;
            $transaction = Yii::app()->getDb()->beginTransaction();
            $mustCommitTransaction = true;

            try {

                foreach ($rows as $row) {

                    $mainCounter++;
                    $percent = round(($mainCounter / $totalFileRecords) * 100);

                    $this->renderMessage(array(
                        'type'    => 'info',
                        'message' => '['.$percent.'%] - ' . Yii::t('list_import', 'Checking the list for the email: "{email}"', array(
                                '{email}' => CHtml::encode($row['email']),
                            )),
                        'counter' => false,
                    ));

                    $email = CustomerSuppressionListEmail::model()->findByAttributes(array(
                        'list_id' => $list->list_id,
                        'email'   => $row['email'],
                    ));

                    if (!empty($email)) {
                        $this->renderMessage(array(
                            'type'    => 'info',
                            'message' => '['.$percent.'%] - ' . Yii::t('list_import', 'The email "{email}" exists in the list already.', array(
                                    '{email}' => CHtml::encode($row['email']),
                                )),
                            'counter' => true,
                        ));
                        continue;
                    }

                    $email = new CustomerSuppressionListEmail();
                    $email->list_id = $list->list_id;
                    $email->email   = $row['email'];

                    if (!$email->save()) {
                        $this->renderMessage(array(
                            'type'    => 'error',
                            'message' => '['.$percent.'%] - ' . Yii::t('list_import', 'Failed to save the email "{email}", reason: {reason}', array(
                                    '{email}'  => CHtml::encode($row['email']),
                                    '{reason}' => $email->shortErrors->getAllAsString(),
                                )),
                            'counter' => true,
                        ));
                        continue;
                    }

                    $this->renderMessage(array(
                        'type'    => 'info',
                        'message' => '['.$percent.'%] - ' . Yii::t('list_import', 'The email "{email}" has been successfully added to the list.', array(
                                '{email}' => CHtml::encode($row['email']),
                            )),
                        'counter' => true,
                    ));
                    
                    ++$importCount;

                    if ($finished) {
                        break;
                    }
                }

                $transaction->commit();
                $mustCommitTransaction = false;

            } catch(Exception $e) {

                $transaction->rollback();
                $mustCommitTransaction = false;

                return $this->renderMessage(array(
                    'result'  => 'error',
                    'message' => $e->getMessage(),
                    'return'  => 1,
                ));
            }

            if ($mustCommitTransaction) {
                $transaction->commit();
            }

            if ($finished) {
                return $this->renderMessage(array(
                    'result'  => 'error',
                    'message' => $finished,
                    'return'  => 1,
                ));
            }
        }

        return $this->renderMessage(array(
            'result'  => 'success',
            'message' => Yii::t('list_import', 'The import process has finished!'),
            'return'  => 0,
        ));
    }

    /**
     * @param array $data
     * @return int
     */
    protected function renderMessage($data = array())
    {
        if (isset($data['type']) && in_array($data['type'], array('success', 'error'))) {
            $this->lastMessage = $data;
        }

        if (isset($data['message']) && $this->verbose) {
            $out = '['.date('Y-m-d H:i:s').'] - ';
            if (isset($data['type'])) {
                $out .= '[' . strtoupper($data['type']) . '] - ';
            }
            $out .= strip_tags(str_replace(array('<br />', '<br/>', '<br>'), PHP_EOL, $data['message'])) . PHP_EOL;
            echo $out;
        }

        if (isset($data['return']) || array_key_exists('return', $data)) {
            return (int)$data['return'];
        }
    }
}
