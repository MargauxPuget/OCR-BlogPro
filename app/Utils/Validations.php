<?php

namespace MPuget\blog\Utils;

class Validations {

	static function validateDataMail(Array $data) : bool
	{
		var_dump('Validations::validateDataMail()');
		if (
		!isset($data['name'])
		|| !isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)
		|| !isset($data['message'])
		) {
			return false;
		} else {	
			return true;
		}
  	}
}
