<?php namespace Application\Entity;

use Application\Atoms\Entity\_User;
use Atomino\Bundle\Comment\CommenterInterface;
use Atomino\Carbon\Attributes\HasMany;
use Atomino\Carbon\Attributes\Modelify;
use Atomino\Carbon\Attributes\Protect;
use Atomino\Carbon\Attributes\Validator;
use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Carbon\Plugins\Attachment\Attachmentable;
use Atomino\Carbon\Plugins\Attachment\AttachmentCollection;
use Atomino\Carbon\Plugins\Authenticate\Authenticable;
use Atomino\Carbon\Plugins\Authorize\Authorizable;
use Atomino\Carbon\Plugins\Created\Created;
use Atomino\Carbon\Plugins\Guid\Guid;
use Atomino\Carbon\Plugins\Updated\Updated;
use Atomino\Carbon\Validation\UniqueEntity;
use Atomino\Carbon\ValidationError;

#[Modelify(\Application\Database\DefaultConnection::class, 'user', true)]
#[Validator('email', \Symfony\Component\Validator\Constraints\Email::class)]
#[Validator('email', \Symfony\Component\Validator\Constraints\Length::class, ['min' => 4])]
#[Validator('name', \Symfony\Component\Validator\Constraints\Length::class, ['min' => 4])]
#[Validator('password', \Symfony\Component\Validator\Constraints\Length::class, ['min' => 8])]
#[Validator(null, UniqueEntity::class, ["fields"=>['email']])]
#[Guid()]
#[Created()]
#[Updated()]
#[Attachmentable()]
#[AttachmentCollection(field: 'avatar', maxCount: 1, maxSize: 512 * 1024, mimetype: "/image\/.*/")]
#[Authenticable('email')]
#[Authorizable('group', ['user', 'moderate', 'edit'])]
#[HasMany('events', Event::class, 'organizerId')]
class User extends _User {

	const GROUPS = [];

	public function jsonSerialize(): array {
		$data = parent::jsonSerialize();
		unset($data['password']);
		return $data;
	}

	public function hasParticipation(Event $event): bool { return !is_null($this->getParticipation($event)); }
	public function getParticipation(Event $event): Participation|null { return Participation::search(Filter::where(Participation::eventId($event->id))->and(Participation::userId($this->id)))->pick(); }
}
