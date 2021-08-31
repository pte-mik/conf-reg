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
 * @method static \Application\Atoms\EntityFinder\_Participation search( Filter $filter = null )
 * @method static \Atomino\Carbon\Database\Finder\Comparison id($isin = null)
 * @property-read int|null $id
 * @method static \Atomino\Carbon\Database\Finder\Comparison userId($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison eventId($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison institute($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison country($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison zip($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison address($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison vat($isin = null)
 */
#[RequiredField('id', \Atomino\Carbon\Field\IntField::class)]
#[Field("id", \Atomino\Carbon\Field\IntField::class)]
#[Protect("id", true, false)]
#[Immutable("id",false)]
#[Validator("userId", \Symfony\Component\Validator\Constraints\NotNull::class)]
#[Validator("userId", \Symfony\Component\Validator\Constraints\PositiveOrZero::class)]
#[Field("userId", \Atomino\Carbon\Field\IntField::class)]
#[Validator("eventId", \Symfony\Component\Validator\Constraints\NotNull::class)]
#[Validator("eventId", \Symfony\Component\Validator\Constraints\PositiveOrZero::class)]
#[Field("eventId", \Atomino\Carbon\Field\IntField::class)]
#[Validator("institute", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("institute", \Atomino\Carbon\Field\StringField::class)]
#[Validator("country", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("country", \Atomino\Carbon\Field\StringField::class)]
#[Validator("zip", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("zip", \Atomino\Carbon\Field\StringField::class)]
#[Validator("address", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("address", \Atomino\Carbon\Field\StringField::class)]
#[Validator("vat", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("vat", \Atomino\Carbon\Field\StringField::class)]
abstract class _Participation extends Entity {
	static null|Model $model = null;
	const id = 'id';
	protected int|null $id = null;
	protected function getId():int|null{ return $this->id;}
	const userId = 'userId';
	public int|null $userId = null;
	const eventId = 'eventId';
	public int|null $eventId = null;
	const institute = 'institute';
	public string|null $institute = null;
	const country = 'country';
	public string|null $country = null;
	const zip = 'zip';
	public string|null $zip = null;
	const address = 'address';
	public string|null $address = null;
	const vat = 'vat';
	public string|null $vat = null;
}





