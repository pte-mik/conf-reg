<?php namespace Application\Entity;

use Atomino\Carbon\Attributes\Modelify;
use Application\Atoms\Entity\_Participation;

#[Modelify(\Application\Database\DefaultConnection::class, 'participation', true)]
class Participation extends _Participation{

}