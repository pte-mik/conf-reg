<?php namespace Application\Services;

use Application\Entity\Event;
use Application\Entity\Submission;
use Application\Entity\User;
use Application\Exceptions\NotAuthorizedException;
use Application\Exceptions\NotFoundException;
use Atomino\Carbon\Database\Finder\Filter;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use function Atomino\debug;

class SubmissionService {

	/**
	 * @param $id
	 * @param User $user
	 * @throws NotAuthorizedException
	 * @throws NotFoundException
	 * @throws \Atomino\Carbon\ValidationError
	 */
	public function submit($id, User $user){
		$submission = $this->pick($id, $user);
		if($submission->event->organizerId !== $user->id && ($submission->status !== Submission::status__draft||$submission->event->deadline->getTimestamp() < time())) throw new NotAuthorizedException();
		$submission->status = Submission::status__underReview;
		$submission->save();
	}

	/**
	 * @param $id
	 * @param User $user
	 * @throws NotAuthorizedException
	 * @throws NotFoundException
	 */
	public function delete($id, User $user) {
		$submission = $this->pick($id, $user);
		if($submission->event->organizerId !== $user->id && ($submission->status !== Submission::status__draft||$submission->event->deadline->getTimestamp() < time())) throw new NotAuthorizedException();
		$submission->delete();
	}
	/**
	 * @param int $id
	 * @param UploadedFile $file
	 * @param User $user
	 * @throws NotAuthorizedException
	 * @throws NotFoundException
	 * @throws \Throwable
	 */
	public function addImage(int $id, UploadedFile $file, User $user) {
		$submission = $this->pick($id, $user);
		if($submission->event->organizerId !== $user->id && ($submission->status !== Submission::status__draft||$submission->event->deadline->getTimestamp() < time())) throw new NotAuthorizedException();
		$submission->image->addFile($file);
	}
	/**
	 * @param int $id
	 * @param User $user
	 * @throws NotAuthorizedException
	 * @throws NotFoundException
	 */
	public function removeImage(int $id, User $user) {
		$submission = $this->pick($id, $user);
		if($submission->event->organizerId !== $user->id && ($submission->status !== Submission::status__draft||$submission->event->deadline->getTimestamp() < time())) throw new NotAuthorizedException();
		$submission->image->first?->delete();
	}

	/**
	 * @param Event $event
	 * @param User $user
	 * @return Submission[]
	 */
	public function collect(Event $event, User $user): array {
		return Submission::search(Filter::where(Submission::eventId($event->id))->and(Submission::userId($user->id)))->asc(Submission::title)->collect();
	}

	/**
	 * @param Event $event
	 * @return Submission[]
	 */
	public function collectForEvent(Event $event) :array{
		return Submission::search(Filter::where(Submission::eventId($event->id)))->asc(Submission::title)->collect();
	}

	/**
	 * @param User $user
	 * @param int $id
	 * @return Submission
	 * @throws NotAuthorizedException
	 * @throws NotFoundException
	 */
	public function pick(int $id, User $user): Submission {
		$submission = Submission::pick($id);
		if (is_null($submission)) throw new NotFoundException();
		if ($submission->userId !== $user->id && $submission->event->organizerId !== $user->id) throw new NotAuthorizedException();
		return $submission;
	}

	/**
	 * @param $id
	 * @param User $user
	 * @param string $text
	 * @param string $title
	 * @param string $category
	 * @param array $authors
	 * @param array $keywords
	 * @throws NotAuthorizedException
	 * @throws NotFoundException
	 * @throws \Atomino\Carbon\ValidationError
	 */
	public function modify($id, User $user, string $text, string $title, string $category, array $authors, array $keywords, string $imageCaption) {
		$submission = $this->pick($id, $user);
		if($submission->event->organizerId !== $user->id && ($submission->status !== Submission::status__draft||$submission->event->deadline->getTimestamp() < time())) throw new NotAuthorizedException();
		$submission->text = $text;
		$submission->title = $title;
		$submission->category = $category;
		$submission->authors = $authors;
		$submission->keywords = $keywords;
		$submission->imageCaption = $imageCaption;
		$submission->save();
	}

	/**
	 * @param User $user
	 * @param Event $event
	 * @param string $title
	 * @param string $category
	 * @return Submission
	 * @throws NotAuthorizedException
	 * @throws \Atomino\Carbon\ValidationError
	 */
	public function create(User $user, Event $event, string $title, string $category) {
		if($event->organizerId !== $user){
			if($event->deadline->getTimestamp() < time()) throw new NotAuthorizedException();
			if($event->participationRequired && !$user->hasParticipation($event)) throw new NotAuthorizedException();
		}
		$submission = Submission::create();
		$submission->title = $title;
		$submission->category = $category;
		$submission->userId = $user->id;
		$submission->eventId = $event->id;
		$submission->save();
		return $submission;
	}

}
