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
 * @method static \Application\Atoms\EntityFinder\_Event search( Filter $filter = null )
 * @method static \Atomino\Carbon\Database\Finder\Comparison id($isin = null)
 * @property-read int|null $id
 * @method static \Atomino\Carbon\Database\Finder\Comparison organizerId($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison url($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison deadline($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison regOpening($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison categories($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison title($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison website($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison participationRequired($isin = null)
 * @property-read \Application\Entity\User $organizer
 */
#[RequiredField('id', \Atomino\Carbon\Field\IntField::class)]
#[Field("id", \Atomino\Carbon\Field\IntField::class)]
#[Protect("id", true, false)]
#[Immutable("id",false)]
#[Validator("organizerId", \Symfony\Component\Validator\Constraints\NotNull::class)]
#[Validator("organizerId", \Symfony\Component\Validator\Constraints\PositiveOrZero::class)]
#[Field("organizerId", \Atomino\Carbon\Field\IntField::class)]
#[Validator("url", \Symfony\Component\Validator\Constraints\NotNull::class)]
#[Validator("url", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("url", \Atomino\Carbon\Field\StringField::class)]
#[Validator("deadline", \Symfony\Component\Validator\Constraints\NotNull::class)]
#[Field("deadline", \Atomino\Carbon\Field\DateField::class)]
#[Validator("regOpening", \Symfony\Component\Validator\Constraints\NotNull::class)]
#[Field("regOpening", \Atomino\Carbon\Field\DateField::class)]
#[Validator("categories", \Symfony\Component\Validator\Constraints\NotNull::class)]
#[Field("categories", \Atomino\Carbon\Field\JsonField::class)]
#[Validator("title", \Symfony\Component\Validator\Constraints\NotNull::class)]
#[Validator("title", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("title", \Atomino\Carbon\Field\StringField::class)]
#[Validator("website", \Symfony\Component\Validator\Constraints\NotNull::class)]
#[Validator("website", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("website", \Atomino\Carbon\Field\StringField::class)]
#[Validator("participationRequired", \Symfony\Component\Validator\Constraints\NotNull::class)]
#[Field("participationRequired", \Atomino\Carbon\Field\BoolField::class)]
abstract class _Event extends Entity {
	static null|Model $model = null;
	const id = 'id';
	protected int|null $id = null;
	protected function getId():int|null{ return $this->id;}
	const organizerId = 'organizerId';
	public int|null $organizerId = null;
	const url = 'url';
	public string|null $url = null;
	const deadline = 'deadline';
	public \DateTime|null $deadline = null;
	const regOpening = 'regOpening';
	public \DateTime|null $regOpening = null;
	const categories = 'categories';
	public array $categories = [];
	const title = 'title';
	public string|null $title = null;
	const website = 'website';
	public string|null $website = null;
	const participationRequired = 'participationRequired';
	public bool|null $participationRequired = null;
}





