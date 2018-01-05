<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * OptionCustomization
 * 
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com> 
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.3.5.4
 */
 
class OptionCustomization extends OptionBase
{
    // settings category
    protected $_categoryName = 'system.customization';
    
    public $backend_logo_text;
    
    public $customer_logo_text;
    
    public $frontend_logo_text;
    
    public $backend_skin = 'blue';
    
    public $customer_skin = 'blue';
    
    public $frontend_skin = 'blue';

    public $backend_logo;
    public $backend_logo_up;

    public $customer_logo;
    public $customer_logo_up;

    public $frontend_logo;
    public $frontend_logo_up;
    
    public function rules()
    {
        $mimes = null;
        if (CommonHelper::functionExists('finfo_open')) {
            $mimes = Yii::app()->extensionMimes->get(array('png', 'jpg', 'gif'))->toArray();
        }
        
        $rules = array(
            array('backend_logo_up, customer_logo_up, frontend_logo_up', 'file', 'types' => array('png', 'jpg', 'gif'), 'mimeTypes' => $mimes, 'allowEmpty' => true),
            array('backend_logo, customer_logo, frontend_logo', '_validateLogoFile'),
            array('backend_logo_text, customer_logo_text, frontend_logo_text', 'length', 'max' => 100),
            array('backend_skin, customer_skin, frontend_skin', 'length', 'max' => 100),
        );
        return CMap::mergeArray($rules, parent::rules());    
    }
    
    public function attributeLabels()
    {
        $labels = array(
            'backend_logo_text'  => Yii::t('settings', 'Backend logo text'),
            'customer_logo_text' => Yii::t('settings', 'Customer logo text'),
            'frontend_logo_text' => Yii::t('settings', 'Frontend logo text'),
            'backend_skin'       => Yii::t('settings', 'Backend skin'),
            'customer_skin'      => Yii::t('settings', 'Customer skin'),
            'frontend_skin'      => Yii::t('settings', 'Frontend skin'),
            'backend_logo'       => Yii::t('settings', 'Backend logo'),
            'customer_logo'      => Yii::t('settings', 'Customer logo'),
            'frontend_logo'      => Yii::t('settings', 'Frontend logo'),
        );
        
        return CMap::mergeArray($labels, parent::attributeLabels());    
    }
    
    public function attributePlaceholders()
    {
        $placeholders = array(
            'backend_logo_text'  => Yii::t('app', 'Backend area'),
            'customer_logo_text' => Yii::t('app', 'Customer area'),
            'frontend_logo_text' => Yii::t('app', 'Frontend area'),
        );
        return CMap::mergeArray($placeholders, parent::attributePlaceholders());
    }
    
    public function attributeHelpTexts()
    {
        $texts = array(
            'backend_logo_text'  => Yii::t('settings', 'The text shown in backend area as the logo. Leave empty to use the defaults.'),
            'customer_logo_text' => Yii::t('settings', 'The text shown in customer area as the logo. Leave empty to use the defaults.'),
            'frontend_logo_text' => Yii::t('settings', 'The text shown in frontend as the logo. Leave empty to use the defaults.'),
            'backend_skin'       => Yii::t('settings', 'The CSS skin to be used in backend area.'),
            'customer_skin'      => Yii::t('settings', 'The CSS skin to be used in customer area.'),
            'frontend_skin'      => Yii::t('settings', 'The CSS skin to be used in frontend area.'),
        );
        
        return CMap::mergeArray($texts, parent::attributeHelpTexts());
    }

    protected function afterValidate()
    {
        parent::afterValidate();
        $this
            ->handleUploadedAvatar('backend_logo_up', 'backend_logo')
            ->handleUploadedAvatar('customer_logo_up', 'customer_logo')
            ->handleUploadedAvatar('frontend_logo_up', 'frontend_logo');
    }
    
    public static function buildHeaderLogoHtml(array $options = array())
    {
        $apps     = Yii::app()->apps;
        $instance = new self;
        
        if (empty($options['linkUrl']) && $apps->isAppName('frontend')) {
            $options['linkUrl'] = $apps->getAppBaseUrl('frontend', true, true);
        }

        $options  = array_merge(array(
            'app'       => $apps->getCurrentAppName(),
            'linkUrl'   => Yii::app()->createUrl('dashboard/index'),
            'linkClass' => 'logo icon',
        ), $options);
        
        if ($url = $instance->getLogoUrlByApp($options['app'], 220, 50)) {
            $text = CHtml::image($url, '', array('width' => 220, 'height' => 50));
        } elseif ($_text = $instance->getLogoTextByApp($options['app'])) {
            $text = $_text;
        } else {
            $text = Yii::t('app', ucfirst($options['app']) . ' area');
        }
        
        return CHtml::link($text, $options['linkUrl'], array('class' => $options['linkClass']));
    }
    
    public function getLogoUrlByApp($app, $width = 50, $height = 50)
    {
        $attribute = $app . '_logo';
        if (!isset($this->$attribute) || empty($this->$attribute)) {
            return false;
        }
        return ImageHelper::resize($this->$attribute, $width, $height);
    }

    public function getLogoTextByApp($app)
    {
        $attribute = $app . '_logo_text';
        if (!isset($this->$attribute) || empty($this->$attribute)) {
            return false;
        }
        return $this->$attribute;
    }

    public function getBackendLogoUrl($width = 50, $height = 50, $forceSize = false)
    {
        if (empty($this->backend_logo)) {
            return $this->getDefaultLogoUrl($width, $height);
        }
        return ImageHelper::resize($this->backend_logo, $width, $height, $forceSize);
    }

    public function getCustomerLogoUrl($width = 50, $height = 50, $forceSize = false)
    {
        if (empty($this->customer_logo)) {
            return $this->getDefaultLogoUrl($width, $height);
        }
        return ImageHelper::resize($this->customer_logo, $width, $height, $forceSize);
    }

    public function getFrontendLogoUrl($width = 50, $height = 50, $forceSize = false)
    {
        if (empty($this->frontend_logo)) {
            return $this->getDefaultLogoUrl($width, $height);
        }
        return ImageHelper::resize($this->frontend_logo, $width, $height, $forceSize);
    }
    
    public function getDefaultLogoUrl($width, $height)
    {
        return sprintf('https://placeholdit.imgix.net/~text?txtsize=33&txt=...&w=%d&h=%d', $width, $height);
    }
    
    public function getAppSkins($appName)
    {
        $skins = array('');
        $paths = array('root.assets.css', 'root.'.$appName.'.assets.css');
        foreach ($paths as $path) {
            foreach ((array)glob(Yii::getPathOfAlias($path) . '/skin-*.css') as $file) {
                $fileName = basename($file, '.css');
                if (strpos($fileName, 'skin-') === 0) {
                    $skins[] = $fileName;
                }
            }    
        }
        
        $_skins = array_unique($skins);
        $skins  = array();
        foreach ($_skins as $skin) {
            $skinName = str_replace('skin-', '', $skin);
            $skinName = preg_replace('/[^a-z0-9]/i', ' ', $skinName);
            $skinName = ucwords($skinName);
            $skins[$skin] = str_replace(' Min', ' (Minified)', $skinName);
        }
        return $skins;
    }

    protected function handleUploadedAvatar($attribute, $targetAttribute)
    {
        if ($this->hasErrors()) {
            return $this;
        }

        if (!($logo = CUploadedFile::getInstance($this, $attribute))) {
            return $this;
        }

        $storagePath = Yii::getPathOfAlias('root.frontend.assets.files.logos');
        if (!file_exists($storagePath) || !is_dir($storagePath)) {
            if (!@mkdir($storagePath, 0777, true)) {
                $this->addError($attribute, Yii::t('settings', 'The logos storage directory({path}) does not exists and cannot be created!', array(
                    '{path}' => $storagePath,
                )));
                return $this;
            }
        }

        $newAvatarName = uniqid(rand(0, time())) . '-' . $logo->getName();
        if (!$logo->saveAs($storagePath . '/' . $newAvatarName)) {
            $this->addError($attribute, Yii::t('customers', 'Cannot move the logo into the correct storage folder!'));
            return $this;
        }

        $this->$targetAttribute = '/frontend/assets/files/logos/' . $newAvatarName;
        return $this;
    }
    
    public function _validateLogoFile($attribute, $params)
    {
        if ($this->hasErrors($attribute) || empty($this->$attribute)) {
            return;
        }
        $fullPath = Yii::getPathOfAlias('root') . $this->$attribute;
        if (strpos($this->$attribute, '/frontend/assets/files/logos/') !== 0 || !is_file($fullPath) || !($info = @getimagesize($fullPath))) {
            $this->addError($attribute, Yii::t('settings', 'Seems that "{attr}" is not a valid image!', array(
                '{attr}' => $this->getAttributeLabel($attribute)
            )));
            return;
        }
    }

}
