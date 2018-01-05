<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class GuestController extends Controller
{
    public $layout = 'guest';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->getData('bodyClasses')->add('hold-transition login-page');
    }
    
    /**
     * Display the login form so that a guest can login and become an administrator
     */
    public function actionIndex()
    {
        $model   = new UserLogin();
        $request = Yii::app()->request;
        $options = Yii::app()->options;
        
        if (version_compare($options->get('system.common.version'), '1.3.5', '>=') && GuestFailAttempt::model()->setBaseInfo()->hasTooManyFailures) {
            throw new CHttpException(403, Yii::t('app', 'Your access to this resource is forbidden.'));
        }
        
        if ($request->isPostRequest && ($attributes = (array)$request->getPost($model->modelName, array()))) {
            $model->attributes = $attributes;

            Yii::app()->hooks->doAction('controller_action_save_data', $collection = new CAttributeCollection(array(
                'controller'=> $this,
                'success'   => $model->validate(),
                'model'     => $model,
            )));

            if ($collection->success) {
                $this->redirect(Yii::app()->user->returnUrl);
            }
            
            if (version_compare($options->get('system.common.version'), '1.3.5', '>=')) {
                GuestFailAttempt::registerByPlace('Backend login');
            }
        }
        
        $this->setData(array(
            'pageMetaTitle' => $this->data->pageMetaTitle . ' | '. Yii::t('users', 'Please login'), 
            'pageHeading'   => Yii::t('users', 'Please login'),
        ));
        
        $this->render('login', compact('model'));
    }
    
    /**
     * Display the form to retrieve a forgotten password.
     */
    public function actionForgot_password()
    {
        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;
        $options = Yii::app()->options;
        $model = new UserPasswordReset();
        
        if (version_compare($options->get('system.common.version'), '1.3.5', '>=') && GuestFailAttempt::model()->setBaseInfo()->hasTooManyFailures) {
            throw new CHttpException(403, Yii::t('app', 'Your access to this resource is forbidden.'));
        }
        
        if ($request->isPostRequest && ($attributes = (array)$request->getPost($model->modelName, array()))) {
            $model->attributes = $attributes;

            Yii::app()->hooks->doAction('controller_action_save_data', $collection = new CAttributeCollection(array(
                'controller'=> $this,
                'success'   => $model->validate(),
                'model'     => $model,
            )));

            if (!$collection->success) {
            
                $notify->addError(Yii::t('app', 'Please fix your form errors!'));
                if (version_compare($options->get('system.common.version'), '1.3.5', '>=')) {
                    GuestFailAttempt::registerByPlace('Backend forgot password');
                }
            
            } else {
                
                $user = User::model()->findByAttributes(array('email' => $model->email));
                $model->user_id = $user->user_id;
                $model->save(false);
                
                $emailTemplate    = $options->get('system.email_templates.common');
                $emailBody        = $this->renderPartial('_email-reset-key', compact('model', 'user'), true);
                $emailTemplate    = str_replace('[CONTENT]', $emailBody, $emailTemplate);
                
                $email = new TransactionalEmail();
                $email->sendDirectly = (bool)($options->get('system.customer_registration.send_email_method', 'transactional') == 'direct');
                $email->to_name      = $user->getFullName();
                $email->to_email     = $user->email;
                $email->from_name    = $options->get('system.common.site_name', 'Marketing website');
                $email->subject      = Yii::t('users', 'Password reset request!');
                $email->body         = $emailTemplate;
                $email->save();

                $notify->addSuccess(Yii::t('app', 'Please check your email address.'));
                $model->unsetAttributes();
                $model->email = null;
                
            }
        }
        
        $this->setData(array(
            'pageMetaTitle' => $this->data->pageMetaTitle . ' | '. Yii::t('users', 'Retrieve a new password for your account.'), 
        ));

        $this->render('forgot_password', compact('model'));
    }
    
    /**
     * Reached from email, will reset the password for given user and send a new one via email.
     */
    public function actionReset_password($reset_key)
    {
        $model = UserPasswordReset::model()->findByAttributes(array(
            'reset_key' => $reset_key,
            'status'    => UserPasswordReset::STATUS_ACTIVE,
        ));
        
        if (empty($model)) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
        
        $randPassword   = StringHelper::random();
        $hashedPassword = Yii::app()->passwordHasher->hash($randPassword);
        
        User::model()->updateByPk((int)$model->user_id, array('password' => $hashedPassword));
        $model->status = UserPasswordReset::STATUS_USED;
        $model->save();
        
        $options = Yii::app()->options;
        $notify  = Yii::app()->notify;
        $user    = User::model()->findByPk($model->user_id);
        
        // since 1.3.9.3
        Yii::app()->hooks->doAction('backend_controller_guest_reset_password', $collection = new CAttributeCollection(array(
            'user'          => $user,
            'passwordReset' => $model,
            'randPassword'  => $randPassword,
            'hashedPassword'=> $hashedPassword,
            'sendEmail'     => true,
            'redirect'      => array('guest/index'),
        )));
        
        if (!empty($collection->sendEmail)) {
            $emailTemplate  = $options->get('system.email_templates.common');
            $emailBody      = $this->renderPartial('_email-new-login', compact('model', 'user', 'randPassword'), true);
            $emailTemplate  = str_replace('[CONTENT]', $emailBody, $emailTemplate);

            $email               = new TransactionalEmail();
            $email->sendDirectly = (bool)($options->get('system.customer_registration.send_email_method', 'transactional') == 'direct');
            $email->to_name      = $user->getFullName();
            $email->to_email     = $user->email;
            $email->from_name    = $options->get('system.common.site_name', 'Marketing website');
            $email->subject      = Yii::t('app', 'Your new login info!');
            $email->body         = $emailTemplate;
            $email->save();
        }
        
        if (!empty($collection->redirect)) {
            $notify->addSuccess(Yii::t('app', 'Your new login has been successfully sent to your email address.'));
            $this->redirect($collection->redirect);
        }
    }
    
    /**
     * The error handler
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo CHtml::encode($error['message']);
            } else {
                $this->setData(array(
                    'pageMetaTitle' => Yii::t('app', 'Error {code}!', array('{code}' => (int)$error['code'])), 
                ));
                $this->render('error', $error) ;
            }    
        }
    }
}