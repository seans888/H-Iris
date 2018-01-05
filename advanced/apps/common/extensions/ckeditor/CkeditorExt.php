<?php defined('MW_PATH') || exit('No direct script access allowed');



class CkeditorExt extends ExtensionInit
{
    // name of the extension as shown in the backend panel
    public $name = 'CKeditor';

    // description of the extension as shown in backend panel
    public $description = 'CKeditor for MailWizz EMA';

    // current version of this extension
    public $version = '1.2.5';

    // the author name
    public $author = 'Cristian Serban';

    // author website
    public $website = 'http://www.mailwizz.com/';

    // contact email address
    public $email = 'cristian.serban@mailwizz.com';

    // in which apps this extension is not allowed to run
    public $allowedApps = array('backend', 'customer');

    // can this extension be deleted? this only applies to core extensions.
    protected $_canBeDeleted = false;

    // can this extension be disabled? this only applies to core extensions.
    protected $_canBeDisabled = true;

    // the detected language
    protected $detectedLanguage = 'en';

    public function run()
    {
        // the callback to register the editor
        Yii::app()->hooks->addAction('wysiwyg_editor_instance', array($this, 'createNewEditorInstance'));

        // register the routes
        Yii::app()->urlManager->addRules(array(
            array('ext_ckeditor/index', 'pattern' => 'extensions/ckeditor'),
            array('ext_ckeditor/filemanager', 'pattern' => 'extensions/ckeditor/filemanager'),
            array('ext_ckeditor/filemanager_connector', 'pattern' => 'extensions/ckeditor/filemanager/connector'),
        ));

        // add the controller
        Yii::app()->controllerMap['ext_ckeditor'] = array(
            'class' => 'ext-ckeditor.controllers.Ext_ckeditorController',
        );
    }

    /**
     * Add the landing page for this extension (settings/general info/etc)
     */
    public function getPageUrl()
    {
        return Yii::app()->createUrl('ext_ckeditor/index');
    }

    public function createNewEditorInstance($editorOptions)
    {
        $this->registerAssets();

        $defaultWysiwygOptions = $this->getDefaultEditorOptions();
        $wysiwygOptions = (array)Yii::app()->hooks->applyFilters('wysiwyg_editor_global_options', $defaultWysiwygOptions);
        $wysiwygOptions = CMap::mergeArray($wysiwygOptions, $editorOptions);

        if (!isset($wysiwygOptions['id'])) {
            return;
        }

        $editorId = CHtml::encode($wysiwygOptions['id']);
        $optionsVarName = 'wysiwygOptions'.($editorId);
        $editorVarName  = 'wysiwygInstance'.($editorId);

        unset($wysiwygOptions['id']);

        $script  = $optionsVarName.' = ' . CJavaScript::encode($wysiwygOptions) . ';' . "\n";
        $script .= '$("#'.$editorId.'").ckeditor('.$optionsVarName.');' . "\n";
        $script .= $editorVarName .' = CKEDITOR.instances["'.$editorId.'"];' . "\n";

        Yii::app()->clientScript->registerScript(md5(__FILE__.__LINE__.$editorId), $script);
    }

    public function getEditorToolbar()
    {
        return Yii::app()->hooks->applyFilters('wysiwyg_editor_toolbar', $this->getOption('default_toolbar', 'Default'));
    }

    public function getEditorToolbars()
    {
        return (array)Yii::app()->hooks->applyFilters('wysiwyg_editor_toolbars', array('Default', 'Simple', 'Full'));
    }

    public function getFilemanagerThemes()
    {
        // cache
        static $themes = null;

        // if already loaded, return them all.
        if ($themes !== null && is_array($themes)) {
            return $themes;
        }

        if ($themes === null) {
            $themes    = array();
            $assetsUrl = $this->getAssetsUrl();
            $folders   = (array)FileSystemHelper::getDirectoryNames(Yii::getPathOfAlias($this->getPathAlias()) . '/assets/elfinder/themes/');
            foreach ($folders as $folderName) {
                $themes[] = array(
                    'name' => $folderName,
                    'url'  => $assetsUrl . '/elfinder/themes/' . $folderName . '/css/theme.css',
                );
            }
        }

        $themes = (array)Yii::app()->hooks->applyFilters('wysiwyg_filemanager_available_themes', $themes);
        $urls   = array();
        $names  = array();

        foreach ($themes as $index => $theme) {
            if (!isset($theme['name'], $theme['url'])) {
                unset($themes[$index]);
                continue;
            }
            $themeName = strtolower($theme['name']);
            $themeUrl  = strtolower($theme['url']);
            if (isset($urls[$themeUrl]) || isset($names[$themeName])) {
                unset($themes[$index]);
                continue;
            }
            $urls[$themeUrl]   = true;
            $names[$themeName] = true;
        }
        unset($names, $urls);

        return $themes;
    }

    public function getFilemanagerTheme($name)
    {
        if (empty($name)) {
            return null;
        }
        $themes = $this->getFilemanagerThemes();
        foreach ($themes as $theme) {
            if (strtolower($theme['name']) == strtolower($name)) {
                return $theme;
            }
        }
        return null;
    }

    public function getDefaultEditorOptions()
    {
        $apps     = Yii::app()->apps;
        $toolbar  = $this->getEditorToolbar();
        $toolbars = $this->getEditorToolbars();

        if (empty($toolbar) || empty($toolbars) || !in_array($toolbar, $toolbars)) {
            $toolbar = 'Default';
        }

        $orientation = Yii::app()->locale->orientation;
        if (Yii::app()->getController()) {
            $orientation = Yii::app()->getController()->getHtmlOrientation();
        }

        $options = array(
            'toolbar'               => $toolbar,
            'language'              => $this->detectedLanguage,
            'contentsLanguage'      => Yii::app()->locale->getLanguageID($this->detectedLanguage),
            'contentsLangDirection' => $orientation,
            'contentsCss'           => array(
                $apps->getBaseUrl('assets/css/bootstrap.min.css'),
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
                'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
                $apps->getBaseUrl('assets/css/adminlte.css'),
                $apps->getBaseUrl('assets/css/skin-blue.css'),
            ),
        );

        if ($this->getIsFilemanagerEnabled()) {
            $options['filebrowserBrowseUrl'] = $this->getFilemanagerUrl();
            // $options['filebrowserImageWindowWidth'] = 920;
            $options['filebrowserImageWindowHeight'] = 400;
        }

        return $options;
    }

    public function registerAssets()
    {
        static $_assetsRegistered = false;
        if ($_assetsRegistered) {
            return $this;
        }
        $_assetsRegistered = true;

        // set a flag to know which editor is active.
        Yii::app()->params['wysiwyg'] = 'ckeditor';

        $assetsUrl = $this->getAssetsUrl();
        Yii::app()->clientScript->registerScriptFile($assetsUrl . '/ckeditor/ckeditor.js');
        Yii::app()->clientScript->registerScriptFile($assetsUrl . '/ckeditor/adapters/jquery.js');

        // find the language file, if any.
        $language       = str_replace('_', '-', Yii::app()->language);
        $languageFile   = null;

        if (is_file(dirname(__FILE__) . '/assets/ckeditor/lang/'.$language.'.js')) {
            $languageFile = $language.'.js';
        }

        if ($languageFile === null && strpos($language, '-') !== false) {
            $language = explode('-', $language);
            $language = $language[0];
            if (is_file(dirname(__FILE__) . '/assets/ckeditor/lang/'.$language.'.js')) {
                $languageFile = $language.'.js';
            }
        }

        // if language found, register it.
        if ($languageFile !== null) {
            $this->detectedLanguage = $language;
            Yii::app()->clientScript->registerScriptFile($assetsUrl . '/ckeditor/lang/' . $languageFile);
        }

        return $this;
    }

    // the assets url, publish if needed.
    public function getAssetsUrl()
    {
        return Yii::app()->assetManager->publish(dirname(__FILE__).'/assets', false, -1, MW_DEBUG);
    }

    /**
     * @return bool
     */
    public function getIsFilemanagerEnabled()
    {
        if (($this->isAppName('backend') && $this->getOption('enable_filemanager_user')) || ($this->isAppName('customer') && $this->getOption('enable_filemanager_customer'))) {
           return true; 
        }
        
        return false;
    }

    /**
     * @return string
     */
    public function getFilemanagerUrl()
    {
        return Yii::app()->createUrl('ext_ckeditor/filemanager');
    }
}
