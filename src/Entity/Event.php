<?php namespace Application\Entity;

use Atomino\Carbon\Attributes\BelongsTo;
use Atomino\Carbon\Attributes\Modelify;
use Application\Atoms\Entity\_Event;

#[Modelify(\Application\Database\DefaultConnection::class, 'event', true)]
#[BelongsTo('organizer', User::class, 'organizerId')]
class Event extends _Event{

}