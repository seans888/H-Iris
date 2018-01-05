<?php defined('MW_PATH') || exit('No direct script access allowed');



class ListTextImport extends ListImportAbstract
{

    public function rules()
    {
        $mimes   = null;
        $options = Yii::app()->options;
        if ($options->get('system.importer.check_mime_type', 'yes') == 'yes' && CommonHelper::functionExists('finfo_open')) {
            $mimes = Yii::app()->extensionMimes->get('txt')->toArray();
        }

        $rules = array(
            array('file', 'required', 'on' => 'upload'),
            array('file', 'file', 'types' => array('txt'), 'mimeTypes' => $mimes, 'maxSize' => $this->file_size_limit, 'allowEmpty' => true),
            array('file_name', 'length', 'is' => 44),
        );

        return CMap::mergeArray($rules, parent::rules());
    }
}
