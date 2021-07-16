<?php namespace Application\Services;

use Application\Entity\Event;
use Atomino\Carbon\Database\Finder\Filter;

class ActualEventService {
	private Event|null $actual = null;
	public function set($domain) { $this->actual = Event::search(Filter::where(Event::url($domain)))->pick(); }
	public function get(): Event|null { return $this->actual; }
}