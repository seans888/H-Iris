<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class StickySearchFiltersBehavior extends CActiveRecordBehavior
{
    /**
     * @return $this
     */
    public function setStickySearchFilters()
    {
        if (MW_IS_CLI) {
            return $this;
        }

        $appName           = Yii::app()->apps->getCurrentAppName();
        $session           = Yii::app()->session;
        $sessionKey        = sha1('search_' . $appName . '_' . get_class($this) . '_' . get_class($this->owner));
        $sessionAttributes = $session->get($sessionKey);
        $sessionAttributes = is_array($sessionAttributes) ? $sessionAttributes : array();
        
        $request    = Yii::app()->request;
        $attributes = (array)$request->getQuery($this->owner->modelName, array());
        
        
        $this->owner->attributes = CMap::mergeArray($sessionAttributes, $attributes);
        $session->add($sessionKey, $this->owner->attributes);

        return $this;
    }
}