<?php defined('MW_PATH') || exit('No direct script access allowed'); 


 
class Controller extends BaseController
{
    public $cacheableActions = array('index', 'view');
    
    public function init()
    {
        $options = Yii::app()->options;
        
        if ($options->get('system.common.api_status', 'online') != 'online' || $options->get('system.common.site_status', 'online') != 'online') {
            return $this->renderJson(array(
                'status'    => 'error',
                'error'     => Yii::t('api', 'Service Unavailable.')
            ), 503);    
        }
        
        parent::init();
    }
    
    public function filters()
    {
        if (empty($this->cacheableActions) || !is_array($this->cacheableActions)) {
            $this->cacheableActions = array('index', 'view');
        }
        $cacheableActions = implode(', ', $this->cacheableActions);
        
        return array(
            array(
                'api.components.web.filters.RequestAccessFilter',
            ),
            
            'accessControl',
            
            array(
                'system.web.filters.CHttpCacheFilter + ' . $cacheableActions,
                'cacheControl'              => 'no-cache, must-revalidate',
                'lastModifiedExpression'    => array($this, 'generateLastModified'),
                'etagSeedExpression'        => array($this, 'generateEtagSeed'),
            ),
        );
    }
    
    // access rules for all controller
    public function accessRules()
    {
        return array(
            // deny every action by default unless specified otherwise in child controllers.
            array('deny'),
        );
    }
    
    public function generateLastModified()
    {
        return time();
    }
    
    public function generateEtagSeed()
    {
        $params = (array)Yii::app()->request->getQuery(null);
        return $this->id . $this->action->id . serialize($params) . $this->generateLastModified();
    }
}
