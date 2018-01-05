<?php defined('MW_PATH') || exit('No direct script access allowed');



class CustomersController extends Controller
{
    public function init()
    {
        $this->getData('pageScripts')->add(array('src' => AssetsUrl::js('customers.js')));
        parent::init();
    }

    /**
     * Define the filters for various controller actions
     * Merge the filters with the ones from parent implementation
     */
    public function filters()
    {
        $filters = array(
            'postOnly + delete, reset_sending_quota',
        );

        return CMap::mergeArray($filters, parent::filters());
    }

    /**
     * List all available customers
     */
    public function actionIndex()
    {
        $request    = Yii::app()->request;
        $customer   = new Customer('search');
        $customer->unsetAttributes();

        $customer->attributes = (array)$request->getQuery($customer->modelName, array());

        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | '. Yii::t('customers', 'View customers'),
            'pageHeading'       => Yii::t('customers', 'View customers'),
            'pageBreadcrumbs'   => array(
                Yii::t('customers', 'Customers') => $this->createUrl('customers/index'),
                Yii::t('app', 'View all')
            )
        ));

        $this->render('list', compact('customer'));
    }

    /**
     * Create a new customer
     */
    public function actionCreate()
    {
        $customer   = new Customer();
        $request    = Yii::app()->request;
        $notify     = Yii::app()->notify;

        if ($request->isPostRequest && ($attributes = (array)$request->getPost($customer->modelName, array()))) {
            $customer->attributes = $attributes;
            if (!$customer->save()) {
                $notify->addError(Yii::t('app', 'Your form has a few errors, please fix them and try again!'));
            } else {
                $notify->addSuccess(Yii::t('app', 'Your form has been successfully saved!'));
            }

            Yii::app()->hooks->doAction('controller_action_save_data', $collection = new CAttributeCollection(array(
                'controller'=> $this,
                'success'   => $notify->hasSuccess,
                'customer'  => $customer,
            )));

            if ($collection->success) {
                $this->redirect(array('customers/index'));
            }
        }

        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | '. Yii::t('customers', 'Create new user'),
            'pageHeading'       => Yii::t('customers', 'Create new customer'),
            'pageBreadcrumbs'   => array(
                Yii::t('customers', 'Customers') => $this->createUrl('customers/index'),
                Yii::t('app', 'Create new'),
            )
        ));

        $this->render('form', compact('customer'));
    }

    /**
     * Update existing customer
     */
    public function actionUpdate($id)
    {
        $customer = Customer::model()->findByPk((int)$id);

        if (empty($customer)) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        $customer->confirm_email = $customer->email;
        $request    = Yii::app()->request;
        $notify     = Yii::app()->notify;

        $this->setData('initCustomerStatus', $customer->status);
        $customer->onAfterSave = array($this, '_sendEmailNotification');

        if ($request->isPostRequest && ($attributes = (array)$request->getPost($customer->modelName, array()))) {
            $customer->attributes = $attributes;
            if (!$customer->save()) {
                $notify->addError(Yii::t('app', 'Your form has a few errors, please fix them and try again!'));
            } else {
                $notify->addSuccess(Yii::t('app', 'Your form has been successfully saved!'));
            }

            Yii::app()->hooks->doAction('controller_action_save_data', $collection = new CAttributeCollection(array(
                'controller'=> $this,
                'success'   => $notify->hasSuccess,
                'customer'  => $customer,
            )));

            if ($collection->success) {
                $this->redirect(array('customers/index'));
            }
        }

        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | '. Yii::t('customers', 'Update customer'),
            'pageHeading'       => Yii::t('customers', 'Update customer'),
            'pageBreadcrumbs'   => array(
                Yii::t('customers', 'Customers') => $this->createUrl('customers/index'),
                Yii::t('app', 'Update'),
            )
        ));

        $this->render('form', compact('customer'));
    }

    /**
     * Delete existing customer
     */
    public function actionDelete($id)
    {
        $customer = Customer::model()->findByPk((int)$id);

        if (empty($customer)) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        if ($customer->getIsRemovable()) {
            $customer->delete();
        }

        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;

        $redirect = null;
        if (!$request->getQuery('ajax')) {
            $notify->addSuccess(Yii::t('app', 'The item has been successfully deleted!'));
            $redirect = $request->getPost('returnUrl', array('customers/index'));
        }

        // since 1.3.5.9
        Yii::app()->hooks->doAction('controller_action_delete_data', $collection = new CAttributeCollection(array(
            'controller' => $this,
            'model'      => $customer,
            'redirect'   => $redirect,
        )));

        if ($collection->redirect) {
            $this->redirect($collection->redirect);
        }
    }

    /**
     * Impersonate (login as) this customer
     */
    public function actionImpersonate($id)
    {
        $customer = Customer::model()->findByPk((int)$id);

        if (empty($customer)) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        $request = Yii::app()->request;
        $notify = Yii::app()->notify;

        Yii::import('customer.components.web.auth.*');
        $identity = new CustomerIdentity($customer->email, null);
        $identity->impersonate = true;

        if (!$identity->authenticate() || !Yii::app()->customer->login($identity)) {
            $notify->addError(Yii::t('app', 'Unable to impersonate the customer!'));
            $this->redirect(array('customers/index'));
        }

        Yii::app()->customer->setState('__customer_impersonate', true);
        $notify->clearAll()->addSuccess(Yii::t('app', 'You are using the customer account for {customerName}!', array(
            '{customerName}' => $customer->fullName ? $customer->fullName : $customer->email,
        )));

        $this->redirect(Yii::app()->apps->getAppUrl('customer', 'dashboard/index', true));
    }

    /**
     * Reset sending quota
     */
    public function actionReset_sending_quota($id)
    {
        $customer = Customer::model()->findByPk((int)$id);
        
        if (empty($customer)) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
        
        $customer->resetSendingQuota();

        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;

        $notify->addSuccess(Yii::t('customers', 'The sending quota has been successfully reseted!'));

        if (!$request->isAjaxRequest) {
            $this->redirect($request->getPost('returnUrl', array('customers/index')));
        }
    }

    /**
     * Autocompletre for search
     */
    public function actionAutocomplete($term)
    {
        $request = Yii::app()->request;
        if (!$request->isAjaxRequest) {
            $this->redirect(array('customers/index'));
        }

        $criteria = new CDbCriteria();
        $criteria->select = 'customer_id, first_name, last_name, email';
        $criteria->compare(new CDbExpression('CONCAT(first_name, " ", last_name)'), $term, true);
        $criteria->compare('email', $term, true, 'OR');
        $criteria->limit = 10;

        $models = Customer::model()->findAll($criteria);
        $results = array();

        foreach ($models as $model) {
            $results[] = array(
                'customer_id' => $model->customer_id,
                'value'       => $model->getFullName() ? $model->getFullName() : $model->email,
            );
        }

        return $this->renderJson($results);
    }

    public function _sendEmailNotification(CEvent $event)
    {
        if ($this->getData('initCustomerStatus') != Customer::STATUS_PENDING_ACTIVE) {
            return;
        }

        $customer = $event->sender;
        if ($customer->status != Customer::STATUS_ACTIVE) {
            return;
        }

        $options = Yii::app()->options;
        $notify  = Yii::app()->notify;

        $emailTemplate = $options->get('system.email_templates.common');
        $emailBody     = $this->renderPartial('_email-approve', compact('customer'), true);
        $emailTemplate = str_replace('[CONTENT]', $emailBody, $emailTemplate);

        $email = new TransactionalEmail();
        $email->sendDirectly = (bool)($options->get('system.customer_registration.send_email_method', 'transactional') == 'direct');
        $email->to_name      = $customer->getFullName();
        $email->to_email     = $customer->email;
        $email->from_name    = $options->get('system.common.site_name', 'Marketing website');
        $email->subject      = Yii::t('customers', 'Your account has been approved!');
        $email->body         = $emailTemplate;
        $email->save();

        // send welcome email if needed
        $sendWelcome        = $options->get('system.customer_registration.welcome_email', 'no') == 'yes';
        $sendWelcomeSubject = $options->get('system.customer_registration.welcome_email_subject', '');
        $sendWelcomeContent = $options->get('system.customer_registration.welcome_email_content', '');
        if (!empty($sendWelcome) && !empty($sendWelcomeSubject) && !empty($sendWelcomeContent)) {
            $searchReplace = array(
                '[FIRST_NAME]' => $customer->first_name,
                '[LAST_NAME]'  => $customer->last_name,
                '[FULL_NAME]'  => $customer->fullName,
                '[EMAIL]'      => $customer->email,
            );
            $sendWelcomeSubject = str_replace(array_keys($searchReplace), array_values($searchReplace), $sendWelcomeSubject);
            $sendWelcomeContent = str_replace(array_keys($searchReplace), array_values($searchReplace), $sendWelcomeContent);
            $emailTemplate = $options->get('system.email_templates.common');
            $emailTemplate = str_replace('[CONTENT]', $sendWelcomeContent, $emailTemplate);

            $email = new TransactionalEmail();
            $email->sendDirectly = (bool)($options->get('system.customer_registration.send_email_method', 'transactional') == 'direct');
            $email->to_name      = $customer->getFullName();
            $email->to_email     = $customer->email;
            $email->from_name    = $options->get('system.common.site_name', 'Marketing website');
            $email->subject      = $sendWelcomeSubject;
            $email->body         = $emailTemplate;
            $email->save();
        }

        $notify->addSuccess(Yii::t('customers', 'A notification email has been sent for this customer!'));
    }

}
