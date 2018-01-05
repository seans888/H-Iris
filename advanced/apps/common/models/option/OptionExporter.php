<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * OptionExporter
 * 
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com> 
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.0
 */
 
class OptionExporter extends OptionBase
{
    // settings category
    protected $_categoryName = 'system.exporter';
    
    public $enabled = 'yes';
    
    public $records_per_file = 500;
    
    public $process_at_once = 50; // from a batch of 500, how many to process at once
    
    public $pause = 1; // pause between the batches
    
    public $memory_limit;
    
    public function rules()
    {
        $rules = array(
            array('enabled, records_per_file, process_at_once, pause', 'required'),
            array('enabled', 'in', 'range' => array_keys($this->getYesNoOptions())),
            array('records_per_file, process_at_once, pause', 'numerical', 'integerOnly' => true),
            array('records_per_file', 'numerical', 'min' => 50, 'max' => 100000),
            array('process_at_once', 'numerical', 'min' => 5, 'max' => 10000),
            array('process_at_once', 'compare', 'compareAttribute' => 'records_per_file', 'operator' => '<='),
            array('pause', 'numerical', 'min' => 0, 'max' => 60),
            array('memory_limit', 'in', 'range' => array_keys($this->getMemoryLimitOptions())),
        );
        
        return CMap::mergeArray($rules, parent::rules());    
    }
    
    public function attributeLabels()
    {
        $labels = array(
            'enabled'           => Yii::t('settings', 'Enabled'),
            'records_per_file'  => Yii::t('settings', 'Records per file'),
            'process_at_once'   => Yii::t('settings', 'Process at once'),
            'pause'             => Yii::t('settings', 'Pause'),
            'memory_limit'      => Yii::t('settings', 'Memory limit'),
        );
        
        return CMap::mergeArray($labels, parent::attributeLabels());    
    }
    
    public function attributePlaceholders()
    {
        $placeholders = array(
            'enabled'           => null,
            'records_per_file'  => null,
            'process_at_once'   => null,
            'pause'             => null,
            'memory_limit'      => null,
        );
        
        return CMap::mergeArray($placeholders, parent::attributePlaceholders());
    }
    
    public function attributeHelpTexts()
    {
        $texts = array(
            'enabled'           => Yii::t('settings', 'Whether customers are allowed to export subscribers.'),
            'records_per_file'  => Yii::t('settings', 'Maximum number of records in a single export file (please note, the export is a multi-file archive).'),
            'process_at_once'   => Yii::t('settings', 'How many subscribers to process at once for each file.'),
            'pause'             => Yii::t('settings', 'How many seconds the script should "sleep" after each batch of subscribers.'),
            'memory_limit'      => Yii::t('settings', 'The maximum memory amount the export process is allowed to use while processing one batch of subscribers.'),
        );
        
        return CMap::mergeArray($texts, parent::attributeHelpTexts());
    }
}
