<?php defined('MW_PATH') || exit('No direct script access allowed');



class DeliveryServerMailgunWebApi extends DeliveryServer
{
    /**
     * @var string
     */
    protected $serverType = 'mailgun-web-api';

    /**
     * @var string 
     */
    protected $_initStatus;

    /**
     * @var string 
     */
    protected $_preCheckError;

    /**
     * @var array
     */
    public $webhooks = array();

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        $rules = array(
            array('password', 'required'),
            array('password', 'length', 'max' => 255),
        );
        return CMap::mergeArray($rules, parent::rules());
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        $labels = array(
            'hostname' => Yii::t('servers', 'Domain name'),
            'password' => Yii::t('servers', 'Api key'),
        );
        return CMap::mergeArray(parent::attributeLabels(), $labels);
    }

    public function attributeHelpTexts()
    {
        $texts = array(
            'hostname'  => Yii::t('servers', 'Mailgun verified domain name.'),
            'password'  => Yii::t('servers', 'Mailgun api key.'),
        );

        return CMap::mergeArray(parent::attributeHelpTexts(), $texts);
    }

    public function attributePlaceholders()
    {
        $placeholders = array(
            'hostname'  => Yii::t('servers', 'Domain name'),
            'password'  => Yii::t('servers', 'Api key'),
        );

        return CMap::mergeArray(parent::attributePlaceholders(), $placeholders);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DeliveryServer the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param array $params
     * @return array|bool
     */
    public function sendEmail(array $params = array())
    {
        $params = (array)Yii::app()->hooks->applyFilters('delivery_server_before_send_email', $this->getParamsArray($params), $this);

        if (!isset($params['from'], $params['to'], $params['subject'], $params['body'])) {
            return false;
        }

        list($toEmail, $toName)     = $this->getMailer()->findEmailAndName($params['to']);
        list($fromEmail, $fromName) = $this->getMailer()->findEmailAndName($params['from']);

        if (!empty($params['fromName'])) {
            $fromName = $params['fromName'];
        }

        $replyToEmail = null;
        if (!empty($params['replyTo'])) {
            list($replyToEmail) = $this->getMailer()->findEmailAndName($params['replyTo']);
        }

        $headerPrefix = Yii::app()->params['email.custom.header.prefix'];
        $metaData     = array();

        $headers = array();
        if (!empty($params['headers'])) {
            $headers = $this->parseHeadersIntoKeyValue($params['headers']);
        }
        
        if (isset($headers[$headerPrefix . 'Campaign-Uid'])) {
            $metaData['campaign_uid'] = $headers[$headerPrefix . 'Campaign-Uid'];
        }
        if (isset($headers[$headerPrefix . 'Subscriber-Uid'])) {
            $metaData['subscriber_uid'] = $headers[$headerPrefix . 'Subscriber-Uid'];
        }

        $sent = false;

        try {
            
            if (!$this->preCheckWebHook()) {
                throw new Exception($this->_preCheckError);
            }
            
            $message = array(
                'from'       => sprintf('=?%s?B?%s?= <%s>', strtolower(Yii::app()->charset), base64_encode($fromName), $fromEmail),
                'to'         => sprintf('=?%s?B?%s?= <%s>', strtolower(Yii::app()->charset), base64_encode($toName), $toEmail),
                'o:tracking' => false,
                'o:tag'      => array('bulk-mail'),
                'v:metadata' => CJSON::encode($metaData),
            );
            
            if (!empty($replyToEmail)) {
                $message['h:Reply-To'] = $replyToEmail;
            }

            $result = $this->getClient()->sendMessage($this->hostname, $message, $this->getMailer()->getEmailMessage($params));
            if (!empty($result->http_response_body) && !empty($result->http_response_body->id)) {
                $this->getMailer()->addLog('OK');
                $sent = array('message_id' => str_replace(array('<', '>'), '', $result->http_response_body->id));
            } else {
                throw new Exception(Yii::t('servers', 'Unable to make the delivery!'));
            }
        
        } catch (Exception $e) {
            $this->getMailer()->addLog($e->getMessage());
        }

        if ($sent) {
            $this->logUsage();
        }

        Yii::app()->hooks->doAction('delivery_server_after_send_email', $params, $this, $sent);

        return $sent;
    }

    /**
     * @param array $params
     * @return array
     */
    public function getParamsArray(array $params = array())
    {
        $params['transport'] = self::TRANSPORT_MAILGUN_WEB_API;
        return parent::getParamsArray($params);
    }

    /**
     * @return bool|string
     */
    public function requirementsFailed()
    {
        if (!version_compare(PHP_VERSION, '5.5', '>=')) {
            return Yii::t('servers', 'The server type {type} requires your php version to be at least {version}!', array(
                '{type}'    => $this->serverType,
                '{version}' => '5.5',
            ));
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        static $clients = array();
        $id = (int)$this->server_id;
        if (!empty($clients[$id])) {
            return $clients[$id];
        }
        $className = '\Mailgun\Mailgun';
        return $clients[$id] = new $className($this->password);
    }

    /**
     * @inheritdoc
     */
    protected function afterConstruct()
    {
        parent::afterConstruct();
        $this->_initStatus = $this->status;
        $this->webhooks    = (array)$this->getModelMetaData()->itemAt('webhooks');
    }

    /**
     * @inheritdoc
     */
    protected function afterFind()
    {
        $this->_initStatus = $this->status;
        $this->webhooks    = (array)$this->getModelMetaData()->itemAt('webhooks');
        parent::afterFind();
    }

    /**
     * @inheritdoc
     */
    protected function beforeSave()
    {
        $this->getModelMetaData()->add('webhooks', (array)$this->webhooks);
        return parent::beforeSave();
    }

    /**
     * @inheritdoc
     */
    protected function afterDelete()
    {
        if (!empty($this->webhooks)) {
            foreach ($this->webhooks as $name => $url) {
                try {
                    $this->getClient()->delete(sprintf('domains/%s/webhooks/%s', $this->hostname, $name));
                } catch (Exception $e) {

                }
            }
        }
        parent::afterDelete();
    }

    /**
     * @return bool
     */
    protected function preCheckWebHook()
    {
        if (MW_IS_CLI || $this->isNewRecord || $this->_initStatus !== self::STATUS_INACTIVE) {
            return true;
        }
        
        if (!is_array($this->webhooks)) {
            $this->webhooks = array();
        }

        foreach (array('bounce', 'drop', 'spam') as $webhook) {
            try {
                $this->getClient()->delete(sprintf('domains/%s/webhooks/%s', $this->hostname, $webhook));
            } catch (Exception $e) {

            }

            try {
                $result = $this->getClient()->post(sprintf('domains/%s/webhooks', $this->hostname), array(
                    'id'  => $webhook,
                    'url' => $this->getDswhUrl()
                ));
            } catch (Exception $e) {
                $this->_preCheckError = $e->getMessage();
            }
            
            if ($this->_preCheckError) {
                break;
            }
            
            if (!empty($result) && !empty($result->http_response_body) && !empty($result->http_response_body->webhook)) {
                $this->webhooks[$webhook] = $result->http_response_body->webhook->url;
                $this->_preCheckError = null;
            } else {
                $this->_preCheckError = Yii::t('servers', 'Cannot create the {name} webhook!', array('{name}' => $webhook));
            }

            if ($this->_preCheckError) {
                break;
            }
        }

        if ($this->_preCheckError) {
            return false;
        }

        return $this->save(false);
    }

    /**
     * @return bool
     */
    public function getCanEmbedImages()
    {
        return true;
    }

    /**
     * @param array $params
     * @return array
     */
    public function getFormFieldsDefinition(array $params = array())
    {
        return parent::getFormFieldsDefinition(CMap::mergeArray(array(
            'username'                => null,
            'port'                    => null,
            'protocol'                => null,
            'timeout'                 => null,
            'signing_enabled'         => null,
            'max_connection_messages' => null,
            'bounce_server_id'        => null,
            'force_sender'            => null,
        ), $params));
    }
}
