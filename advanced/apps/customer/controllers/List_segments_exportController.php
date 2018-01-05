<?php defined('MW_PATH') || exit('No direct script access allowed');



class List_segments_exportController extends Controller
{
    public function init()
    {
        parent::init();

        if (Yii::app()->options->get('system.exporter.enabled', 'yes') != 'yes') {
            $this->redirect(array('lists/index'));
        }

        $customer = Yii::app()->customer->getModel();
        if ($customer->getGroupOption('lists.can_import_subscribers', 'yes') != 'yes') {
            $this->redirect(array('lists/index'));
        }

        $this->getData('pageScripts')->add(array('src' => AssetsUrl::js('list-segments-export.js')));
    }

    /**
     * Display the export options
     */
    public function actionIndex($list_uid, $segment_uid)
    {
        $list    = $this->loadListModel($list_uid);
        $segment = $this->loadSegmentModel($list->list_id, $segment_uid);

        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | '. Yii::t('list_export', 'Export subscribers from your list segment'),
            'pageHeading'       => Yii::t('list_export', 'Export subscribers'),
            'pageBreadcrumbs'   => array(
                Yii::t('lists', 'Lists') => $this->createUrl('lists/index'),
                $list->name => $this->createUrl('lists/overview', array('list_uid' => $list->list_uid)),
                Yii::t('lists', 'Segments') => $this->createUrl('list_segments/index', array('list_uid' => $list->list_uid)),
                $segment->name => $this->createUrl('list_segments/update', array('list_uid' => $list->list_uid, 'segment_uid' => $segment->segment_uid)),
                Yii::t('list_export', 'Export subscribers')
            )
        ));

        $this->render('list', compact('list', 'segment'));
    }

    /**
     * Handle the CSV export option
     */
    public function actionCsv($list_uid, $segment_uid)
    {
        $list       = $this->loadListModel($list_uid);
        $segment    = $this->loadSegmentModel($list->list_id, $segment_uid);
        $customer   = $list->customer;
        $request    = Yii::app()->request;
        $options    = Yii::app()->options;

        $export = new ListSegmentCsvExport();
        $export->list_id    = $list->list_id; // should not be assigned in attributes
        $export->segment_id = $segment->segment_id; // should not be assigned in attributes

        $maxFileRecords = (int)$options->get('system.exporter.records_per_file', 500);
        $processAtOnce = (int)$options->get('system.exporter.process_at_once', 50);
        $pause = (int)$options->get('system.exporter.pause', 1);

        set_time_limit(0);
        if ($memoryLimit = $options->get('system.exporter.memory_limit')) {
            ini_set('memory_limit', $memoryLimit);
        }
        ini_set("auto_detect_line_endings", true);

        if ($request->isPostRequest && ($attributes = (array)$request->getPost($export->modelName, array()))) {
            $export->attributes = $attributes;
        }

        if (!$export->count) {
            $export->count = $export->countSubscribers();
        }

        if (!$request->isPostRequest || !$request->isAjaxRequest) {
            $this->setData(array(
                'pageMetaTitle'     => $this->data->pageMetaTitle.' | '.Yii::t('list_export', 'Export subscribers'),
                'pageHeading'       => Yii::t('list_export', 'Export subscribers'),
                'pageBreadcrumbs'   => array(
                    Yii::t('lists', 'Lists') => $this->createUrl('lists/index'),
                    $list->name => $this->createUrl('lists/overview', array('list_uid' => $list->list_uid)),
                    Yii::t('lists', 'Segments') => $this->createUrl('list_segments/index', array('list_uid' => $list->list_uid)),
                    $segment->name => $this->createUrl('list_segments/update', array('list_uid' => $list->list_uid, 'segment_uid' => $segment->segment_uid)),
                    Yii::t('list_export', 'Export subscribers') => $this->createUrl('list_segments_export/index', array('list_uid' => $list->list_uid, 'segment_uid' => $segment->segment_uid)),
                    Yii::t('list_export', 'CSV Export')
                )
            ));
            return $this->render('csv', compact('list', 'segment', 'export', 'maxFileRecords', 'pause'));
        }

        if (!class_exists('ZipArchive', false)) {
            return $this->renderJson(array(
                'result'    => 'error',
                'message'   => Yii::t('app', 'Temporary error, missing ZipArchive class!'),
            ));
        }

        if ($export->count == 0) {
            return $this->renderJson(array(
                'result'    => 'error',
                'message'   => Yii::t('list_export', 'Your list has no subscribers to export!'),
            ));
        }

        $baseStorageDir = Yii::getPathOfAlias('common.runtime.list-segment-export') . '/' . $list->list_uid;
        $storageDir     = $baseStorageDir . '/' . $segment->segment_uid;
        $csvFile        = $storageDir.'/part-'.(int)$export->current_page.'.csv';
        $prefix         = strtolower(preg_replace('/[^a-z0-9]/i', '-', $segment->name));
        $zipName        = $prefix . '-'. $segment->segment_uid.'.zip';

        if ($export->is_first_batch) {
            // old zip
            if (is_file($oldZipFile = $baseStorageDir.'/'.$zipName)) {
                 @unlink($oldZipFile);
             }
            // old imports not removed
            if (file_exists($storageDir) && is_dir($storageDir)) {
                FileSystemHelper::deleteDirectoryContents($storageDir, true, 1);
            }
            // new ones
            if (!file_exists($storageDir) && !is_dir($storageDir) && !@mkdir($storageDir, 0777, true)) {
                return $this->renderJson(array(
                    'result'    => 'error',
                    'message'   => Yii::t('list_export', 'Cannot create the storage directory for your export!'),
                ));
            }

            $export->is_first_batch = 0;
        }

        if (!is_file($csvFile) && !@touch($csvFile)) {
            return $this->renderJson(array(
                'result'    => 'error',
                'message'   => Yii::t('list_export', 'Cannot create the storage file for your export!'),
            ));
        }

        if (!($fp = @fopen($csvFile, 'w'))) {
            return $this->renderJson(array(
                'result'    => 'error',
                'message'   => Yii::t('list_export', 'Cannot open the storage file for your export!'),
            ));
        }

        // inner rounds ?
        if ($maxFileRecords <= $processAtOnce) {
            $rounds = 1;
        } else {
            $rounds = round($maxFileRecords / $processAtOnce);
        }

        $exportLog = array();
        $headerSet = false;
        $hasData = false;
        $counter = 0;
        $startFromOffset = ($export->current_page - 1) * $maxFileRecords;

        for ($i = 0; $i < $rounds; ++$i) {

            $limit = $processAtOnce;
            $offset = ($processAtOnce * $i) + $startFromOffset;
            $subscribers = $export->findSubscribers($limit, $offset);

            if (empty($subscribers)) {
                continue;
            }

            if (!$headerSet) {
                fputcsv($fp, array_keys($subscribers[0]), ',', '"');
                $headerSet = true;
            }

            foreach ($subscribers as $subscriberData) {
                if (EmailBlacklist::isBlacklisted($subscriberData['EMAIL'], null, $customer, array('checkZone' => EmailBlacklist::CHECK_ZONE_LIST_EXPORT))) {
                    $exportLog[] = array(
                        'type'      => 'error',
                        'message'   => Yii::t('list_export', 'The email "{email}" is blacklisted and was not added to the export list.', array(
                            '{email}' => $subscriberData['EMAIL'],
                        )),
                        'counter'   => true,
                    );
                    continue;
                }

                fputcsv($fp, array_values($subscriberData), ',', '"');
                $exportLog[] = array(
                    'type'      => 'success',
                    'message'   => Yii::t('list_export', 'Successfully added the email "{email}" to the export list.', array(
                        '{email}' => $subscriberData['EMAIL'],
                    )),
                    'counter'   => true,
                );
            }

            if (!$hasData && !empty($subscribers)) {
                $hasData = true;
            }
            $counter += count($subscribers);
        }
        fclose($fp);

        if ($counter > 0) {
            $exportLog[] = array(
                'type'      => 'info',
                'message'   => Yii::t('list_export', 'Exported {count} subscribers, from {start} to {end}.', array(
                    '{count}'   => $counter,
                    '{start}'   => ($export->current_page - 1) * $maxFileRecords,
                    '{end}'     => (($export->current_page - 1) * $maxFileRecords) + $maxFileRecords,
                )),
            );
        }

        // is it done ?
        if (!$hasData || ($export->current_page * $maxFileRecords >= $export->count)) {

            $exportLog[] = array(
                'type'      => 'success',
                'message'   => Yii::t('list_export', 'The export is now complete, starting the packing process...')
            );

            $zip = new ZipArchive();
             if (is_file($oldZipFile = $baseStorageDir.'/'.$zipName)) {
                 @unlink($oldZipFile);
             }

            if($zip->open($baseStorageDir.'/'.$zipName, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) !== true){
                FileSystemHelper::deleteDirectoryContents($storageDir, true, 1);
                return $this->renderJson(array(
                    'result'        => 'error',
                    'message'       => Yii::t('list_export', 'Cannot create the zip archive of your export!'),
                    'export_log'    => $exportLog,
                ));
            }

            for ($i = 1; $i <= (int)$export->current_page; ++$i) {
                if (is_file($file = $storageDir.'/part-'.$i.'.csv')) {
                    $zip->addFile($file, 'part-'.$i.'.csv');
                }
            }

            $zip->close();
            $downloadUrl = $this->createUrl('list_segments_export/csv_download', array('list_uid' => $list_uid, 'segment_uid' => $segment_uid));

            if (file_exists($storageDir) && is_dir($storageDir)) {
                FileSystemHelper::deleteDirectoryContents($storageDir, true, 1);
            }

            return $this->renderJson(array(
                'result'        => 'success',
                'message'       => Yii::t('list_export', 'Packing done, your file will be downloaded now, please wait...'),
                'download'      => $downloadUrl,
                'export_log'    => $exportLog,
                'recordsCount'  => $export->count,
            ));
        }

        $export->current_page++;
        return $this->renderJson(array(
            'result'        => 'success',
            'message'       => Yii::t('list_export', 'Please wait, starting another batch...'),
            'attributes'    => $export->attributes,
            'export_log'    => $exportLog,
            'recordsCount'  => $export->count,
        ));
    }

    /**
     * Download the zip archive created from export
     */
    public function actionCsv_download($list_uid, $segment_uid)
    {
        $list    = $this->loadListModel($list_uid);
        $segment = $this->loadSegmentModel($list->list_id, $segment_uid);
        $request = Yii::app()->request;

        $baseStorageDir = Yii::getPathOfAlias('common.runtime.list-segment-export') . '/' . $list->list_uid;
        $storageDir     = $baseStorageDir . '/' . $segment->segment_uid;
        $prefix         = strtolower(preg_replace('/[^a-z0-9]/i', '-', $segment->name));
        $zipName        = $prefix . '-'. $segment->segment_uid.'.zip';
        $zipPath        = $baseStorageDir . '/' . $zipName;

        if (!is_file($zipPath)) {
            Yii::app()->notify->addError(Yii::t('list_export', 'The export file has been deleted.'));
            $this->createUrl('list_segments_export/index', array('list_uid' => $list->list_uid, 'segment_uid' => $segment->segment_uid));
        }

        if (!($fp = @fopen($zipPath, "rb"))) {
            @unlink($zipPath);
            Yii::app()->notify->addError(Yii::t('list_export', 'The export file has been deleted.'));
            $this->createUrl('list_segments_export/index', array('list_uid' => $list->list_uid, 'segment_uid' => $segment->segment_uid));
        }

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header('Content-type: application/zip');
        header("Content-Transfer-Encoding: Binary");
        header('Content-Disposition: attachment; filename="'.$zipName.'"');
        header("Content-Length: ".filesize($zipPath));

        while(!feof($fp)) {
            echo fread($fp, 8192);
            flush();
            if (connection_status() != 0) {
                @fclose($fp);
                @unlink($zipPath);
                die();
            }
        }
        @fclose($fp);
        @unlink($zipPath);
    }

    /**
     * Helper method to load the list AR model
     */
    public function loadListModel($list_uid)
    {
        $model = Lists::model()->findByAttributes(array(
            'list_uid'      => $list_uid,
            'customer_id'   => (int)Yii::app()->customer->getId(),
        ));

        if ($model === null) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        return $model;
    }

    /**
     * Helper method to load the segment AR model
     */
    public function loadSegmentModel($list_id, $segment_uid)
    {
        $model = ListSegment::model()->findByAttributes(array(
            'list_id'     => $list_id,
            'segment_uid' => $segment_uid,
        ));

        if ($model === null) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        return $model;
    }
}
