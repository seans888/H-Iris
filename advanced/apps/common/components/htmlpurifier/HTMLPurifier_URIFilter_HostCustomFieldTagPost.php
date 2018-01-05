<?php defined('MW_PATH') || exit('No direct script access allowed');



class HTMLPurifier_URIFilter_HostCustomFieldTagPost extends HTMLPurifier_URIFilter
{
    public $name = 'HostCustomFieldTagPost';

    public $post = true;

    public function filter(&$uri, $config, $context)
    {
        return true;
    }
}