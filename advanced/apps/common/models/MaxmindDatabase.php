<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class MaxmindDatabase extends FormModel
{
    /**
     * @return CArrayDataProvider
     */
    public function getDataProvider()
    {
        return new CArrayDataProvider(array(
            array(
                'id'     => strtolower(basename(Yii::app()->params['ip.location.maxmind.db.path'])),
                'name'   => basename(Yii::app()->params['ip.location.maxmind.db.path']),
                'path'   => Yii::app()->params['ip.location.maxmind.db.path'],
                'url'    => Yii::app()->params['ip.location.maxmind.db.url'],
                'exists' => is_file(Yii::app()->params['ip.location.maxmind.db.path']),
            )
        ));
    }

    /**
     * Add error message
     */
    public static function addNotifyErrorIfMissingDbFile()
    {
        if (is_file(Yii::app()->params['ip.location.maxmind.db.path'])) {
            return;
        }
        
        $errorMessage = array(
            Yii::t('ip_location', 'The database file which should be located at "{path}" is missing!', array('{path}' => Yii::app()->params['ip.location.maxmind.db.path'])),
            Yii::t('ip_location', 'Please download latest version from {link}, decompress it and place the resulted .mmdb file to be accessible at the above path!', array(
                '{link}' => CHtml::link(Yii::t('ip_location', 'Maxmind\'s site'), Yii::app()->params['ip.location.maxmind.db.url'], array('target' => '_blank')),
            ))
        );
        Yii::app()->notify->addError($errorMessage);
    }
}