<?php namespace Application\Missions\Gold\Api;

use Application\Entity\Event;
use Atomino\Gold\Gold;
use Atomino\Gold\GoldApi;
use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Carbon\Entity;

#[Gold(Event::class, 5, true)]
class EventApi extends GoldApi {
	protected function selectMap(Entity $item): string {
		/** @var Event $item */
		return $item->title;
	}
}
