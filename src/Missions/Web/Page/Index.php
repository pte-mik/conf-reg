<?php namespace Application\Missions\Web\Page;

use Application\Modules\ActualEvent;
use Atomino\Mercury\Responder\Smart\SmartResponder;
use Atomino\Mercury\Responder\Smart\Attributes\{Cache, Args, CSS, JS, Init};
use Symfony\Component\HttpFoundation\Response;

#[Init( 'web', 'index.twig', 'mobile.twig' )]
#[Args( title: 'Abstract Submission' )]
#[JS('/~web/index.js')]
#[CSS('/~web/index.css')]
#[CSS('https://cdn.jsdelivr.net/npm/svelte-material-ui@4.0.0/bare.min.css')]
#[Cache( 0 )]
class Index extends SmartResponder{
	public array $users;
	protected function prepare(Response $response){
		$this->smart['data']->set('event', ActualEvent::get());
	}
}

