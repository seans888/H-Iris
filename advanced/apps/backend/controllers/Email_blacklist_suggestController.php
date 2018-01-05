<?php defined('MW_PATH') || exit('No direct script access allowed');



class Email_blacklist_suggestController extends Controller
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->getData('pageScripts')->add(array('src' => AssetsUrl::js('email-blacklist-suggest.js')));
        parent::init();
    }
    
    /**
     * Define the filters for various controller actions
     * Merge the filters with the ones from parent implementation
     */
    public function filters()
    {
        $filters = array(
            'postOnly + approve, delete',
        );

        return CMap::mergeArray($filters, parent::filters());
    }

    /**
     * List all email blacklist suggestions.
     */
    public function actionIndex()
    {
        $request = Yii::app()->request;
        $model = new EmailBlacklistSuggest('search');
        $model->unsetAttributes();

        // for filters.
        $model->attributes = (array)$request->getQuery($model->modelName, array());

        $this->setData(array(
            'pageMetaTitle'   => $this->data->pageMetaTitle . ' | '. Yii::t('email_blacklist', 'Email blacklist suggestions'),
            'pageHeading'     => Yii::t('email_blacklist', 'Email blacklist suggestions'),
            'pageBreadcrumbs' => array(
                Yii::t('email_blacklist', 'Email blacklist suggestions') => $this->createUrl('email_blacklist_suggest/index'),
                Yii::t('app', 'View all')
            )
        ));

        $this->render('list', compact('model'));
    }

    /**
     * Approve a email blacklist suggestion.
     */
    public function actionApprove($id)
    {
        $model = EmailBlacklistSuggest::model()->findByPk((int)$id);

        if (empty($model)) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
        
        $blacklist = EmailBlacklist::model()->findByAttributes(array('email' => $model->email));
        if (empty($blacklist)) {
            EmailBlacklist::addToBlacklist($model->email, 'Email Blacklist Suggestion!');
        }

        $model->delete();
        
        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;

        $redirect = null;
        if (!$request->getQuery('ajax')) {
            $notify->addSuccess(Yii::t('email_blacklist', 'The item has been successfully approved and moved into the global blacklist!'));
            $redirect = $request->getPost('returnUrl', array('email_blacklist_suggest/index'));
        }

        // since 1.3.5.9
        Yii::app()->hooks->doAction('controller_action_delete_data', $collection = new CAttributeCollection(array(
            'controller' => $this,
            'model'      => $model,
            'redirect'   => $redirect,
        )));
        
        if ($collection->redirect) {
            $this->redirect($collection->redirect);
        }
    }

    /**
     * Delete a email blacklist suggestion.
     */
    public function actionDelete($id)
    {
        $model = EmailBlacklistSuggest::model()->findByPk((int)$id);

        if (empty($model)) {
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        $model->delete();

        $request = Yii::app()->request;
        $notify  = Yii::app()->notify;

        $redirect = null;
        if (!$request->getQuery('ajax')) {
            $notify->addSuccess(Yii::t('app', 'The item has been successfully deleted!'));
            $redirect = $request->getPost('returnUrl', array('email_blacklist_suggest/index'));
        }

        // since 1.3.5.9
        Yii::app()->hooks->doAction('controller_action_delete_data', $collection = new CAttributeCollection(array(
            'controller' => $this,
            'model'      => $model,
            'redirect'   => $redirect,
        )));

        if ($collection->redirect) {
            $this->redirect($collection->redirect);
        }
    }
}
