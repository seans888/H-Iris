<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * OptionEmailTemplate
 * 
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com> 
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.0
 */
 
class OptionEmailTemplate extends OptionBase
{
    // settings category
    protected $_categoryName = 'system.email_templates';
    
    public $common; 

    public function rules()
    {
        $rules = array(
            array('common', 'required', 'on' => 'common'),
        );
        
        return CMap::mergeArray($rules, parent::rules());    
    }
    
    public function attributeLabels()
    {
        $labels = array(
            'common'    => Yii::t('settings', 'Common template'),
        );
        
        return CMap::mergeArray($labels, parent::attributeLabels());    
    }
    
    public function attributePlaceholders()
    {
        $placeholders = array(
            'common' => null,
        );
        
        return CMap::mergeArray($placeholders, parent::attributePlaceholders());
    }
    
    public function attributeHelpTexts()
    {
        $texts = array(
            'common' => Yii::t('settings', 'The "common" template is used when sending notifications, password reset emails, etc.'),
        );
        
        return CMap::mergeArray($texts, parent::attributeHelpTexts());
    }

    protected function beforeValidate()
    {
        if ($this->scenario == 'common' && strpos($this->common, '[CONTENT]') === false) {
            $this->addError('common', Yii::t('settings', 'The "[CONTENT]" tag is required but it has not been found in the content.'));
        }
        return parent::beforeValidate();
    }
}
