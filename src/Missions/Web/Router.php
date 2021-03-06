<?php namespace Application\Missions\Web;

use Application\Services\ActualEventService;
use Atomino\Bundle\Authenticate\SessionAuthenticator;
use Atomino\Mercury\Responder\Smart\Cache\Middleware\Cache;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router extends \Atomino\Mercury\Router\Router {

	public function __construct(protected SessionAuthenticator $authenticator, private ActualEventService $actualEventService) { }

	public function route():void{
		$this(method: 'GET', path: '/')?->pipe(Cache::class)->pipe(Page\Index::class);
		$this(path: '/api/auth/**')?->pipe(Api\Authenticate::class);
		$this(path: '/api/submission/**')?->pipe(Api\SubmissionApi::class);
		$this()?->pipe(Page\Error404::class);
	}
	public function handle(Request $request): Response|null {
		$this->actualEventService->set($request->attributes->get('domain'));
		if ($this->actualEventService->get() === null) return new Response('', 404);
		return parent::handle($request); // TODO: Change the autogenerated stub
	}

}
