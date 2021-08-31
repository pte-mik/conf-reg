<?php namespace Application\Modules\Gold;

use Atomino\Neutrons\Attr;

#[\Attribute(\Attribute::TARGET_METHOD)]
class GoldView extends Attr implements \JsonSerializable {
	public string $method;
	public function __construct(public string $name, public string $label) { }
	public function jsonSerialize() { return $this->label; }
}