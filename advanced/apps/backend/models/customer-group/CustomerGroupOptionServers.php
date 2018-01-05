<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * CustomerGroupOptionServers
 * 
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com> 
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.3.4.3
 */
 
class CustomerGroupOptionServers extends OptionCustomerServers
{
    public function behaviors()
    {
        $behaviors = array(
            'handler' => array(
                'class'         => 'backend.components.behaviors.CustomerGroupModelHandlerBehavior',
                'categoryName'  => $this->_categoryName,
            ),
        );
        return CMap::mergeArray($behaviors, parent::behaviors());
    }

    public function save()
    {
        return $this->asa('handler')->save();
    }
}
