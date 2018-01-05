/**
 * This file is part of the MailWizz EMA application.
 * 
 * @package MailWizz EMA
 * @subpackage Payment Gateway Paypal
 * @author Serban George Cristian <cristian.serban@mailwizz.com> 
 * @link http://www.mailwizz.com/
 * @copyright 2013-2017 MailWizz EMA (http://www.mailwizz.com)
 * @license http://www.mailwizz.com/license/
 * @since 1.0
 */
jQuery(document).ready(function($){
	
	var ajaxData = {};
	if ($('meta[name=csrf-token-name]').length && $('meta[name=csrf-token-value]').length) {
			var csrfTokenName = $('meta[name=csrf-token-name]').attr('content');
			var csrfTokenValue = $('meta[name=csrf-token-value]').attr('content');
			ajaxData[csrfTokenName] = csrfTokenValue;
	}
    
    $('#paypal-hidden-form').on('submit', function(){
        var $this = $(this);
        if ($this.data('submit')) {
            return true;
        }
        if ($this.data('ajaxRunning')) {
            return false;
        }
        $this.data('ajaxRunning', true);
        $.post($this.data('order'), $this.serialize(), function(json){
            $this.data('ajaxRunning', false);
            if (json.status == 'error') {
                notify.remove().addError(json.message).show();
            } else {
                $this.data('submit', true).submit();
            }
        }, 'json');
        return false;
    });
});