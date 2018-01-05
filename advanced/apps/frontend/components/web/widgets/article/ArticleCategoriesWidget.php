<?php defined('MW_PATH') || exit('No direct script access allowed');

/**
 * ArticleCategoriesWidget
 * 
 * @package MailWizz EMA
 * @author Serban George Cristian <cristian.serban@mailwizz.com> 
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.0
 */
 
class ArticleCategoriesWidget extends CWidget
{
    public $article;
    
    public $except = array();
    
    public function run()
    {
        if (empty($this->article->activeCategories)) {
            return;
        }
        
        $categories = array();
        foreach ($this->article->categories as $category) {
            if (in_array($category->category_id, (array)$this->except)) {
                continue;
            }
            $url = Yii::app()->createUrl('articles/category', array('slug' => $category->slug));
            $categories[] = CHtml::link($category->name, $url, array('title' => $category->name));
        }
        
        if (empty($categories)) {
            return;
        }
        
        $this->render('categories', compact('categories'));
    }
}