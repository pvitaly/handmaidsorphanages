<?php

/**
Class with helper methods for working with Pods objects.
*/
class PodsHelper {

	/**
	Returns a single object of the given type matching the parameters or null if not found.
	*/
	public static function find_one($class, $params){
		if (!isset($params )){
				$params = array();
		} 
		
		$params['limit'] = 1;
		
		$results = self::find($class, $params);
		
		return array_shift($results);
	}

	/**
	Returns all objects of the given type matching the parameters.
	*/
	public static function find($class, $params){
		if (!property_exists($class, 'PODS_NAME')){
			throw new Exception("Class $class is missing required static property 'PODS_NAME'");
		} 
	
		$name = $class::$PODS_NAME;
		
		$pods = pods($name);
		
		$pods->find($params);
		
		return self::convert_to_type($class, $pods);
	}

	/**
	Reads the data from the pods object and creates an array of objects of the given type.
	*/
	public static function convert_to_type($class, $pods){
		$result = array();
		
		$pods->reset();
		
		if ($pods->total() > 0){
		
			$props = array_keys(get_object_vars(new $class)) ;

			while ($pods->fetch()) {
			
				$obj = new $class;
			
				foreach ($props as $prop){
					$obj->$prop = $pods->field($prop);
				}
				
				$result[] = $obj;
				
				$obj = new $class;
			}
		}
		
		
		return $result;
	}
}
