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
 * @method static \Application\Atoms\EntityFinder\_User search( Filter $filter = null )
 * #[Immutable( 'guid', true )]
 * #[Protect( 'guid', true, false )]
 * #[RequiredField('guid', StringField::class)]
 * @property-read \Atomino\Bundle\Attachment\Collection $avatar
 * @property-read \Atomino\Bundle\Attachment\Collection $images
 * @property-read \Atomino\Bundle\Attachment\Collection $files
 * @method static \Atomino\Carbon\Database\Finder\Comparison id($isin = null)
 * @property-read int|null $id
 * @method static \Atomino\Carbon\Database\Finder\Comparison attachments($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison guid($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison group($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison created($isin = null)
 * @property-read \DateTime|null $created
 * @method static \Atomino\Carbon\Database\Finder\Comparison updated($isin = null)
 * @property-read \DateTime|null $updated
 * @method static \Atomino\Carbon\Database\Finder\Comparison name($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison email($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison password($isin = null)
 * @property-read string|null $password
 * @method static \Atomino\Carbon\Database\Finder\Comparison phone($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison bossId($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison workerIds($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison test($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison switch($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison text($isin = null)
 * @property-read \Application\Atoms\EntityFinder\_Event $events
 * @property-read \Application\Entity\User $boss
 */
#[RequiredField('id', \Atomino\Carbon\Field\IntField::class)]
#[Immutable("created", true)]
#[Protect("created", true, false)]
#[RequiredField("created", \Atomino\Carbon\Field\DateTimeField::class)]
#[Protect("updated", true, false)]
#[RequiredField("updated", \Atomino\Carbon\Field\DateTimeField::class)]
#[Immutable( 'attachments', true )]
#[Protect( 'attachments', false, false )]
#[RequiredField( 'attachments', \Atomino\Carbon\Field\JsonField::class )]
#[Protect("password", true, false)]
#[RequiredField("email", \Atomino\Carbon\Field\StringField::class)]
#[RequiredField("password", \Atomino\Carbon\Field\StringField::class)]
#[Field("id", \Atomino\Carbon\Field\IntField::class)]
#[Protect("id", true, false)]
#[Immutable("id",false)]
#[Field("attachments", \Atomino\Carbon\Field\JsonField::class)]
#[Validator("guid", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>36])]
#[Field("guid", \Atomino\Carbon\Field\StringField::class)]
#[Validator("group", \Symfony\Component\Validator\Constraints\Choice::class, ['multiple'=>false,'choices'=>['admin','moderator','visitor']])]
#[Field("group", \Atomino\Carbon\Field\EnumField::class, ['admin','moderator','visitor'])]
#[Field("created", \Atomino\Carbon\Field\DateTimeField::class)]
#[Field("updated", \Atomino\Carbon\Field\DateTimeField::class)]
#[Validator("name", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>16])]
#[Field("name", \Atomino\Carbon\Field\StringField::class)]
#[Validator("email", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("email", \Atomino\Carbon\Field\StringField::class)]
#[Validator("password", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>128])]
#[Field("password", \Atomino\Carbon\Field\StringField::class)]
#[Validator("phone", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("phone", \Atomino\Carbon\Field\StringField::class)]
#[Validator("bossId", \Symfony\Component\Validator\Constraints\PositiveOrZero::class)]
#[Field("bossId", \Atomino\Carbon\Field\IntField::class)]
#[Field("workerIds", \Atomino\Carbon\Field\JsonField::class)]
#[Validator("test", \Symfony\Component\Validator\Constraints\Choice::class, ['multiple'=>true,'choices'=>['alfa','beta','gamma']])]
#[Field("test", \Atomino\Carbon\Field\SetField::class, ['alfa','beta','gamma'])]
#[Field("switch", \Atomino\Carbon\Field\BoolField::class)]
#[Validator("text", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>65535])]
#[Field("text", \Atomino\Carbon\Field\StringField::class)]
abstract class _User extends Entity implements \Atomino\Bundle\Attachment\AttachmentableInterface, \Atomino\Bundle\Authenticate\AuthenticableInterface, \Atomino\Bundle\Authorize\AuthorizableInterface{
	static null|Model $model = null;
	use \Atomino\Carbon\Plugins\Guid\GuidTrait;
	use \Atomino\Carbon\Plugins\Created\CreatedTrait;
	use \Atomino\Carbon\Plugins\Updated\UpdatedTrait;
	use \Atomino\Carbon\Plugins\Attachment\AttachmentableTrait;
	protected final function __getAvatar(){return $this->getAttachmentCollection("avatar");}
	protected final function __getImages(){return $this->getAttachmentCollection("images");}
	protected final function __getFiles(){return $this->getAttachmentCollection("files");}
	use \Atomino\Carbon\Plugins\Authenticate\AuthenticableTrait;
	use \Atomino\Carbon\Plugins\Authorize\AuthorizableTrait;
	const ROLE_USER = "user";
	const ROLE_MODERATE = "moderate";
	const ROLE_EDIT = "edit";
	const id = 'id';
	protected int|null $id = null;
	protected function getId():int|null{ return $this->id;}
	const attachments = 'attachments';
	protected array $attachments = [];
	const guid = 'guid';
	public string|null $guid = null;
	const group = 'group';
	public string|null $group = null;
	const group__admin = 'admin';
	const group__moderator = 'moderator';
	const group__visitor = 'visitor';
	const created = 'created';
	protected \DateTime|null $created = null;
	protected function getCreated():\DateTime|null{ return $this->created;}
	const updated = 'updated';
	protected \DateTime|null $updated = null;
	protected function getUpdated():\DateTime|null{ return $this->updated;}
	const name = 'name';
	public string|null $name = null;
	const email = 'email';
	public string|null $email = null;
	const password = 'password';
	protected string|null $password = null;
	protected function getPassword():string|null{ return $this->password;}
	const phone = 'phone';
	public string|null $phone = null;
	const bossId = 'bossId';
	public int|null $bossId = null;
	const workerIds = 'workerIds';
	public array $workerIds = [];
	const test = 'test';
	public array $test = [];
	const test__alfa = 'alfa';
	const test__beta = 'beta';
	const test__gamma = 'gamma';
	const switch = 'switch';
	public bool|null $switch = null;
	const text = 'text';
	public string|null $text = null;
}





