<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class AccountController extends Controller
{
    public function init()
    {
        $this->getData('pageScripts')->add(array('src' => AssetsUrl::js('account.js')));
        parent::init();    
    }
    
    /**
     * Default action, allowing to update the account.
     */
    public function actionIndex()
    {
        $customer = Yii::app()->customer->getModel();
        $customer->confirm_email = $customer->email;
        $customer->setScenario('update-profile');

        if (Yii::app()->request->isPostRequest && $attributes = Yii::app()->request->getPost($customer->modelName)) {
            $customer->attributes = $attributes;
            if ($customer->save()) {
                Yii::app()->notify->addSuccess(Yii::t('customers', 'Profile info successfully updated!'));
            }
            
            Yii::app()->hooks->doAction('controller_action_save_data', $collection = new CAttributeCollection(array(
                'controller'=> $this,
                'success'   => Yii::app()->notify->hasSuccess,
                'customer'  => $customer,
            )));
        }
        
        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | '. Yii::t('customers', 'Account info'),
            'pageHeading'       => Yii::t('customers', 'Account info'),
            'pageBreadcrumbs'   => array(
                Yii::t('customers', 'Account') => $this->createUrl('account/index'),
                Yii::t('app', 'Update')
            )
        ));
        
        $this->render('index', compact('customer'));
    }
    
    /**
     * Update the account company info
     */
    public function actionCompany()
    {
        $customer = Yii::app()->customer->getModel();
        
        if (empty($customer->company)) {
            $customer->company = new CustomerCompany();
        }
        
        $company = $customer->company;
        $request = Yii::app()->request;
        
        if ($request->isPostRequest && $attributes = $request->getPost($company->modelName)) {
            $company->attributes = $attributes;
            $company->customer_id = Yii::app()->customer->getId();
            
            if ($company->save()) {
                Yii::app()->notify->addSuccess(Yii::t('customers', 'Company info successfully updated!'));
            }
            
            Yii::app()->hooks->doAction('controller_action_save_data', $collection = new CAttributeCollection(array(
                'controller'=> $this,
                'success'   => Yii::app()->notify->hasSuccess,
                'customer'  => $customer,
                'company'   => $company,
            )));
        }
        
        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | '. Yii::t('customers', 'Company'),
            'pageHeading'       => Yii::t('customers', 'Company'),
            'pageBreadcrumbs'   => array(
                 Yii::t('customers', 'Account') => $this->createUrl('account/index'),
                 Yii::t('customers', 'Company') => $this->createUrl('account/company'),
                 Yii::t('app', 'Update')
            )
        ));
        
        $this->render('company', compact('company'));
    }

    /**
     * Disable the account
     */
    public function actionDisable()
    {
        $customer = Yii::app()->customer->getModel();
        $request  = Yii::app()->request;

        if ($request->isPostRequest) {
            $customer->saveStatus(Customer::STATUS_PENDING_DISABLE);
            
            Yii::app()->hooks->doAction('controller_action_save_data', $collection = new CAttributeCollection(array(
                'controller'=> $this,
                'success'   => true,
                'customer'  => $customer,
            )));

            if ($collection->success) {
                Yii::app()->customer->logout();
                Yii::app()->notify->addSuccess(Yii::t('customers', 'Your account has been successfully disabled!'));
                $this->redirect(array('guest/index'));
            }
        }

        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | '. Yii::t('customers', 'Disable account'),
            'pageHeading'       => Yii::t('customers', 'Disable account'),
            'pageBreadcrumbs'   => array(
                Yii::t('customers', 'Account') => $this->createUrl('account/index'),
                Yii::t('customers', 'Disable account')
            )
        ));

        $this->render('disable');
    }
    
    /**
     * Display stats about the account, limits, etc
     */
    public function actionUsage()
    {
        $request = Yii::app()->request;
        if (!$request->isAjaxRequest) {
            $this->redirect(array('account/index'));
        }
        
        $formatter = Yii::app()->format;
        $customer  = Yii::app()->customer->getModel();
        $data = array();
        
        // sending quota
        $allowed  = (int)$customer->getGroupOption('sending.quota', -1);
        $count    = $customer->countUsageFromQuotaMark();
        $data[] = array(
            'heading' => Yii::t('customers', 'Sending quota'),
            'allowed' => !$allowed ? 0 : ($allowed == -1 ? '&infin;' : $formatter->formatNumber($allowed)),
            'used'    => $formatter->formatNumber($count),
            'percent' => $percent = ($allowed < 1 ? 0 : ($count > $allowed ? 100 : round(($count / $allowed) * 100, 2))),  
            'url'     => 'javascript:;',
            'bar_color' => $percent < 50 ? 'green' : ($percent < 70 ? 'aqua' : ($percent < 90 ? 'yellow' : 'red')),
        );
        
        // lists
        $allowed  = (int)$customer->getGroupOption('lists.max_lists', -1);
        $criteria = new CDbCriteria();
        $criteria->compare('customer_id', (int)$customer->customer_id);
        $criteria->addNotInCondition('status', array(Lists::STATUS_PENDING_DELETE));
        $count    = Lists::model()->count($criteria);
          
        $data[] = array(
            'heading' => Yii::t('customers', 'Lists'),
            'allowed' => !$allowed ? 0 : ($allowed == -1 ? '&infin;' : $formatter->formatNumber($allowed)),
            'used'    => $formatter->formatNumber($count),
            'percent' => $percent = ($allowed < 1 ? 0 : ($count > $allowed ? 100 : round(($count / $allowed) * 100, 2))), 
            'url'     => Yii::app()->createUrl('lists/index'),
            'bar_color' => $percent < 50 ? 'green' : ($percent < 70 ? 'aqua' : ($percent < 90 ? 'yellow' : 'red')),
        );
        
        // campaigns
        $allowed  = (int)$customer->getGroupOption('campaigns.max_campaigns', -1);
        $criteria = new CDbCriteria();
        $criteria->compare('customer_id', (int)$customer->customer_id);
        $criteria->addNotInCondition('status', array(Campaign::STATUS_PENDING_DELETE));
        $count    = Campaign::model()->count($criteria);

        $data[] = array(
            'heading' => Yii::t('customers', 'Campaigns'),
            'allowed' => !$allowed ? 0 : ($allowed == -1 ? '&infin;' : $formatter->formatNumber($allowed)),
            'used'    => $formatter->formatNumber($count),
            'percent' => $percent = ($allowed < 1 ? 0 : ($count > $allowed ? 100 : round(($count / $allowed) * 100, 2))), 
            'url'     => Yii::app()->createUrl('campaigns/index'),
            'bar_color' => $percent < 50 ? 'green' : ($percent < 70 ? 'aqua' : ($percent < 90 ? 'yellow' : 'red')),
        );
        
        // subscribers
        $criteria = new CDbCriteria();
        $criteria->select = 'COUNT(DISTINCT(t.email)) as counter';
        $criteria->with = array(
            'list' => array(
                'select'   => false,
                'together' => true,
                'joinType' => 'INNER JOIN',
                'condition'=> 'list.customer_id = :cid AND list.status != :st',
                'params'   => array(':cid' => (int)$customer->customer_id, ':st' => Lists::STATUS_PENDING_DELETE),
            ),
        );
        $count    = ListSubscriber::model()->count($criteria);
        $allowed  = (int)$customer->getGroupOption('lists.max_subscribers', -1);
        $data[] = array(
            'heading' => Yii::t('customers', 'Subscribers'),
            'allowed' => !$allowed ? 0 : ($allowed == -1 ? '&infin;' : $formatter->formatNumber($allowed)),
            'used'    => $formatter->formatNumber($count),
            'percent' => $percent = ($allowed < 1 ? 0 : ($count > $allowed ? 100 : round(($count / $allowed) * 100, 2))), 
            'url'     => Yii::app()->createUrl('lists/index'),
            'bar_color' => $percent < 50 ? 'green' : ($percent < 70 ? 'aqua' : ($percent < 90 ? 'yellow' : 'red')),
        );
        
        // delivery servers
        $allowed  = (int)$customer->getGroupOption('servers.max_delivery_servers', 0);
        if ($allowed != 0) {
            $count    = DeliveryServer::model()->countByAttributes(array('customer_id' => $customer->customer_id));
            $data[] = array(
                'heading' => Yii::t('customers', 'Delivery servers'),
                'allowed' => !$allowed ? 0 : ($allowed == -1 ? '&infin;' : $formatter->formatNumber($allowed)),
                'used'    => $formatter->formatNumber($count),
                'percent' => $percent = ($allowed < 1 ? 0 : ($count > $allowed ? 100 : round(($count / $allowed) * 100, 2))), 
                'url'     => Yii::app()->createUrl('delivery_servers/index'),
                'bar_color' => $percent < 50 ? 'green' : ($percent < 70 ? 'aqua' : ($percent < 90 ? 'yellow' : 'red')),
            );
        }
        
        // bounce servers
        $allowed  = (int)$customer->getGroupOption('servers.max_bounce_servers', 0);
        if ($allowed != 0) {
            $count    = BounceServer::model()->countByAttributes(array('customer_id' => $customer->customer_id));
            $data[] = array(
                'heading' => Yii::t('customers', 'Bounce servers'),
                'allowed' => !$allowed ? 0 : ($allowed == -1 ? '&infin;' : $formatter->formatNumber($allowed)),
                'used'    => $formatter->formatNumber($count),
                'percent' => $percent = ($allowed < 1 ? 0 : ($count > $allowed ? 100 : round(($count / $allowed) * 100, 2))), 
                'url'     => Yii::app()->createUrl('bounce_servers/index'),
                'bar_color' => $percent < 50 ? 'green' : ($percent < 70 ? 'aqua' : ($percent < 90 ? 'yellow' : 'red')),
            );    
        }

        // fbl servers
        $allowed  = (int)$customer->getGroupOption('servers.max_fbl_servers', 0);
        if ($allowed != 0) {
            $count    = FeedbackLoopServer::model()->countByAttributes(array('customer_id' => $customer->customer_id));
            $data[] = array(
                'heading' => Yii::t('customers', 'Feedback servers'),
                'allowed' => !$allowed ? 0 : ($allowed == -1 ? '&infin;' : $formatter->formatNumber($allowed)),
                'used'    => $formatter->formatNumber($count),
                'percent' => $percent = ($allowed < 1 ? 0 : ($count > $allowed ? 100 : round(($count / $allowed) * 100, 2))),  
                'url'     => Yii::app()->createUrl('feedback_loop_servers/index'),
                'bar_color' => $percent < 50 ? 'green' : ($percent < 70 ? 'aqua' : ($percent < 90 ? 'yellow' : 'red')),
            );
        }
        
        return $this->renderJson(array(
            'html' => $this->renderPartial('_usage', array('items' => $data), true)
        ));
    }
    
    /**
     * Display country zones
     */
    public function actionZones_by_country()
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'zone_id, name';
        $criteria->compare('country_id', (int) Yii::app()->request->getQuery('country_id'));
        $models = Zone::model()->findAll($criteria);
        
        $zones = array(
            array('zone_id' => '', 'name' => Yii::t('app', 'Please select'))
        );
        foreach ($models as $model) {
            $zones[] = array(
                'zone_id'    => $model->zone_id, 
                'name'        => $model->name
            );
        }
        return $this->renderJson(array('zones' => $zones));
    }
    
    /**
     * Log the customer out
     */
    public function actionLogout()
    {
        $logoutUrl = Yii::app()->customer->loginUrl;
        
        if (Yii::app()->customer->getState('__customer_impersonate')) {
            $logoutUrl = Yii::app()->apps->getAppUrl('backend', 'customers/index', true);
        }
        
        Yii::app()->customer->logout();
        $this->redirect($logoutUrl);    
    }

    /**
     * Save the grid view columns for this user
     */
    public function actionSave_grid_view_columns()
    {
        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;

        $model      = $request->getPost('model');
        $controller = $request->getPost('controller');
        $action     = $request->getPost('action');
        $columns    = $request->getPost('columns', array());

        if (!($redirect = $request->getServer('HTTP_REFERER'))) {
            $redirect = array('dashboard/index');
        }

        if (!$request->getIsPostRequest()) {
            $this->redirect($redirect);
        }

        if (empty($model) || empty($controller) || empty($action) || empty($columns) || !is_array($columns)) {
            $this->redirect($redirect);
        }

        $optionKey  = sprintf('%s:%s:%s', (string)$model, (string)$controller, (string)$action);
        $customerId = (int)Yii::app()->customer->getId();
        $optionKey  = sprintf('system.views.grid_view_columns.customers.%d.%s', $customerId, $optionKey);
        Yii::app()->options->set($optionKey, (array)$columns);

        $notify->addSuccess(Yii::t('app', 'Your form has been successfully saved!'));
        $this->redirect($redirect);
    }
    
    /**
     * Callback method to render the customer account tabs
     */
    public function renderTabs()
    {
        $route = Yii::app()->getController()->getRoute();
        $priority = 0;
        $tabs = array();
        
        $tabs[] = array(
            'label'     => IconHelper::make('glyphicon-list') . ' ' . Yii::t('customers', 'Profile'), 
            'url'       => array('account/index'), 
            'active'    => strpos('account/index', $route) === 0,
            'priority'  => (++$priority),
        );
        
        $tabs[] = array(
            'label'     => IconHelper::make('glyphicon-briefcase') . ' ' .Yii::t('customers', 'Company'), 
            'url'       => array('account/company'), 
            'active'    => strpos('account/company', $route) === 0,
            'priority'  => (++$priority),
        );

        $tabs[] = array(
            'label'     => IconHelper::make('glyphicon-ban-circle') . ' ' . Yii::t('customers', 'Disable account'),
            'url'       => array('account/disable'),
            'active'    => strpos('account/disable', $route) === 0,
            'priority'  => 99,
        );
        
        // since 1.3.6.2
        $tabs = Yii::app()->hooks->applyFilters('customer_account_edit_render_tabs', $tabs);

        $sort = array();
        foreach ($tabs as $index => $tab) {
            if (!isset($tab['label'], $tab['url'], $tab['active'])) {
                unset($tabs[$index]);
                continue;
            }
            
            $sort[] = isset($tab['priority']) ? (int)$tab['priority'] : (++$priority);
            
            if (isset($tabs['priority'])) {
                unset($tabs['priority']);
            }
            
            if (isset($tabs['items'])) {
                unset($tabs['items']);
            }
        }
        
        if (empty($tabs) || !is_array($tabs)) {
            return;
        }
        
        array_multisort($sort, $tabs);
        
        return $this->widget('zii.widgets.CMenu', array(
            'htmlOptions'   => array('class' => 'nav nav-tabs'),
            'items'         => $tabs,
            'encodeLabel'   => false,
        ), true);
    }
}