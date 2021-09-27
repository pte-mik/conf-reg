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
use function Atomino\debug;

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

	public function getTemplateData(){
		$authors = $this->authors;
		$affiliations = [];
		foreach ($authors as $key => $author){
			$first = trim($author['name']['first']);
			$first = preg_replace("/\s\s+/", ' ', $first);
			$first = explode(' ', $first);
			$firstShort = '';
			foreach ($first as $firstPart){
				$firstShort .= strtoupper(substr($firstPart, 0, 1)).'. ';
			}
			$firstShort = trim($firstShort);

			$authors[$key]['name']['firstShort'] = trim($firstShort);
			if($author['institute']){
				if(!in_array($author['institute'], $affiliations)){
					$affiliations[] = $author['institute'];
				}
				$authors[$key]['index'] = array_search($author['institute'], $affiliations);
			}
		}

		return [
			'id'=>$this->id,
			'title'=>$this->title,
			'text'=>$this->text,
			'keywords'=>$this->keywords,
			'authors'=>$authors,
			'affiliations'=>$affiliations,
			'image'=> $this->image->count < 1 ? false : [
				'caption' => $this->imageCaption,
				'file'=>$this->image->first->filename,
				'ext'=>pathinfo($this->image->first->filename, PATHINFO_EXTENSION)
			]
		];
	}

}
