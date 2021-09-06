<?php namespace Application\Missions\Gold\Api;

use Application\Entity\Event;
use Atomino\Gold\Gold;
use Atomino\Gold\GoldApi;
use Atomino\Carbon\Database\Finder\Filter;
use Atomino\Carbon\Entity;

#[Gold(Event::class, 5, true)]
class EventApi extends GoldApi {

	protected function selectFilter(string $search):Filter|null{
		return Filter::where(Event::name()->instring($search));
	}
	/**
	 * @param Event $item
	 * @return array
	 */
	protected function selectMap(Entity $item){
		return $item->name;
	}
}
