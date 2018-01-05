<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class ListCsvExport extends FormModel
{
    public $list_id;

    public $segment_id;
    
    public $count = 0;
    
    public $is_first_batch = 1;

    public $current_page = 1;
    
    private $_list;
    
    private $_segment;
    
    public function rules()
    {
        $rules = array(
            array('count, current_page, is_first_batch', 'numerical', 'integerOnly' => true),
            array('list_id, segment_id', 'unsafe'),
        );
        
        return CMap::mergeArray($rules, parent::rules());
    }

    /**
     * @return string
     */
    public function countSubscribers()
    {
        if (!empty($this->segment_id)) {
            $count = $this->countSubscribersByListSegment();
        } else {
            $count = $this->countSubscribersByList();
        }
        
        return $count;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function findSubscribers($limit = 10, $offset = 0)
    {
        if (!empty($this->segment_id)) {
            $subscribers = $this->findSubscribersByListSegment($offset, $limit);
        } else {
            $subscribers = $this->findSubscribersByList($offset, $limit);
        }
        
        if (empty($subscribers)) {
            return array();
        }
        
        $criteria = new CDbCriteria();
        $criteria->select = 'field_id, tag';
        $criteria->compare('list_id', $this->list_id);
        $criteria->order = 'sort_order ASC, tag ASC';
        $fields = ListField::model()->findAll($criteria);
        
        if (empty($fields)) {
            return array();
        }
        
        $data = array();
        foreach ($subscribers as $subscriber) {
            $_data = array();
            foreach ($fields as $field) {
                $value = null;
                
                $criteria = new CDbCriteria();
                $criteria->select = 'value';
                $criteria->compare('field_id', (int)$field->field_id);
                $criteria->compare('subscriber_id', (int)$subscriber->subscriber_id);
                $valueModels = ListFieldValue::model()->findAll($criteria);

                if (!empty($valueModels)) {
                    $value = array();
                    foreach($valueModels as $valueModel) {
                        $value[] = $valueModel->value;
                    }
                    $value = implode(', ', $value);
                }
                $_data[$field->tag] = CHtml::encode($value);
            }
            foreach (array('source', 'status', 'ip_address', 'date_added') as $key) {
                $tag = strtoupper($key);
                $_data[$tag] = $subscriber->$key;
            }
            
            // 1.3.8.8
            $optinData = array(
                'optin_ip'          => '', 
                'optin_date'        => '', 
                'optin_confirm_ip'  => '', 
                'optin_confirm_date'=> ''
            );
            foreach ($optinData as $key => $value) {
                $tag = strtoupper($key);
                $_data[$tag] = $value;
            }
            if (!empty($subscriber->optinHistory)) {
                foreach ($optinData as $key => $value) {
                    $tag = strtoupper($key);
                    if (in_array($key, array('optin_confirm_ip', 'optin_confirm_date'))) {
                        $key = str_replace('optin_', '', $key);
                    }
                    $_data[$tag] = $subscriber->optinHistory->$key;
                }
            }
            //
            
            // 1.3.9.8
            $optoutData = array(
                'optout_ip'           => '',
                'optout_date'         => '',
                'optout_confirm_ip'   => '',
                'optout_confirm_date' => ''
            );
            foreach ($optoutData as $key => $value) {
                $tag = strtoupper($key);
                $_data[$tag] = $value;
            }
            if ($subscriber->status == ListSubscriber::STATUS_UNSUBSCRIBED && !empty($subscriber->optoutHistory)) {
                foreach ($optoutData as $key => $value) {
                    $tag = strtoupper($key);
                    if (in_array($key, array('optout_confirm_ip', 'optout_confirm_date'))) {
                        $key = str_replace('optout_', '', $key);
                    }
                    $_data[$tag] = $subscriber->optoutHistory->$key;
                }
            }
            //
            
            $data[] = $_data;    
        }
        
        unset($subscribers, $fields, $_data, $subscriber, $field);
        
        return $data;
    }

    /**
     * @return string
     */
    protected function countSubscribersByListSegment()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('t.list_id', (int)$this->list_id);

        return $this->getSegment()->countSubscribers($criteria);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return array
     */
    protected function findSubscribersByListSegment($offset = 0, $limit = 100)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 't.list_id, t.subscriber_id, t.subscriber_uid, t.email, t.status, t.ip_address, t.source, t.date_added';
        $criteria->compare('t.list_id', (int)$this->list_id);
        
        return $this->getSegment()->findSubscribers($offset, $limit, $criteria);
    }

    /**
     * @return string
     */
    protected function countSubscribersByList()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('t.list_id', (int)$this->list_id);
        
        return ListSubscriber::model()->count($criteria);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return static[]
     */
    protected function findSubscribersByList($offset = 0, $limit = 100)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 't.list_id, t.subscriber_id, t.subscriber_uid, t.email, t.status, t.ip_address, t.source, t.date_added';
        $criteria->compare('t.list_id', (int)$this->list_id);
        $criteria->offset = $offset;
        $criteria->limit  = $limit;

        return ListSubscriber::model()->findAll($criteria);
    }

    /**
     * @return static
     */
    public function getList()
    {
        if ($this->_list !== null) {
            return $this->_list;
        }
        return $this->_list = Lists::model()->findByPk((int)$this->list_id);
    }

    /**
     * @return static
     */
    public function getSegment()
    {
        if ($this->_segment !== null) {
            return $this->_segment;
        }
        return $this->_segment = ListSegment::model()->findByPk((int)$this->segment_id);
    }
}