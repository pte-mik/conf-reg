<?php namespace Application\Missions\Web\Api;

use Application\Entity\User;
use Application\Services\UserService;
use Atomino\Bundle\Authenticate\SessionAuthenticator;
use Atomino\Carbon\ValidationError;
use Atomino\Mercury\RateLimiterInterface;
use Atomino\Mercury\Responder\Api\Api;
use Atomino\Mercury\Responder\Api\Attributes\Auth;
use Atomino\Mercury\Responder\Api\Attributes\Route;
use Symfony\Component\HttpFoundation\Response;


class Authenticate extends Api {

	public function __construct(protected SessionAuthenticator $sessionAuthenticator, private RateLimiterInterface $rateLimiter, private UserService $userService) { }

	#[Route(self::GET, '/')]
	public function get(): User|false {
		return $this->userService->getAuthenticated();
	}

	#[Route(self::POST, '/forgot-password')]
	public function forgotPassword(): bool {
		$email = $this->data->get("email");
		$limiter = $this->rateLimiter->get('forgot-password', 5, 60)->create($email);
		if (false === $limiter->consume(1)->isAccepted()) {
			$this->setStatusCode(self::TOO_MANY_REQUESTS);
			return false;
		}
		return $this->userService->forgotPassword($email);
	}

	#[Route(self::POST, '/sign-in')]
	#[Auth(false)]
	public function login(): bool {
		$limiter = $this->rateLimiter->get('wrong-login', 5, 60)->create($this->request->getClientIp());
		if (false === $limiter->consume(0)->isAccepted()) {
			$this->setStatusCode(self::TOO_MANY_REQUESTS);
			return false;
		}
		$login = $this->data->get('email', '');
		$password = $this->data->get('password', '');
		if (!$this->sessionAuthenticator->login($login, $password)) {
			$limiter->consume(1);
			$this->setStatusCode(Response::HTTP_UNAUTHORIZED);
			return false;
		}
		return true;
	}

	#[Route(self::GET, '/sign-out')]
	#[Auth]
	public function logout(): void {
		$this->sessionAuthenticator->logout($this->getResponse());
	}

	#[Route(self::POST, '/sign-up')]
	#[Auth(false)]
	public function signup(): array|int|null {
		try {
			$user = $this->userService->register(
				$this->data->get("name"),
				$this->data->get("password"),
				$this->data->get("email"),
				$this->data->get("phone")
			);
		} catch (ValidationError $e) {
			$this->setStatusCode(self::VALIDATION_ERROR);
			return $e->getMessages();
		}
		return $user->id;
	}
}


