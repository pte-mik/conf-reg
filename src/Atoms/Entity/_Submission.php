<?php namespace Application\Atoms\Entity;

use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Carbon\Attributes\Field;
use Atomino\Carbon\Attributes\Immutable;
use Atomino\Carbon\Attributes\Protect;
use Atomino\Carbon\Attributes\Validator;
use Atomino\Carbon\Entity;
use Atomino\Carbon\Model;
use Atomino\Carbon\Attributes\RequiredField;


/**
 * @method static \Application\Atoms\EntityFinder\_Submission search( Filter $filter = null )
 * @property-read \Atomino\Bundle\Attachment\Collection $image
 * @method static \Atomino\Carbon\Database\Finder\Comparison attachments($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison authors($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison category($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison created($isin = null)
 * @property-read \DateTime|null $created
 * @method static \Atomino\Carbon\Database\Finder\Comparison eventId($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison id($isin = null)
 * @property-read int|null $id
 * @method static \Atomino\Carbon\Database\Finder\Comparison imageCaption($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison keywords($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison log($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison status($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison text($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison title($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison updated($isin = null)
 * @property-read \DateTime|null $updated
 * @method static \Atomino\Carbon\Database\Finder\Comparison userId($isin = null)
 * @property-read \Application\Entity\User $user
 * @property-read \Application\Entity\Event $event
 */
#[RequiredField('id', \Atomino\Carbon\Field\IntField::class)]
#[Immutable( 'attachments', true )]
#[Protect( 'attachments', false, false )]
#[RequiredField( 'attachments', \Atomino\Carbon\Field\JsonField::class )]
#[Immutable("created", true)]
#[Protect("created", true, false)]
#[RequiredField("created", \Atomino\Carbon\Field\DateTimeField::class)]
#[Protect("updated", true, false)]
#[RequiredField("updated", \Atomino\Carbon\Field\DateTimeField::class)]
#[Field("attachments", \Atomino\Carbon\Field\JsonField::class)]
#[Field("authors", \Atomino\Carbon\Field\JsonField::class)]
#[Validator("category", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("category", \Atomino\Carbon\Field\StringField::class)]
#[Validator("created", \Symfony\Component\Validator\Constraints\NotNull::class)]
#[Field("created", \Atomino\Carbon\Field\DateTimeField::class)]
#[Validator("eventId", \Symfony\Component\Validator\Constraints\PositiveOrZero::class)]
#[Field("eventId", \Atomino\Carbon\Field\IntField::class)]
#[Field("id", \Atomino\Carbon\Field\IntField::class)]
#[Protect("id", true, false)]
#[Immutable("id",false)]
#[Validator("imageCaption", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("imageCaption", \Atomino\Carbon\Field\StringField::class)]
#[Field("keywords", \Atomino\Carbon\Field\JsonField::class)]
#[Validator("log", \Symfony\Component\Validator\Constraints\NotNull::class)]
#[Field("log", \Atomino\Carbon\Field\JsonField::class)]
#[Validator("status", \Symfony\Component\Validator\Constraints\Choice::class, ['multiple'=>false,'choices'=>['draft','underReview','declined','accepted']])]
#[Field("status", \Atomino\Carbon\Field\EnumField::class, ['draft','underReview','declined','accepted'])]
#[Validator("text", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>65535])]
#[Field("text", \Atomino\Carbon\Field\StringField::class)]
#[Validator("title", \Symfony\Component\Validator\Constraints\NotNull::class)]
#[Validator("title", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("title", \Atomino\Carbon\Field\StringField::class)]
#[Validator("updated", \Symfony\Component\Validator\Constraints\NotNull::class)]
#[Field("updated", \Atomino\Carbon\Field\DateTimeField::class)]
#[Validator("userId", \Symfony\Component\Validator\Constraints\PositiveOrZero::class)]
#[Field("userId", \Atomino\Carbon\Field\IntField::class)]
abstract class _Submission extends Entity implements \Atomino\Bundle\Attachment\AttachmentableInterface{
	static null|Model $model = null;
	use \Atomino\Carbon\Plugins\Attachment\AttachmentableTrait;
	protected final function __getImage(){return $this->getAttachmentCollection("image");}
	use \Atomino\Carbon\Plugins\Created\CreatedTrait;
	use \Atomino\Carbon\Plugins\Updated\UpdatedTrait;
	const attachments = 'attachments';
	protected array $attachments = [];
	const authors = 'authors';
	public array $authors = [];
	const category = 'category';
	public string|null $category = null;
	const created = 'created';
	protected \DateTime|null $created = null;
	protected function getCreated():\DateTime|null{ return $this->created;}
	const eventId = 'eventId';
	public int|null $eventId = null;
	const id = 'id';
	protected int|null $id = null;
	protected function getId():int|null{ return $this->id;}
	const imageCaption = 'imageCaption';
	public string|null $imageCaption = null;
	const keywords = 'keywords';
	public array $keywords = [];
	const log = 'log';
	public array $log = [];
	const status = 'status';
	public string|null $status = null;
	const status__draft = 'draft';
	const status__underReview = 'underReview';
	const status__declined = 'declined';
	const status__accepted = 'accepted';
	const text = 'text';
	public string|null $text = null;
	const title = 'title';
	public string|null $title = null;
	const updated = 'updated';
	protected \DateTime|null $updated = null;
	protected function getUpdated():\DateTime|null{ return $this->updated;}
	const userId = 'userId';
	public int|null $userId = null;
}





