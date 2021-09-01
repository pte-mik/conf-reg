<?php namespace Application\Modules\Gold;

use Atomino\Neutrons\Attr;

#[\Attribute(\Attribute::TARGET_METHOD)]
class GoldSorting extends Attr implements \JsonSerializable {
	public function __construct(public string $name, public string $label, public \Closure|null $method = null) { }
	public function jsonSerialize() { return $this->label; }
}