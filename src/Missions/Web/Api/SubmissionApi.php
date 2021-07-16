<?php namespace Application\Missions\Web\Api;

use Application\Entity\Submission;
use Application\Exceptions\NotAuthorizedException;
use Application\Exceptions\NotFoundException;
use Application\Services\ActualEventService;
use Application\Services\SubmissionService;
use Atomino\Bundle\Attachment\FileException;
use Atomino\Bundle\Authenticate\Authenticator;
use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Carbon\ValidationError;
use Atomino\Mercury\Responder\Api\Api;
use Atomino\Mercury\Responder\Api\Attributes\Auth;
use Atomino\Mercury\Responder\Api\Attributes\Route;
use Symfony\Component\HttpFoundation\Response;
use function Atomino\debug;

class SubmissionApi extends Api {

	public function __construct(private Authenticator $authenticator, private SubmissionService $submissionService, private ActualEventService $actualEventService) { }

	#[Route(self::GET, '/get')]
	#[Auth]
	public function collect():array {
		return $this->submissionService->collect($this->actualEventService->get(), $this->authenticator->get());
	}

	#[Route(self::POST, '/:id/image')]
	#[Auth]
	public function imageAdd(int $id) {
		$file = $this->files->get('file');
		try{
			$this->submissionService->addImage($id, $file, $this->authenticator->get());
		} catch (NotAuthorizedException $e) {
			$this->setStatusCode(Response::HTTP_FORBIDDEN);
		} catch (NotFoundException $e) {
			$this->setStatusCode(Response::HTTP_NOT_FOUND);
		}catch (ValidationError $e) {
			$this->setStatusCode(self::VALIDATION_ERROR);
			return ($e->getMessages());
		}catch (FileException $e){
			$this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
			return [["field"=>null, "message"=>$e->getMessage()]];
		}
	}

	#[Route(self::DELETE, '/:id/image')]
	#[Auth]
	public function removeImage(int $id) {
		try{
			$this->submissionService->removeImage($id, $this->authenticator->get());
		} catch (NotAuthorizedException $e) {
			$this->setStatusCode(Response::HTTP_FORBIDDEN);
		} catch (NotFoundException $e) {
			$this->setStatusCode(Response::HTTP_NOT_FOUND);
		}catch (ValidationError $e) {
			$this->setStatusCode(self::VALIDATION_ERROR);
			return ($e->getMessages());
		}catch (FileException $e){
			$this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
			return [["field"=>null, "message"=>$e->getMessage()]];
		}
	}


	#[Route(self::DELETE, '/')]
	#[Auth]
	public function delete(): void {
		try {
			$this->submissionService->delete($this->data->get('id'), $this->authenticator->get());
		} catch (NotAuthorizedException $e) {
			$this->setStatusCode(Response::HTTP_FORBIDDEN);
		} catch (NotFoundException $e) {
			$this->setStatusCode(Response::HTTP_NOT_FOUND);
		}
	}

	#[Route(self::POST, '/')]
	#[Auth]
	public function save() {
		try {
			$this->submissionService->modify(
				$this->data->get('id'),
				$this->authenticator->get(),
				$this->data->get("text"),
				$this->data->get("title"),
				$this->data->get("category"),
				$this->data->get("authors"),
				$this->data->get("keywords"),
				(string) $this->data->get("imageCaption"),
			);
		} catch (NotAuthorizedException $e) {
			$this->setStatusCode(Response::HTTP_FORBIDDEN);
			return null;
		} catch (NotFoundException $e) {
			$this->setStatusCode(Response::HTTP_NOT_FOUND);
			return null;
		} catch (ValidationError $e) {
			$this->setStatusCode(self::VALIDATION_ERROR);
			return ($e->getMessages());
		}
	}

	#[Route(self::GET, '/get/:id')]
	#[Auth]
	public function get(int $id) {
		try {
			$submission = $this->submissionService->pick($id, $this->authenticator->get());
			$submissionData = $submission->export();
			$submissionData['image'] = $submission->image->first?->image->crop(800,400)->webp;
			$submissionData['originalImage'] = $submission->image->first?->url;
			return $submissionData;
		} catch (NotAuthorizedException $e) {
			$this->setStatusCode(Response::HTTP_FORBIDDEN);
			return null;
		} catch (NotFoundException $e) {
			$this->setStatusCode(Response::HTTP_NOT_FOUND);
			return null;
		}
	}

	#[Route(self::POST, '/create')]
	#[Auth]
	public function create() {
		try {
			return $this->submissionService->create(
				$this->authenticator->get(),
				$this->actualEventService->get(),
				$this->data->get('title'),
				$this->data->get('category')
			)->id;
		} catch (ValidationError $e) {
			$this->setStatusCode(self::VALIDATION_ERROR);
			return ($e->getMessages());
		}
	}

}
