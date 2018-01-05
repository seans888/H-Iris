<?php defined('MW_PATH') || exit('No direct script access allowed');


class Suppression_list_emailsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $customer = Yii::app()->customer->getModel();
        if ($customer->getGroupOption('lists.can_use_own_blacklist', 'no') != 'yes') {
            $this->redirect(array('dashboard/index'));
        }
    }

    /**
     * Define the filters for various controller actions
     * Merge the filters with the ones from parent implementation
     */
    public function filters()
    {
        $filters = array(
            'postOnly + delete',
        );

        return CMap::mergeArray($filters, parent::filters());
    }

    /**
     * List all suppressed emails.
     * Delivery to suppressed emails is denied
     */
    public function actionIndex($list_uid)
    {
        $list    = $this->loadListModel($list_uid);
        $request = Yii::app()->request;
        $email   = new CustomerSuppressionListEmail('search');
        $email->unsetAttributes();

        // for filters.
        $email->attributes = (array)$request->getQuery($email->modelName, array());
        $email->list_id    = $list->list_id;
        
        $this->setData(array(
            'pageMetaTitle'   => $this->data->pageMetaTitle . ' | '. Yii::t('suppression_lists', 'Suppression list emails'),
            'pageHeading'     => Yii::t('suppression_lists', 'Suppression list emails'),
            'pageBreadcrumbs' => array(
                Yii::t('suppression_lists', 'Suppression lists') => $this->createUrl('suppression_lists/index'),
                $list->name => $this->createUrl('suppression_list_emails/index', array('list_uid' => $list->list_uid)),
                Yii::t('app', 'View all')
            )
        ));
        
        $importUrl = array('suppression_list_emails/import', 'list_uid' => $list->list_uid);
        if (Yii::app()->options->get('system.importer.suppression_list_cli_enabled', 'no') == 'yes') {
            $importUrl = array('suppression_list_emails/import_queue', 'list_uid' => $list->list_uid);
        }
        
        $this->render('list', compact('email', 'list', 'importUrl'));
    }

    /**
     * Add a new email in the suppression list
     */
    public function actionCreate($list_uid)
    {
        $list    = $this->loadListModel($list_uid);
        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;
        $email   = new CustomerSuppressionListEmail();

        if ($request->isPostRequest && ($attributes = (array)$request->getPost($email->modelName, array()))) {
            $email->attributes = $attributes;
            $email->list_id    = (int)$list->list_id;
            
            if (!$email->save()) {
                $notify->addError(Yii::t('app', 'Your form has a few errors, please fix them and try again!'));
            } else {
                $notify->addSuccess(Yii::t('app', 'Your form has been successfully saved!'));
            }

            Yii::app()->hooks->doAction('controller_action_save_data', $collection = new CAttributeCollection(array(
                'controller' => $this,
                'success'    => $notify->hasSuccess,
                'list'       => $list,
                'email'      => $email,
            )));

            if ($collection->success) {
                $this->redirect(array('suppression_list_emails/index', 'list_uid' => $list->list_uid));
            }
        }

        $this->setData(array(
            'pageMetaTitle'   => $this->data->pageMetaTitle . ' | '. Yii::t('suppression_lists', 'Suppression list emails'),
            'pageHeading'     => Yii::t('suppression_lists', 'Create new'),
            'pageBreadcrumbs' => array(
                Yii::t('suppression_lists', 'Suppression lists') => $this->createUrl('suppression_lists/index'),
                $list->name => $this->createUrl('suppression_list_emails/index', array('list_uid' => $list->list_uid)),
                Yii::t('app', 'Create new'),
            )
        ));

        $this->render('form', compact('email', 'list'));
    }

    /**
     * Update an existing email from the suppression list
     */
    public function actionUpdate($list_uid, $email_uid)
    {
        $list  = $this->loadListModel($list_uid);
        $email = CustomerSuppressionListEmail::model()->findByAttributes(array(
            'email_uid' => $email_uid,
            'list_id'   => $list->list_id,
        ));

        if (empty($email)) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;

        if ($request->isPostRequest && ($attributes = (array)$request->getPost($email->modelName, array()))) {
            $email->attributes  = $attributes;
            $email->list_id     = (int)$list->list_id;
            if (!$email->save()) {
                $notify->addError(Yii::t('app', 'Your form has a few errors, please fix them and try again!'));
            } else {
                $notify->addSuccess(Yii::t('app', 'Your form has been successfully saved!'));
            }

            Yii::app()->hooks->doAction('controller_action_save_data', $collection = new CAttributeCollection(array(
                'controller'=> $this,
                'success'   => $notify->hasSuccess,
                'list'      => $list,
                'email'     => $email,
            )));

            if ($collection->success) {
                $this->redirect(array('suppression_list_emails/index', 'list_uid' => $list->list_uid));
            }
        }

        $this->setData(array(
            'pageMetaTitle'   => $this->data->pageMetaTitle . ' | '. Yii::t('suppression_lists', 'Suppression list emails'),
            'pageHeading'     => Yii::t('suppression_lists', 'Update'),
            'pageBreadcrumbs' => array(
                Yii::t('suppression_lists', 'Suppression lists') => $this->createUrl('suppression_lists/index'),
                $list->name => $this->createUrl('suppression_list_emails/index', array('list_uid' => $list->list_uid)),
                Yii::t('app', 'Update'),
            )
        ));

        $this->render('form', compact('email', 'list'));
    }

    /**
     * Delete an email from the suppression list.
     */
    public function actionDelete($list_uid, $email_uid)
    {
        $list  = $this->loadListModel($list_uid);
        $email = CustomerSuppressionListEmail::model()->findByAttributes(array(
            'email_uid' => $email_uid,
            'list_id'   => $list->list_id,
        ));

        if (empty($email)) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        $email->delete();

        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;

        $redirect = null;
        if (!$request->getQuery('ajax')) {
            $notify->addSuccess(Yii::t('app', 'The item has been successfully deleted!'));
            $redirect = $request->getPost('returnUrl', array('suppression_list_emails/index', 'list_uid' => $list->list_uid));
        }
        
        Yii::app()->hooks->doAction('controller_action_delete_data', $collection = new CAttributeCollection(array(
            'controller' => $this,
            'list'       => $list,
            'email'      => $email,
            'redirect'   => $redirect,
        )));

        if ($collection->redirect) {
            $this->redirect($collection->redirect);
        }
    }

    /**
     * Run a bulk action against the suppressed list of emails
     */
    public function actionBulk_action($list_uid)
    {
        $list    = $this->loadListModel($list_uid);
        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;
        $action  = $request->getPost('bulk_action');
        $items   = array_unique((array)$request->getPost('bulk_item', array()));

        if ($action == CustomerSuppressionListEmail::BULK_ACTION_DELETE && count($items)) {
            $affected = 0;
            foreach ($items as $item) {
                $email = CustomerSuppressionListEmail::model()->findByAttributes(array(
                    'email_uid' => $item,
                    'list_id'   => $list->list_id,
                ));
                
                if (empty($email)) {
                    continue;
                }

                $email->delete();
                $affected++;
            }
            if ($affected) {
                $notify->addSuccess(Yii::t('app', 'The action has been successfully completed!'));
            }
        }

        $defaultReturn = $request->getServer('HTTP_REFERER', array('suppression_list_emails/index', 'list_uid' => $list->list_uid));
        $this->redirect($request->getPost('returnUrl', $defaultReturn));
    }
    
    /**
     * Export existing suppressed emails
     */
    public function actionExport($list_uid)
    {
        set_time_limit(0);

        $list     = $this->loadListModel($list_uid);
        $redirect = array('suppression_list_emails/index', 'list_uid' => $list->list_uid);
        $notify   = Yii::app()->notify;
        
        if (!($fp = @fopen('php://output', 'w'))) {
            $notify->addError(Yii::t('suppression_lists', 'Cannot open export temporary file!'));
            $this->redirect($redirect);
        }

        $fileName = 'email-suppression-list-' . $list->list_uid . '.csv';
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header('Content-type: application/csv');
        header("Content-Transfer-Encoding: Binary");
        header('Content-Disposition: attachment; filename="'.$fileName.'"');

        // columns
        $columns = array(
            Yii::t('suppression_lists', 'Email'),
            Yii::t('suppression_lists', 'Date added'),
            Yii::t('suppression_lists', 'Last Updated')
        );
        fputcsv($fp, $columns, ',', '"');

        // rows
        $limit  = 500;
        $offset = 0;
        $models = $this->getModels($list, $limit, $offset);
        while (!empty($models)) {
            foreach ($models as $model) {
                $row = array($model->email, $model->dateAdded, $model->lastUpdated);
                fputcsv($fp, $row, ',', '"');
            }
            if (connection_status() != 0) {
                @fclose($fp);
                exit;
            }
            $offset = $offset + $limit;
            $models = $this->getModels($list, $limit, $offset);
        }

        @fclose($fp);
        exit;
    }

    /**
     * @param $list
     * @param int $limit
     * @param int $offset
     * @return CustomerSuppressionListEmail[]
     */
    protected function getModels($list, $limit = 100, $offset = 0)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 't.email, t.date_added, t.last_updated';
        $criteria->compare('list_id', (int)$list->list_id);
        $criteria->limit  = (int)$limit;
        $criteria->offset = (int)$offset;
        return CustomerSuppressionListEmail::model()->findAll($criteria);
    }

    /**
     * Import existing suppressed emails
     */
    public function actionImport($list_uid)
    {
        set_time_limit(0);

        $list     = $this->loadListModel($list_uid);
        $request  = Yii::app()->request;
        $notify   = Yii::app()->notify;
        $redirect = array('suppression_list_emails/index', 'list_uid' => $list->list_uid);

        if (!$request->isPostRequest) {
            $this->redirect($redirect);
        }

        ini_set('auto_detect_line_endings', true);

        $import = new CustomerSuppressionListEmail('import');
        $import->file    = CUploadedFile::getInstance($import, 'file');
        $import->list_id = $list->list_id;
        
        if (!$import->validate()) {
            $notify->addError(Yii::t('app', 'Your form has a few errors, please fix them and try again!'));
            $notify->addError($import->shortErrors->getAllAsString());
            $this->redirect($redirect);
        }

        $delimiter = StringHelper::detectCsvDelimiter($import->file->tempName);
        $file = new SplFileObject($import->file->tempName);
        $file->setCsvControl($delimiter);
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE | SplFileObject::READ_AHEAD);
        $columns = $file->current(); // the header

        if (!empty($columns)) {
            $columns = array_map('strtolower', $columns);
            if (array_search('email', $columns) === false) {
                $columns = null;
            }
        }

        if (empty($columns)) {
            $notify->addError(Yii::t('app', 'Your form has a few errors, please fix them and try again!'));
            $notify->addError(Yii::t('suppression_lists', 'Your file does not contain the header with the fields title!'));
            $this->redirect($redirect);
        }

        $ioFilter     = Yii::app()->ioFilter;
        $columnCount  = count($columns);
        $totalRecords = 0;
        $totalImport  = 0;

        while (!$file->eof()) {

            ++$totalRecords;

            $row = $file->fgetcsv();
            if (empty($row)) {
                continue;
            }

            $row = $ioFilter->stripPurify($row);
            $rowCount = count($row);

            if ($rowCount == 0) {
                continue;
            }

            $isEmpty = true;
            foreach ($row as $value) {
                if (!empty($value)) {
                    $isEmpty = false;
                    break;
                }
            }

            if ($isEmpty) {
                continue;
            }

            if ($columnCount > $rowCount) {
                $fill = array_fill($rowCount, $columnCount - $rowCount, '');
                $row  = array_merge($row, $fill);
            } elseif ($rowCount > $columnCount) {
                $row = array_slice($row, 0, $columnCount);
            }

            $model = new CustomerSuppressionListEmail();
            $data  = new CMap(array_combine($columns, $row));
            $model->list_id = (int)$list->list_id;
            $model->email   = $data->itemAt('email');
            if ($model->save()) {
                $totalImport++;
            }
            unset($model, $data);
        }

        $notify->addSuccess(Yii::t('suppression_lists', 'Your file has been successfuly imported, from {count} records, {total} were imported!', array(
            '{count}'   => $totalRecords,
            '{total}'   => $totalImport,
        )));

        $this->redirect($redirect);
    }

    /**
     * Import into the queue existing suppressed emails
     */
    public function actionImport_queue($list_uid)
    {
        set_time_limit(0);

        $list     = $this->loadListModel($list_uid);
        $request  = Yii::app()->request;
        $notify   = Yii::app()->notify;
        $redirect = array('suppression_list_emails/index', 'list_uid' => $list->list_uid);

        if (!$request->isPostRequest) {
            $this->redirect($redirect);
        }

        ini_set('auto_detect_line_endings', true);

        $import = new CustomerSuppressionListEmail('import');
        $import->file    = CUploadedFile::getInstance($import, 'file');
        $import->list_id = $list->list_id;

        if (!$import->validate()) {
            $notify->addError(Yii::t('app', 'Your form has a few errors, please fix them and try again!'));
            $notify->addError($import->shortErrors->getAllAsString());
            $this->redirect($redirect);
        }
        
        $savePath = Yii::getPathOfAlias('common.runtime.suppression-list-import-queue');
        if (!file_exists($savePath) || !is_dir($savePath) || !is_writable($savePath)) {
            @mkdir($savePath, 0777, true);
        }

        $counter = 0;
        $file    = $savePath . '/' . $list->list_uid . '-' . $counter . '.csv';
        while (is_file($file)) {
            $counter++;
            $file = $savePath . '/' . $list->list_uid . '-' . $counter . '.csv';
        }
        
        if (!$import->file->saveAs($file)) {
            $notify->addError(Yii::t('app', 'Your form has a few errors, please fix them and try again!'));
            $notify->addError(Yii::t('suppression_lists', 'Unable to move the uploaded file!'));
            $this->redirect($redirect);
        }

        $notify->addSuccess(Yii::t('suppression_lists', 'Your file has been successfully queued for processing and you will be notified when processing is done!'));
        $this->redirect($redirect);
    }
    
    /**
     * @param $list_uid
     * @return CustomerSuppressionList
     * @throws CHttpException
     */
    protected function loadListModel($list_uid)
    {
        $model = CustomerSuppressionList::model()->findByAttributes(array(
            'list_uid'    => $list_uid,
            'customer_id' => (int)Yii::app()->customer->getId(),
        ));

        if ($model === null) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
        
        return $model;
    }

}
