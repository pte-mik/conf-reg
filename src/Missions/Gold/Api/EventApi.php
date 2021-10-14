<?php namespace Application\Missions\Gold\Api;

use Application\Entity\Event;
use Application\Services\EventExportService;
use Atomino\Gold\Gold;
use Atomino\Gold\GoldApi;
use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Carbon\Entity;
use Atomino\Mercury\Responder\Api\Attributes\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Mime\MimeTypes;
use function Atomino\debug;

#[Gold(Event::class, 50, true)]
class EventApi extends GoldApi {
	protected function selectMap(Entity $item): string {
		/** @var Event $item */
		return $item->title;
	}

	public function __construct(private EventExportService $eventExportService) {
		parent::__construct();
	}
	#[Route("GET", '/download/:id')]
	public function download($id){
		$event = Event::pick($id);
		$file = $this->eventExportService->export($event);
		BinaryFileResponse::trustXSendfileTypeHeader();
		$file = new File($file);
		$response = new BinaryFileResponse($file);
		$response->headers->set('Content-Disposition', $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $file->getFilename()));
		if (is_array($mimetypes = (new MimeTypes())->getMimeTypes($file->getExtension())) && count($mimetypes)) $response->headers->set('Content-Type', $mimetypes[0]);
		$response->send();
		die();
	}
	#[Route("GET", '/users/:id')]
	public function users($id){
		$event = Event::pick($id);
		$file = $this->eventExportService->exportUsers($event);
		BinaryFileResponse::trustXSendfileTypeHeader();
		$file = new File($file);
		$response = new BinaryFileResponse($file);
		$response->headers->set('Content-Disposition', $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $file->getFilename()));
		if (is_array($mimetypes = (new MimeTypes())->getMimeTypes($file->getExtension())) && count($mimetypes)) $response->headers->set('Content-Type', $mimetypes[0]);
		$response->send();
		die();
	}
}
