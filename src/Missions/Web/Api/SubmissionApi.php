<?php namespace Application\Missions\Web\Api;

use Application\Entity\Submission;
use Application\Modules\ActualEvent;
use Atomino\Bundle\Authenticate\Authenticator;
use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Carbon\ValidationError;
use Atomino\Mercury\Responder\Api\Api;
use Atomino\Mercury\Responder\Api\Attributes\Auth;
use Atomino\Mercury\Responder\Api\Attributes\Route;

class SubmissionApi extends Api {

	public function __construct(private Authenticator $authenticator) { }

	#[Route(self::GET, '/get')]
	#[Auth]
	public function get(){
		return Submission::search(Filter::where(Submission::eventId(ActualEvent::get()->id))->and(Submission::userId($this->authenticator->get()->id)))->asc(Submission::title)->collect();
	}


	#[Route(self::POST, '/')]
	#[Auth]
	public function saveAbstract(){
		$id = $this->data->get('id');
		$submission = Submission::search(Filter::where(Submission::eventId(ActualEvent::get()->id))->and(Submission::userId($this->authenticator->get()->id))->and(Submission::id($id)))->pick();
		if($submission === null){
			$this->setStatusCode(404);
			return null;
		}
		$submission->text = $this->data->get("text");
		$submission->title = $this->data->get("title");
		$submission->category = $this->data->get("category");
		$submission->status = Submission::status__draft;
		try {
			$submission->save();
			return true;
		}catch (ValidationError $e){
			$this->setStatusCode(self::VALIDATION_ERROR);
			return($e->getMessages());
		}
	}

	#[Route(self::GET, '/get/:id')]
	#[Auth]
	public function getAbstract(int $id){
		$submission = Submission::search(Filter::where(Submission::eventId(ActualEvent::get()->id))->and(Submission::userId($this->authenticator->get()->id))->and(Submission::id($id)))->pick();
		if($submission === null) $this->setStatusCode(404);
		else return $submission;
	}

	#[Route(self::POST, '/create')]
	#[Auth]
	public function create() {
		$submission = Submission::create();
		$submission->title = $this->data->get('title');
		$submission->category = $this->data->get('category');
		$submission->userId = $this->authenticator->get()->id;
		$submission->eventId = ActualEvent::get()->id;
		try {
			$id = $submission->save();
			return $id;
		}catch (ValidationError $e){
			$this->setStatusCode(self::VALIDATION_ERROR);
			return($e->getMessages());
		}
	}

}
