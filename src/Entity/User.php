<?php namespace Application\Entity;

use Application\Atoms\Entity\_User;
use Atomino\Bundle\Comment\CommenterInterface;
use Atomino\Carbon\Attributes\HasMany;
use Atomino\Carbon\Attributes\Modelify;
use Atomino\Carbon\Attributes\Protect;
use Atomino\Carbon\Attributes\Validator;
use Atomino\Carbon\Plugins\Attachment\Attachmentable;
use Atomino\Carbon\Plugins\Attachment\AttachmentCollection;
use Atomino\Carbon\Plugins\Authenticate\Authenticable;
use Atomino\Carbon\Plugins\Authorize\Authorizable;
use Atomino\Carbon\Plugins\Created\Created;
use Atomino\Carbon\Plugins\Guid\Guid;
use Atomino\Carbon\Plugins\Updated\Updated;

#[Modelify(\Application\Database\DefaultConnection::class, 'user', true)]
#[Validator('email', \Symfony\Component\Validator\Constraints\Email::class)]
#[Protect('name', true, true)]
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

	public function jsonSerialize() {
		$data = parent::jsonSerialize();
		unset($data['password']);
		return $data;
	}
}
