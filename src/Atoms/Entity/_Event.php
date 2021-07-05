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
 * @method static \Atomino\Carbon\Database\Finder\Comparison allowedCategories($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison contactUrl($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison deadline($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison id($isin = null)
 * @property-read int|null $id
 * @method static \Atomino\Carbon\Database\Finder\Comparison location($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison name($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison organizer($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison privacyUrl($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison subtitle($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison termsUrl($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison time($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison title($isin = null)
 * @method static \Atomino\Carbon\Database\Finder\Comparison url($isin = null)
 */
#[RequiredField('id', \Atomino\Carbon\Field\IntField::class)]
#[Field("allowedCategories", \Atomino\Carbon\Field\JsonField::class)]
#[Validator("contactUrl", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("contactUrl", \Atomino\Carbon\Field\StringField::class)]
#[Field("deadline", \Atomino\Carbon\Field\DateField::class)]
#[Field("id", \Atomino\Carbon\Field\IntField::class)]
#[Protect("id", true, false)]
#[Immutable("id",false)]
#[Validator("location", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("location", \Atomino\Carbon\Field\StringField::class)]
#[Validator("name", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("name", \Atomino\Carbon\Field\StringField::class)]
#[Validator("organizer", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("organizer", \Atomino\Carbon\Field\StringField::class)]
#[Validator("privacyUrl", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("privacyUrl", \Atomino\Carbon\Field\StringField::class)]
#[Validator("subtitle", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("subtitle", \Atomino\Carbon\Field\StringField::class)]
#[Validator("termsUrl", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("termsUrl", \Atomino\Carbon\Field\StringField::class)]
#[Validator("time", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("time", \Atomino\Carbon\Field\StringField::class)]
#[Validator("title", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("title", \Atomino\Carbon\Field\StringField::class)]
#[Validator("url", \Symfony\Component\Validator\Constraints\Length::class, ['max'=>255])]
#[Field("url", \Atomino\Carbon\Field\StringField::class)]
abstract class _Event extends Entity {
	static null|Model $model = null;
	const allowedCategories = 'allowedCategories';
	public array $allowedCategories = [];
	const contactUrl = 'contactUrl';
	public string|null $contactUrl = null;
	const deadline = 'deadline';
	public \DateTime|null $deadline = null;
	const id = 'id';
	protected int|null $id = null;
	protected function getId():int|null{ return $this->id;}
	const location = 'location';
	public string|null $location = null;
	const name = 'name';
	public string|null $name = null;
	const organizer = 'organizer';
	public string|null $organizer = null;
	const privacyUrl = 'privacyUrl';
	public string|null $privacyUrl = null;
	const subtitle = 'subtitle';
	public string|null $subtitle = null;
	const termsUrl = 'termsUrl';
	public string|null $termsUrl = null;
	const time = 'time';
	public string|null $time = null;
	const title = 'title';
	public string|null $title = null;
	const url = 'url';
	public string|null $url = null;
}





