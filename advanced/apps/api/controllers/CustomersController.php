<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * CustomersController
 *
 * Handles the CRUD actions for customers.
 *
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com>
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.3.4.7
 */

class CustomersController extends Controller
{
    // access rules for this controller
    public function accessRules()
    {
        return array(
            // allow all users on all actions for now
            array('allow'),
        );
    }

    /**
     * Handles the creation of a new customer if registration is enabled.
     */
    public function actionCreate()
    {
        $request = Yii::app()->request;

        if (!$request->isPostRequest) {
            return $this->renderJson(array(
                'status'    => 'error',
                'error'     => Yii::t('api', 'Only POST requests allowed for this endpoint.')
            ), 400);
        }

        $options = Yii::app()->options;
        if ($options->get('system.customer_registration.enabled', 'no') != 'yes') {
            return $this->renderJson(array(
                'status'    => 'error',
                'error'     => Yii::t('api', 'Customer creation is disabled.')
            ), 400);
        }

        $customer     = new Customer('register');
        $company      = new CustomerCompany('register');
        $customerPost = (array)$request->getPost('customer', array());
        $companyPost  = (array)$request->getPost('company', array());

        if (isset($customerPost['password'])) {
            $customerPost['fake_password'] = $customerPost['password'];
            unset($customerPost['password']);
        }

        $customer->attributes = $customerPost;
        $customer->tc_agree   = true;
        $customer->status     = Customer::STATUS_PENDING_CONFIRM;
        $companyRequired      = $options->get('system.customer_registration.company_required', 'no') == 'yes';
        
        $requireApproval = $options->get('system.customer_registration.require_approval', 'no') == 'yes';
        if (!$requireApproval) {
            $customer->status = Customer::STATUS_ACTIVE;
        }
        
        if (!$customer->save()) {
            return $this->renderJson(array(
                'status'    => 'error',
                'error'     => array(
                    'general' => $customer->shortErrors->getAll()
                ),
            ), 422);
        }

        if ($companyRequired) {
            $country = null;
            if (!empty($companyPost['country'])) {
                $country = Country::model()->findByAttributes(array('name' => $companyPost['country']));
                if (empty($country)) {
                    $customer->delete();
                    return $this->renderJson(array(
                        'status'    => 'error',
                        'error'     => array(
                            'company' => array(
                                'country_id' => Yii::t('api', 'Unable to find the specified country, please double check the spelling!'),
                            ),
                        ),
                    ), 422);
                }
                $companyPost['country_id'] = $country->country_id;
                unset($companyPost['country']);
            }
            if (!empty($companyPost['zone'])) {
                if (!empty($country)) {
                    $zone = Zone::model()->findByAttributes(array(
                        'country_id' => $country->country_id,
                        'name'       => $companyPost['zone']
                    ));
                    if (empty($zone)) {
                        $customer->delete();
                        return $this->renderJson(array(
                            'status'    => 'error',
                            'error'     => array(
                                'company' => array(
                                    'zone_id' => Yii::t('api', 'Unable to find the specified zone, please double check the spelling!'),
                                ),
                            ),
                        ), 422);
                    }
                    $companyPost['zone_id'] = $zone->zone_id;
                }
                unset($companyPost['zone']);
            }

            $company->attributes  = $companyPost;
            $company->customer_id = $customer->customer_id;

            if (!$company->save()) {
                $customer->delete();
                return $this->renderJson(array(
                    'status'    => 'error',
                    'error'     => array(
                        'company' => $company->shortErrors->getAll()
                    ),
                ), 422);
            }
        }

        $this->_sendRegistrationConfirmationEmail($customer, $company);
        $this->_sendNewCustomerNotifications($customer, $company);

        return $this->renderJson(array(
            'status'        => 'success',
            'customer_uid'  => $customer->customer_uid,
        ), 201);
    }

    /**
     * Callback after success registration to send the confirmation email
     */
    protected function _sendRegistrationConfirmationEmail(Customer $customer, CustomerCompany $company)
    {
        $options  = Yii::app()->options;
        $notify   = Yii::app()->notify;

        if ($options->get('system.customer_registration.company_required', 'no') == 'yes' && $company->isNewRecord) {
            return;
        }

        $emailTemplate  = $options->get('system.email_templates.common');
        $emailBody      = $this->renderPartial('customer.views.guest._email-registration-key', compact('customer'), true);
        $emailTemplate  = str_replace('[CONTENT]', $emailBody, $emailTemplate);

        $email = new TransactionalEmail();
        $email->to_name     = $customer->getFullName();
        $email->to_email    = $customer->email;
        $email->from_name   = $options->get('system.common.site_name', 'Marketing website');
        $email->subject     = Yii::t('customers', 'Please confirm your account!');
        $email->body        = $emailTemplate;
        $email->save();
    }

    /**
     * Callback after success registration to send the notification emails to admin users
     */
    protected function _sendNewCustomerNotifications(Customer $customer, CustomerCompany $company)
    {
        $options    = Yii::app()->options;
        $notify     = Yii::app()->notify;
        $recipients = $options->get('system.customer_registration.new_customer_registration_notification_to');

        if (empty($recipients)) {
            return;
        }

        $recipients = explode(',', $recipients);
        $recipients = array_map('trim', $recipients);

        $emailTemplate  = $options->get('system.email_templates.common');
        $emailBody      = $this->renderPartial('customer.views.guest._email-new-customer-notification', compact('customer', 'options'), true);
        $emailTemplate  = str_replace('[CONTENT]', $emailBody, $emailTemplate);

        foreach ($recipients as $recipient) {
            if (!FilterVarHelper::email($recipient)) {
                continue;
            }
            $email = new TransactionalEmail();
            $email->to_name     = $recipient;
            $email->to_email    = $recipient;
            $email->from_name   = $options->get('system.common.site_name', 'Marketing website');
            $email->subject     = Yii::t('customers', 'New customer registration!');
            $email->body        = $emailTemplate;
            $email->save();
        }
    }
}
