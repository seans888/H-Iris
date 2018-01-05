<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * ListDefaultFieldsBehavior
 * 
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com> 
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.0
 */
 
class ListDefaultFieldsBehavior extends CActiveRecordBehavior 
{
    public function afterSave($event)
    {
        $type = ListFieldType::model()->findByAttributes(array(
            'identifier' => 'text',
        ));
        
        if (empty($type)) {
            return;
        }
        
        $model = new ListField();
        $model->type_id     = $type->type_id;
        $model->list_id     = $this->owner->list_id;
        $model->label       = 'Email';
        $model->tag         = 'EMAIL';
        $model->required    = 'yes';
        $model->visibility  = 'visible';
        $model->sort_order  = 0;
        $model->save(false);
        
        $model = new ListField();
        $model->type_id     = $type->type_id;
        $model->list_id     = $this->owner->list_id;
        $model->label       = 'First name';
        $model->tag         = 'FNAME';
        $model->required    = 'no';
        $model->visibility  = 'visible';
        $model->sort_order  = 1;
        $model->save(false);
        
        $model = new ListField();
        $model->type_id     = $type->type_id;
        $model->list_id     = $this->owner->list_id;
        $model->label       = 'Last name';
        $model->tag         = 'LNAME';
        $model->required    = 'no';
        $model->visibility  = 'visible';
        $model->sort_order  = 2;
        $model->save(false);
    }
}