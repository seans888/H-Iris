<?php defined('MW_PATH') || exit('No direct script access allowed');



class Email_blacklistController extends Controller
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        set_time_limit(0);
        
        $this->getData('pageScripts')->add(array('src' => AssetsUrl::js('email-blacklist.js')));
        $this->onBeforeAction = array($this, '_registerJuiBs');
        parent::init();
    }

    /**
     * Define the filters for various controller actions
     * Merge the filters with the ones from parent implementation
     */
    public function filters()
    {
        $filters = array(
            'postOnly + delete, delete_all',
        );

        return CMap::mergeArray($filters, parent::filters());
    }

    /**
     * List all blacklisted emails.
     * Delivery to blacklisted emails is denied
     */
    public function actionIndex()
    {
        $notify    = Yii::app()->notify;
        $request   = Yii::app()->request;
        $limit     = 1000;
        $offset    = 0;
        $blacklist = new EmailBlacklist();
        $filter    = new EmailBlacklistFilters();
        $filter->unsetAttributes();

        if ($attributes = (array)$request->getQuery(null)) {
            $filter->attributes = CMap::mergeArray($filter->attributes, $attributes);
            $filter->hasSetFilters = true;
        }
        if ($attributes = (array)$request->getPost(null)) {
            $filter->attributes = CMap::mergeArray($filter->attributes, $attributes);
            $filter->hasSetFilters = true;
        }

        if ($filter->hasSetFilters && !$filter->validate()) {
            $notify->addError($filter->shortErrors->getAllAsString());
            $this->redirect(array($this->route));
        }

        // the export action
        if ($filter->isExportAction) {

            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: public");
            header('Content-type: application/csv');
            header("Content-Transfer-Encoding: Binary");
            header('Content-Disposition: attachment; filename="blacklisted-emails.csv"');

            echo implode(",", array('"Email"', '"Reason"', '"Date added"')) . "\n";

            $emails = $filter->getEmails($limit, $offset);
            while (!empty($emails)) {
                foreach ($emails as $email) {
                    $out = $email->getAttributes(array('email', 'reason', 'date_added'));
                    echo implode(",", $out) . "\n";
                }
                $offset = $limit + $offset;
                $emails = $filter->getEmails($limit, $offset);
            }

            Yii::app()->end();
        }
        
        // the delete action
        if ($filter->isDeleteAction) {
            $count  = 0;
            $emails = $filter->getEmails();

            while (!empty($emails)) {
                $emailIds = array();
                foreach ($emails as $email) {
                    $emailIds[] = $email['email_id'];
                }
                $count += $filter->deleteEmailsByIds($emailIds);
                $emails = $filter->getEmails();
            }

            $notify->addSuccess(Yii::t('email_blacklist', 'Action completed successfully, deleted {n} emails!', array('{n}' => $count)));
            $this->redirect(array($this->route));
        }

        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | '. Yii::t('email_blacklist', 'Blacklisted emails'),
            'pageHeading'       => Yii::t('email_blacklist', 'Blacklisted emails'),
            'pageBreadcrumbs'   => array(
                Yii::t('email_blacklist', 'Blacklisted emails') => $this->createUrl('email_blacklist/index'),
                Yii::t('app', 'View all')
            )
        ));

        $this->render('list', compact('blacklist', 'filter'));
    }

    /**
     * Add a new email in the blacklist
     */
    public function actionCreate()
    {
        $request    = Yii::app()->request;
        $notify     = Yii::app()->notify;
        $blacklist  = new EmailBlacklist();

        if ($request->isPostRequest && ($attributes = (array)$request->getPost($blacklist->modelName, array()))) {
            $blacklist->attributes = $attributes;
            if (!$blacklist->save()) {
                $notify->addError(Yii::t('app', 'Your form has a few errors, please fix them and try again!'));
            } else {
                $notify->addSuccess(Yii::t('app', 'Your form has been successfully saved!'));
            }

            Yii::app()->hooks->doAction('controller_action_save_data', $collection = new CAttributeCollection(array(
                'controller'=> $this,
                'success'   => $notify->hasSuccess,
                'blacklist' => $blacklist,
            )));

            if ($collection->success) {
                $this->redirect(array('email_blacklist/index'));
            }
        }

        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | '. Yii::t('email_blacklist', 'Blacklisted emails'),
            'pageHeading'       => Yii::t('email_blacklist', 'Add a new email address to blacklist.'),
            'pageBreadcrumbs'   => array(
                Yii::t('email_blacklist', 'Blacklisted emails') => $this->createUrl('email_blacklist/index'),
                Yii::t('app', 'Add new'),
            )
        ));

        $this->render('form', compact('blacklist'));
    }

    /**
     * Update an existing email from the blacklist
     */
    public function actionUpdate($id)
    {
        $blacklist = EmailBlacklist::model()->findByPk((int)$id);

        if (empty($blacklist)) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        $request = Yii::app()->request;
        $notify = Yii::app()->notify;

        if ($request->isPostRequest && ($attributes = (array)$request->getPost($blacklist->modelName, array()))) {
            $blacklist->attributes = $attributes;
            if (!$blacklist->save()) {
                $notify->addError(Yii::t('app', 'Your form has a few errors, please fix them and try again!'));
            } else {
                $notify->addSuccess(Yii::t('app', 'Your form has been successfully saved!'));
            }

            Yii::app()->hooks->doAction('controller_action_save_data', $collection = new CAttributeCollection(array(
                'controller'=> $this,
                'success'   => $notify->hasSuccess,
                'blacklist' => $blacklist,
            )));

            if ($collection->success) {
                $this->redirect(array('email_blacklist/index'));
            }
        }

        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | '. Yii::t('email_blacklist', 'Blacklisted emails'),
            'pageHeading'       => Yii::t('email_blacklist', 'Update blacklisted email address.'),
            'pageBreadcrumbs'   => array(
                Yii::t('email_blacklist', 'Blacklisted emails') => $this->createUrl('email_blacklist/index'),
                Yii::t('app', 'Update'),
            )
        ));

        $this->render('form', compact('blacklist'));
    }

    /**
     * Delete an email from the blacklist.
     * Once removed from the blacklist, the delivery servers will be able to deliver the email to the removed address
     */
    public function actionDelete($id)
    {
        $blacklist = EmailBlacklist::model()->findByPk((int)$id);

        if (empty($blacklist)) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        $blacklist->delete();

        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;

        $redirect = null;
        if (!$request->getQuery('ajax')) {
            $notify->addSuccess(Yii::t('app', 'The item has been successfully deleted!'));
            $redirect = $request->getPost('returnUrl', array('email_blacklist/index'));
        }

        // since 1.3.5.9
        Yii::app()->hooks->doAction('controller_action_delete_data', $collection = new CAttributeCollection(array(
            'controller' => $this,
            'model'      => $blacklist,
            'redirect'   => $redirect,
        )));

        if ($collection->redirect) {
            $this->redirect($collection->redirect);
        }
    }

    /**
     * Run a bulk action against the email blacklist
     */
    public function actionBulk_action()
    {
        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;

        $action = $request->getPost('bulk_action');
        $items  = array_unique(array_map('intval', (array)$request->getPost('email_id', array())));

        if ($action == EmailBlacklist::BULK_ACTION_DELETE && count($items)) {
            $affected = 0;
            foreach ($items as $item) {
                $email = EmailBlacklist::model()->findByPk((int)$item);
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

        $defaultReturn = $request->getServer('HTTP_REFERER', array('email_blacklist/index'));
        $this->redirect($request->getPost('returnUrl', $defaultReturn));
    }

    /**
     * Delete all the emails from the blacklist
     */
    public function actionDelete_all()
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'email_id, subscriber_id, email';
        $criteria->limit  = 500;

        $models = EmailBlacklist::model()->findAll($criteria);
        while (!empty($models)) {
            foreach ($models as $model) {
                $model->delete();
            }
            $models = EmailBlacklist::model()->findAll($criteria);
        }

        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;

        if (!$request->getQuery('ajax')) {
            $notify->addSuccess(Yii::t('app', 'Your items have been successfully deleted!'));
            $this->redirect($request->getPost('returnUrl', array('email_blacklist/index')));
        }
    }

    /**
     * Export blacklisted emails
     */
    public function actionExport()
    {
        $request    = Yii::app()->request;
        $notify     = Yii::app()->notify;
        $redirect   = array('email_blacklist/index');

        if (!($fp = @fopen('php://output', 'w'))) {
            $notify->addError(Yii::t('email_blacklist', 'Cannot open export temporary file!'));
            $this->redirect($redirect);
        }

        $fileName = 'email-blacklist-' . date('Y-m-d-h-i-s') . '.csv';
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header('Content-type: application/csv');
        header("Content-Transfer-Encoding: Binary");
        header('Content-Disposition: attachment; filename="'.$fileName.'"');

        // columns
        $columns = array(
            Yii::t('email_blacklist', 'Email'),
            Yii::t('email_blacklist', 'Reason'),
            Yii::t('email_blacklist', 'Date added')
        );
        fputcsv($fp, $columns, ',', '"');

        // rows
        $limit  = 500;
        $offset = 0;
        $models = $this->getBlacklistedModels($limit, $offset);
        while (!empty($models)) {
            foreach ($models as $model) {
                $row = array($model->email, $model->reason, $model->dateAdded);
                fputcsv($fp, $row, ',', '"');
            }
            if (connection_status() != 0) {
                @fclose($fp);
                exit;
            }
            $offset = $offset + $limit;
            $models = $this->getBlacklistedModels($limit, $offset);
        }

        @fclose($fp);
        exit;
    }

    protected function getBlacklistedModels($limit = 100, $offset = 0)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 't.email, t.reason, t.date_added';
        $criteria->limit    = (int)$limit;
        $criteria->offset   = (int)$offset;
        return EmailBlacklist::model()->findAll($criteria);
    }

    /**
     * Import blacklisted emails
     */
    public function actionImport()
    {
        $request    = Yii::app()->request;
        $notify     = Yii::app()->notify;
        $redirect   = array('email_blacklist/index');

        if (!$request->isPostRequest) {
            $this->redirect($redirect);
        }

        ini_set('auto_detect_line_endings', true);

        $import = new EmailBlacklist('import');
        $import->file = CUploadedFile::getInstance($import, 'file');

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
            $notify->addError(Yii::t('email_blacklist', 'Your file does not contain the header with the fields title!'));
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
                $row = array_merge($row, $fill);
            } elseif ($rowCount > $columnCount) {
                $row = array_slice($row, 0, $columnCount);
            }

            $model = new EmailBlacklist();
            $data  = new CMap(array_combine($columns, $row));
            $model->email  = $data->itemAt('email');
            $model->reason = $data->itemAt('reason');
            if ($model->save()) {
                $totalImport++;
            }
            unset($model, $data);
        }

        $notify->addSuccess(Yii::t('email_blacklist', 'Your file has been successfuly imported, from {count} records, {total} were imported!', array(
            '{count}'   => ($totalRecords - 1),
            '{total}'   => $totalImport,
        )));

        $this->redirect($redirect);
    }

    /**
     * Callback to register Jquery ui bootstrap only for certain actions
     */
    public function _registerJuiBs($event)
    {
        if (in_array($event->params['action']->id, array('index', 'create', 'update'))) {
            $this->getData('pageStyles')->mergeWith(array(
                array('src' => Yii::app()->apps->getBaseUrl('assets/css/jui-bs/jquery-ui-1.10.3.custom.css'), 'priority' => -1001),
            ));
        }
    }
}
