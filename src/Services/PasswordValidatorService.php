<?php namespace Application\Services;


class PasswordValidatorService {

	public function validate($password): bool {
		$regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8})/";
		return preg_match($regex, $password);
	}

}