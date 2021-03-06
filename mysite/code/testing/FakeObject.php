<?php
/**
 * Simple key/value map with defaults support.
 */
class FakeObject extends ArrayObject {
	public $dateTimeService;

	function __construct($data = null, $flags = ArrayObject::ARRAY_AS_PROPS, $iteratorClass = 'ArrayIterator') {
		$this->dateTimeService = Injector::inst()->get('DateTimeService');

		if(!$data) $data = array();
		parent::__construct($data, $flags, $iteratorClass);

		foreach($this->getDefaults() as $k => $v) {
			if(!isset($this[$k])) $this[$k] = $v;
		}
	}
	
	public function getDefaults() {
		return array();
	}
	
	/**
	 * Serialize object and contained objects an array,
	 * in a format with "_type" hints, useful for later restoring
	 * through {@link create_from_array()}.
	 * 
	 * @see http://stackoverflow.com/questions/6836592/serializing-php-object-to-json
	 * @return Array
	 */
	public function toArray() {
		$array = (array)$this;
		$array['_type'] = get_class($this);
		array_walk_recursive($array, function(&$property, $key){
			if($property instanceof FakeObject){
				$property = $property->toArray();
			}
		});
		return $array;
	}

	/**
	 * Create nested object representation from array,
	 * based on "_type" hints.
	 *
	 * @param Array
	 * @return FakeObject
	 */
	public static function create_from_array($array) {
		// array_walk_recursive doesn't recurse into arrays...
		foreach($array as &$v) {
			// Convert "has one" relations
			if(is_array($v)) {
				$v = FakeObject::create_from_array($v);
			} 
			// Convert "has many" relations
			elseif(is_array($v)) {
				foreach($v as &$v1) {
					if(is_array($v1)) {
						$v1 = FakeObject::create_from_array($v1);
					}
				}
			}
		}
		
		$class = (isset($array['_type'])) ? $array['_type'] : 'FakeObject';
		unset($array['_type']);

		return new $class($array);
	}
	
}