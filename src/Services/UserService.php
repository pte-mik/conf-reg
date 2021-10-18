<?php namespace Application\Services;

use Application\Entity\User;
use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Carbon\ValidationError;

class UserService {

	public function __construct(private PasswordValidatorService $passwordValidator) { }

	public function getAuthenticated(): User|false { return User::getAuthenticated() ?? false; }

	public function forgotPassword($email) {
		$user = User::search(Filter::where(User::email($email)))->pick();
		if (!$user) return false;
		mail($email, "Conference Ninja forgot password", "Please contact the event administrator!");
		return true;
	}

	/**
	 * @param $name
	 * @param $password
	 * @param $email
	 * @param $phone
	 * @return User
	 * @throws ValidationError
	 */
	public function register($name, $password, $email, $phone): User {
		if (false === $this->passwordValidator->validate($password)) throw new ValidationError([["field" => "password", "message" => "Password is not strong enough"]]);
		$user = User::create();
		$user->setPassword($password);
		$user->name = $name;
		$user->email = $email;
		$user->phone = $phone;
		try {
			$user->save();
		} catch (ValidationError $e) {
			throw $e;
		}
		return $user;
	}
}
