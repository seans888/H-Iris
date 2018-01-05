<?php defined('MW_PATH') || exit('No direct script access allowed');


 
class IpLocationServicesList extends FormModel
{

    public function getDataProvider()
    {
        $hooks = Yii::app()->hooks;
        $registeredServices = (array)$hooks->applyFilters('backend_ip_location_services_display_list', array());
        if (empty($registeredServices)) {
            return new CArrayDataProvider(array());
        }
        
        $validRegisteredServices = $sortOrder = array();
        foreach ($registeredServices as $service) {
            if (!isset($service['id'], $service['name'], $service['description'], $service['status'], $service['sort_order'])) {
                continue;
            }  
            $sortOrder[] = (int)$service['sort_order'];
            $validRegisteredServices[] = $service;
        }
        
        if (empty($validRegisteredServices)) {
            return new CArrayDataProvider(array());
        }
        
        array_multisort($sortOrder, SORT_NUMERIC, $validRegisteredServices);
        
        foreach ($validRegisteredServices as $index => $service) {
            $service['name'] = CHtml::encode($service['name']);
            if (!empty($service['page_url'])) {
                $service['name'] = CHtml::link($service['name'], $service['page_url']);
            }
            $validRegisteredServices[$index] = array(
                'id'            => $service['id'],
                'name'          => $service['name'],
                'description'   => $service['description'],
                'status'        => ucfirst(Yii::t('app', $service['status'])),
                'sort_order'    => (int)$service['sort_order'],
                'page_url'      => isset($service['page_url']) ? $service['page_url'] : null,
            );
        }
        
        return new CArrayDataProvider($validRegisteredServices);
    }
}