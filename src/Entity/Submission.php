<?php namespace Application\Entity;

use Atomino\Bundle\Authenticate\Authenticator;
use Atomino\Carbon\Attributes\BelongsTo;
use Atomino\Carbon\Attributes\EventHandler;
use Atomino\Carbon\Attributes\Modelify;
use Application\Atoms\Entity\_Submission;
use Atomino\Carbon\Attributes\Validator;
use Atomino\Carbon\Entity;
use Atomino\Carbon\Plugins\Created\Created;
use Atomino\Carbon\Plugins\Updated\Updated;

#[Modelify(\Application\Database\DefaultConnection::class, 'submission', true)]
#[Validator('title', \Symfony\Component\Validator\Constraints\Length::class, ["min" => 10])]
#[BelongsTo('user', User::class, 'userId')]
#[BelongsTo('event', Event::class, 'eventId')]
#[Created]
#[Updated]
class Submission extends _Submission {
	public null|string $status = self::status__draft;

	public function __construct(private Authenticator $authenticator) {
	}

	#[EventHandler(Entity::EVENT_BEFORE_INSERT, Entity::EVENT_BEFORE_UPDATE)]
	public function beforeSave() {
		$this->log[] = [
			"date"   => date("Y-m-d H:i:m"),
			"userid" => $this->authenticator->get()->id,
			"status" => $this->status,
		];
	}

}