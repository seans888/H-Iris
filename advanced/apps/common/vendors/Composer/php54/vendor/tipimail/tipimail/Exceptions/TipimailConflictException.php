<?php
namespace Tipimail\Exceptions;

class TipimailConflictException extends TipimailException {
	
	public function __construct($error, $code) {
		parent::__construct($error, $code);
	}
	
}