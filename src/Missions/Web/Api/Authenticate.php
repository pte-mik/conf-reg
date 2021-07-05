<?php namespace Application\Missions\Web\Api;

use Application\Entity\User;
use Atomino\Bundle\Authenticate\SessionAuthenticator;
use Atomino\Mercury\Responder\Api\Api;
use Atomino\Mercury\Responder\Api\Attributes\Auth;
use Atomino\Mercury\Responder\Api\Attributes\Route;
use Symfony\Component\HttpFoundation\Response;
use function Atomino\debug;

class Authenticate extends Api {

	public function __construct(protected SessionAuthenticator $sessionAuthenticator) { }

	#[Route(self::GET, '/')]
	public function get() {
		return User::getAuthenticated() ?? false;
	}

	#[Route(self::POST, '/sign-in')]
	#[Auth(false)]
	public function login() {
		$login = $this->data->get('email', '');
		$password = $this->data->get('password','');
		if (!$this->sessionAuthenticator->login($login, $password)) {
			$this->setStatusCode(Response::HTTP_UNAUTHORIZED);
			return false;
		}
		return true;
	}

	#[Route(self::GET, '/sign-out')]
	#[Auth]
	public function logout() {
		$this->sessionAuthenticator->logout($this->getResponse());
	}

}
