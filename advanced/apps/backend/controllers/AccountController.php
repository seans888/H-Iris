<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class AccountController extends Controller
{
    /**
     * Default action, allowing to update the account
     */
    public function actionIndex()
    {
        $request    = Yii::app()->request;
        $notify     = Yii::app()->notify;
        $user       = Yii::app()->user->getModel();
        $user->confirm_email = $user->email;
        
        if ($request->isPostRequest && ($attributes = (array)$request->getPost($user->modelName, array()))) {
            $user->attributes = $attributes;
            if (!$user->save()) {
                $notify->addError(Yii::t('app', 'Your form has a few errors, please fix them and try again!'));
            } else {
                $notify->addSuccess(Yii::t('app', 'Your form has been successfully saved!'));
            }
            
            Yii::app()->hooks->doAction('controller_action_save_data', $collection = new CAttributeCollection(array(
                'controller'=> $this,
                'success'   => $notify->hasSuccess,
                'user'      => $user,
            )));
            
            if ($collection->success) {
                $this->redirect(array('account/index'));
            }
        }
        
        $this->setData(array(
            'pageMetaTitle'     => $this->data->pageMetaTitle . ' | '. Yii::t('users', 'Update account'),
            'pageHeading'       => Yii::t('users', 'Update account'),
            'pageBreadcrumbs'   => array(
                Yii::t('users', 'Users') => $this->createUrl('users/index'),
                Yii::t('users', 'Update account'),
            )
        ));

        $this->render('index', compact('user'));
    }
    
    /**
     * Log the user out from the application
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->user->loginUrl);    
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

        $optionKey = sprintf('%s:%s:%s', (string)$model, (string)$controller, (string)$action);
        $userId    = (int)Yii::app()->user->getId();
        $optionKey = sprintf('system.views.grid_view_columns.users.%d.%s', $userId, $optionKey);
        Yii::app()->options->set($optionKey, (array)$columns);

        $notify->addSuccess(Yii::t('app', 'Your form has been successfully saved!'));
        $this->redirect($redirect);
    }
}