<?php namespace Application\Missions\Web\Api;

use Application\Entity\User;
use Atomino\Bundle\Authenticate\SessionAuthenticator;
use Atomino\Carbon\ValidationError;
use Atomino\Mercury\RateLimiterInterface;
use Atomino\Mercury\Responder\Api\Api;
use Atomino\Mercury\Responder\Api\Attributes\Auth;
use Atomino\Mercury\Responder\Api\Attributes\Route;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\RateLimiter\LimiterInterface;
use Symfony\Component\RateLimiter\RateLimit;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\RateLimiter\Storage\CacheStorage;
use Symfony\Component\RateLimiter\Storage\InMemoryStorage;
use function Atomino\debug;


class Authenticate extends Api {

	public function __construct(protected SessionAuthenticator $sessionAuthenticator, private RateLimiterInterface $rateLimiter) { }

	#[Route(self::GET, '/')]
	public function get() {
		return User::getAuthenticated() ?? false;
	}

	#[Route(self::POST, '/forgot-password')]
	public function forgotPassword() {
		$email = $this->data->get("email");
		$limiter = $this->rateLimiter->get('forgot-password', 5, 60)->create($email);
		if (false === $limiter->consume(1)->isAccepted()) {
			$this->setStatusCode(self::TOO_MANY_REQUESTS);
			return false;
		}
		return User::forgotPassword($email);
	}

	#[Route(self::POST, '/sign-in')]
	#[Auth(false)]
	public function login() {
		$limiter = $this->rateLimiter->get('wrong-login', 5, 60)->create($this->request->getClientIp());
		if (false === $limiter->consume(1)->isAccepted()) {
			$this->setStatusCode(self::TOO_MANY_REQUESTS);
			return false;
		}
		$login = $this->data->get('email', '');
		$password = $this->data->get('password', '');
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

	#[Route(self::POST, '/sign-up')]
	#[Auth(false)]
	public function signup() {
		try {
			$user = User::register(
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


