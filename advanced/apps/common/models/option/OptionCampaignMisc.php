<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * OptionCampaignMisc
 *
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com>
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.3.5.9
 */

class OptionCampaignMisc extends OptionBase
{
    // settings category
    protected $_categoryName = 'system.campaign.misc';

    public $not_allowed_from_domains = '';
    
    public function rules()
    {
        $rules = array(
            array('not_allowed_from_domains', 'length', 'max' => 10000),
        );

        return CMap::mergeArray($rules, parent::rules());
    }

    public function attributeLabels()
    {
        $labels = array(
            'not_allowed_from_domains' => Yii::t('settings', 'Not allowed FROM domains'),
        );

        return CMap::mergeArray($labels, parent::attributeLabels());
    }

    public function attributePlaceholders()
    {
        $placeholders = array(
            'not_allowed_from_domains' => 'yahoo.com, gmail.com, aol.com',
        );
        return CMap::mergeArray($placeholders, parent::attributePlaceholders());
    }

    public function attributeHelpTexts()
    {
        $texts = array(
            'not_allowed_from_domains' => Yii::t('settings', 'List of domain names that are not allowed to be used in the campaign FROM email address. Separate multiple domains by a comma'),
        );

        return CMap::mergeArray($texts, parent::attributeHelpTexts());
    }

    protected function beforeValidate()
    {
        $domains = CommonHelper::getArrayFromString($this->not_allowed_from_domains);
        foreach ($domains as $index => $domain) {
            if (!FilterVarHelper::url('http://' . $domain)) {
                unset($domains[$index]);
            }
        }
        $this->not_allowed_from_domains = CommonHelper::getStringFromArray($domains);

        return parent::beforeValidate();
    }
}
