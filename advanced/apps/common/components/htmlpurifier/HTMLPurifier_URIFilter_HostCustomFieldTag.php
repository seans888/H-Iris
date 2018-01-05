<?php defined('MW_PATH') || exit('No direct script access allowed');


class HTMLPurifier_URIFilter_HostCustomFieldTag extends HTMLPurifier_URIFilter
{
    public $name = 'HostCustomFieldTag';
    
    public function filter(&$uri, $config, $context) 
    {
        return true;
    }
}