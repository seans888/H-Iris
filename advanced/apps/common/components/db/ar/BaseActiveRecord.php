<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class BaseActiveRecord extends CActiveRecord
{
    const STATUS_ACTIVE = 'active';
    
    const STATUS_INACTIVE = 'inactive';
    
    const STATUS_DELETED = 'deleted';
    
    const BULK_ACTION_DELETE = 'delete';
    
    const BULK_ACTION_COPY = 'copy';
    
    const TEXT_YES = 'yes';
    
    const TEXT_NO = 'no';
    
    private $_modelName;
    
    private static $_relatedCached = array();
    
    protected $validationHasBeenMade = false;

    public function rules()
    {
        $hooks  = Yii::app()->hooks;
        $apps   = Yii::app()->apps;
        $filter = $apps->getCurrentAppName() . '_model_'.strtolower(get_class($this)).'_'.strtolower(__FUNCTION__);
        $rules  = $hooks->applyFilters($filter, new CList());
        
        $this->onRules(new CModelEvent($this, array(
            'rules' => $rules,
        )));
        
        return $rules->toArray();
    }
    
    public function onRules(CModelEvent $event)
    {
        $this->raiseEvent('onRules', $event);
    }
    
    public function behaviors()
    {
        $behaviors = CMap::mergeArray(parent::behaviors(), array(
            'shortErrors' => array(
                'class' => 'common.components.behaviors.AttributesShortErrorsBehavior'
            ),
            'fieldDecorator' => array(
                'class' => 'common.components.behaviors.AttributeFieldDecoratorBehavior'
            ),
            'modelMetaData' => array(
                'class' => 'common.components.db.behaviors.ModelMetaDataBehavior'
            ),
            'paginationOptions' => array(
                'class' => 'common.components.behaviors.PaginationOptionsBehavior'
            ),
            'stickySearchFilters' => array(
                'class' => 'common.components.behaviors.StickySearchFiltersBehavior'
            ),
        ));
        
        if ($this->hasAttribute('date_added') || $this->hasAttribute('last_updated')) {
            $behaviors['CTimestampBehavior'] = array(
                'class'           => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => null,
                'updateAttribute' => null,
            );
            
            if ($this->hasAttribute('date_added')) {
                $behaviors['CTimestampBehavior']['createAttribute'] = 'date_added';
            }
            
            if ($this->hasAttribute('last_updated')) {
                $behaviors['CTimestampBehavior']['updateAttribute'] = 'last_updated';
                $behaviors['CTimestampBehavior']['setUpdateOnCreate'] = true;
            }
        }
        
        $behaviors['dateTimeFormatter'] = array(
                'class' => 'common.components.db.behaviors.DateTimeFormatterBehavior',
                'dateAddedAttribute'    => 'date_added',
                'lastUpdatedAttribute'  => 'last_updated',
                'timeZone'              => null,
        );
        
        $behaviors = new CMap($behaviors);
        
        $hooks      = Yii::app()->hooks;
        $apps       = Yii::app()->apps;
        $filter     = $apps->getCurrentAppName() . '_model_'.strtolower(get_class($this)).'_'.strtolower(__FUNCTION__);
        $behaviors  = $hooks->applyFilters($filter, $behaviors);
        
        $this->onBehaviors(new CModelEvent($this, array(
            'behaviors' => $behaviors,
        )));
        
        return $behaviors->toArray();
    }

    public function onBehaviors(CModelEvent $event)
    {
        $this->raiseEvent('onBehaviors', $event);
    }
    
    public function attributeLabels()
    {
        $labels = new CMap(array(
            'status'        => Yii::t('app', 'Status'),
            'date_added'    => Yii::t('app', 'Date added'),
            'last_updated'  => Yii::t('app', 'Last updated'),
        ));
        
        $hooks  = Yii::app()->hooks;
        $apps   = Yii::app()->apps;
        $filter = $apps->getCurrentAppName() . '_model_'.strtolower(get_class($this)).'_'.strtolower(__FUNCTION__);
        $labels = $hooks->applyFilters($filter, $labels);
        
        $this->onAttributeLabels(new CModelEvent($this, array(
            'labels' => $labels,
        )));
        
        return $labels->toArray();
    }
    
    public function onAttributeLabels(CModelEvent $event)
    {
        $this->raiseEvent('onAttributeLabels', $event);
    }
    
    protected function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }
        
        $this->validationHasBeenMade = true;
        
        return true;
    }

    /**
     * @inheritdoc
     * @since 1.3.8.6
     */
    protected function afterValidate()
    {
        parent::afterValidate();

        $apps   = Yii::app()->apps;
        $action = $apps->getCurrentAppName() . '_model_' . strtolower(get_class($this)) . '_' . strtolower(__FUNCTION__);

        Yii::app()->hooks->doAction($action, $this);
    }

    /**
     * @inheritdoc
     * @since 1.3.8.6
     */
    protected function afterSave()
    {
        parent::afterSave();

        $apps   = Yii::app()->apps;
        $action = $apps->getCurrentAppName() . '_model_' . strtolower(get_class($this)) . '_' . strtolower(__FUNCTION__);

        Yii::app()->hooks->doAction($action, $this);
    }

    public function relations()
    {
        $hooks  = Yii::app()->hooks;
        $apps   = Yii::app()->apps;
        $filter = $apps->getCurrentAppName() . '_model_'.strtolower(get_class($this)).'_'.strtolower(__FUNCTION__);
        
        $relations = $hooks->applyFilters($filter, new CMap());
        
        $this->onRelations(new CModelEvent($this, array(
            'relations' => $relations,
        )));
        
        return $relations->toArray();
    }

    public function onRelations(CModelEvent $event)
    {
        $this->raiseEvent('onRelations', $event);
    }
    
    public function scopes()
    {
        $scopes = new CMap(array(
            'active' => array(
                'condition' => $this->getTableAlias(false, false).'`status` = :st',
                'params' => array(':st' => self::STATUS_ACTIVE),
            ),
            'inactive' => array(
                'condition' => $this->getTableAlias(false, false).'`status` = :st',
                'params' => array(':st' => self::STATUS_INACTIVE),
            ),
            'deleted' => array(
                'condition' => $this->getTableAlias(false, false).'`status` = :st',
                'params' => array(':st' => self::STATUS_DELETED),
            ),
        ));
        
        $hooks  = Yii::app()->hooks;
        $apps   = Yii::app()->apps;
        $filter = $apps->getCurrentAppName() . '_model_'.strtolower(get_class($this)).'_'.strtolower(__FUNCTION__);
        $scopes = $hooks->applyFilters($filter, $scopes);
        
        $this->onScopes(new CModelEvent($this, array(
            'scopes' => $scopes,
        )));
        
        return $scopes->toArray();
    }
    
    public function onScopes(CModelEvent $event)
    {
        $this->raiseEvent('onScopes', $event);
    }
    
    public function attributeHelpTexts()
    {
        $hooks  = Yii::app()->hooks;
        $apps   = Yii::app()->apps;
        $filter = $apps->getCurrentAppName() . '_model_'.strtolower(get_class($this)).'_'.strtolower(__FUNCTION__);
        $texts  = $hooks->applyFilters($filter, new CMap());
        
        $this->onAttributeHelpTexts(new CModelEvent($this, array(
            'texts' => $texts,
        )));
        
        return $texts->toArray();
    }

    public function onAttributeHelpTexts(CModelEvent $event)
    {
        $this->raiseEvent('onAttributeHelpTexts', $event);
    }
    
    public function attributePlaceholders()
    {
        $hooks  = Yii::app()->hooks;
        $apps   = Yii::app()->apps;
        $filter = $apps->getCurrentAppName() . '_model_'.strtolower(get_class($this)).'_'.strtolower(__FUNCTION__);
        
        $placeholders = $hooks->applyFilters($filter, new CMap());
        
        $this->onAttributePlaceholders(new CModelEvent($this, array(
            'placeholders' => $placeholders,
        )));
        
        return $placeholders->toArray();
    }

    public function onAttributePlaceholders(CModelEvent $event)
    {
        $this->raiseEvent('onAttributePlaceholders', $event);
    }
    
    public function getModelName()
    {
        if ($this->_modelName === null) {
            $this->_modelName = get_class($this);
        }
        return $this->_modelName;
    }
    
    public function statusIs($status = self::STATUS_ACTIVE)
    {
        if (!is_array($status)) {
            $status = array($status);
        }
        $criteria = new CDbCriteria();
        $criteria->addInCondition($this->getTableAlias(false, false).'status', $status);
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
    }
    
    public function statusIsNot($status = self::STATUS_ACTIVE)
    {
        if (!is_array($status)) {
            $status = array($status);
        }
        $criteria = new CDbCriteria();
        $criteria->addNotInCondition($this->getTableAlias(false, false).'status', $status);
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
    }
    
    public function getStatusesList()
    {
        return array(
            self::STATUS_ACTIVE     => Yii::t('app', 'Active'),
            self::STATUS_INACTIVE   => Yii::t('app', 'Inactive'),
            // self::STATUS_DELETED    => Yii::t('app', 'Deleted'),
        );
    }
    
    public function getBulkActionsList()
    {
        return array(
            self::BULK_ACTION_DELETE => Yii::t('app', 'Delete'),
        );
    }
    
    public function getStatusName($status = null)
    {
        if (!$status && $this->hasAttribute('status')) {
            $status = $this->status;
        }
        if (!$status) {
            return;
        }
        $list = $this->getStatusesList();
        return isset($list[$status]) ? $list[$status] : Yii::t('app', ucfirst(preg_replace('/[^a-z]/', ' ', strtolower($status))));
    }
    
    public function getYesNoOptions()
    {
        return array(
            self::TEXT_YES  => ucfirst(Yii::t('app', self::TEXT_YES)),
            self::TEXT_NO   => ucfirst(Yii::t('app', self::TEXT_NO)),
        );
    }
    
    public function getComparisonSignsList()
    {
        return array(
            '='  => '=',
            '>'  => '>',
            '>=' => '>=',
            '<'  => '<',
            '<=' => '<=',
            '<>' => '<>',
        );
    }

    /**
     * @since 1.3.6.2
     * @return array
     */
    public function getSortOrderList()
    {
        return array_combine(range(-100, 100), range(-100, 100));
    }
    
    /**
     * Since 1.3.4.6
     * Override parent implementation to add global in memory cache, in testing for now...
     * This can become a memory hog containing unused models...
     */
    public function getRelated($name,$refresh=false,$params=array())
    {
        $cache = false;
        if (($md = $this->getMetaData()) && isset($md->relations[$name]) && is_object($md->relations[$name]) && is_string($md->relations[$name]->foreignKey) && $this->hasAttribute($md->relations[$name]->foreignKey)) {
            $relationKey = $md->relations[$name]->foreignKey;
            $cacheKey    = $name . '_' . $md->relations[$name]->className . '_' . get_class($this);
            $relationKey = $this->$relationKey;
            $cache       = true;
        }
        
        if (($refresh || !empty($params)) && $cache && (isset(self::$_relatedCached[$cacheKey][$relationKey]) || array_key_exists($relationKey, self::$_relatedCached[$cacheKey]))) {
            unset(self::$_relatedCached[$cacheKey][$relationKey]);
        }
        
        if ($cache && !isset(self::$_relatedCached[$cacheKey])) {
            self::$_relatedCached[$cacheKey] = array();
        }
        
        $related = -1;
        if ($cache && (isset(self::$_relatedCached[$cacheKey][$relationKey]) || array_key_exists($relationKey, self::$_relatedCached[$cacheKey]))) {
            $related = self::$_relatedCached[$cacheKey][$relationKey];
        } 
        
        if ($related === -1) {
            $related = parent::getRelated($name,$refresh,$params);
            if ($cache) {
                self::$_relatedCached[$cacheKey][$relationKey] =& $related;
            }
        }
        
        return $related;
    }
}