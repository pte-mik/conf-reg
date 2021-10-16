<?php namespace Application\Missions\Web\Page;

use Application\Services\ActualEventService;
use Atomino\Mercury\Responder\Smart\SmartResponder;
use Atomino\Mercury\Responder\Smart\Attributes\{Cache, Args, CSS, JS, Init};
use Symfony\Component\HttpFoundation\Response;

#[Init( 'web', 'index.twig')]
#[Args( title: 'Abstract Submission' )]
#[JS('/~web/index.js')]
#[CSS('/~web/index.css')]
#[CSS('https://cdn.jsdelivr.net/npm/svelte-material-ui@4.0.0/bare.min.css')]
#[Cache( 0 )]
class Index extends SmartResponder{
	public array $users;
	public function __construct(private ActualEventService $actualEventService) { }

	protected function prepare(Response $response){
		$this->smart['data']->set('event', $this->actualEventService->get());
	}
}
