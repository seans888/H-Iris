<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * UserIdentity
 *
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com>
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.0
 */

class UserIdentity extends BaseUserIdentity
{

    public function authenticate()
    {
        $user = User::model()->findByAttributes(array(
            'email'     => $this->email,
            'status'    => User::STATUS_ACTIVE,
        ));

        if (empty($user) || !Yii::app()->passwordHasher->check($this->password, $user->password)) {
            $this->errorCode = Yii::t('users', 'Invalid login credentials.');
            return !$this->errorCode;
        }

        $this->setId($user->user_id);
        $this->setAutoLoginToken($user);

        $this->errorCode = self::ERROR_NONE;
        return !$this->errorCode;
    }

    public function setAutoLoginToken(User $user)
    {
        $token = sha1(uniqid(rand(0, time()), true));
        $this->setState('__user_auto_login_token', $token);

        UserAutoLoginToken::model()->deleteAllByAttributes(array(
            'user_id' => (int)$user->user_id,
        ));

        $autologinToken             = new UserAutoLoginToken();
        $autologinToken->user_id    = (int)$user->user_id;
        $autologinToken->token      = $token;
        $autologinToken->save();

        return $this;
    }

}
