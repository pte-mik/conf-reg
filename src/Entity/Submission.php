<?php namespace Application\Entity;

use Application\Atoms\Entity\_Submission;
use Atomino\Bundle\Authenticate\Authenticator;
use Atomino\Carbon\Attributes\BelongsTo;
use Atomino\Carbon\Attributes\EventHandler;
use Atomino\Carbon\Attributes\Modelify;
use Atomino\Carbon\Attributes\Validator;
use Atomino\Carbon\Entity;
use Atomino\Carbon\Plugins\Attachment\Attachmentable;
use Atomino\Carbon\Plugins\Attachment\AttachmentCollection;
use Atomino\Carbon\Plugins\Created\Created;
use Atomino\Carbon\Plugins\Updated\Updated;
use Atomino\Carbon\ValidationError;
use Symfony\Component\Validator\Constraints\ValidValidator;
use Symfony\Component\Validator\Validation;

#[Modelify(\Application\Database\DefaultConnection::class, 'submission', true)]
#[Validator('title', \Symfony\Component\Validator\Constraints\Length::class, ["min" => 10])]
#[BelongsTo('user', User::class, 'userId')]
#[BelongsTo('event', Event::class, 'eventId')]
#[Attachmentable()]
#[AttachmentCollection(field: 'image', maxCount: 1, maxSize: 512 * 1024, mimetype: "/image\/.*/")]
#[Created]
#[Updated]
class Submission extends _Submission {
	public null|string $status = self::status__draft;

	public function __construct(private Authenticator $authenticator) {
	}
	public function isEditableByUser(): bool { return $this->status === static::status__draft; }
	public function isDeletableByUser(): bool { return $this->status === static::status__draft; }

	/**
	 * @throws ValidationError
	 */
	#[EventHandler(Entity::EVENT_BEFORE_INSERT, Entity::EVENT_BEFORE_UPDATE)]
	public function beforeSave() {
		if(!in_array($this->category, $this->event->categories)){
			throw new ValidationError([["field"=>"category", "message"=>"Category not available"]]);
		}
		$this->log[] = [
			"date"   => date("Y-m-d H:i:m"),
			"userid" => $this->authenticator->get()->id,
			"status" => $this->status,
		];
	}

}
