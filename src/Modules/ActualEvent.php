<?php namespace Application\Modules;

use Application\Entity\Event;
use Atomino\Carbon\Database\Finder\Filter;

class ActualEvent {
	private static Event|null $actual = null;
	public static function set($domain) { static::$actual = Event::search(Filter::where(Event::url($domain)))->pick(); }
	public static function get(): Event|null { return self::$actual; }
}