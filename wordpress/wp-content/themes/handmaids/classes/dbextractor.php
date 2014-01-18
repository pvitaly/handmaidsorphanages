<?php
/**
Class with static methods for extracting simple, single-table objects from
the database.
*/

class DBExtractor {

	/**
	Same as findAll but only returns a single item. This overrides the any 'limit' value passed as
	an argument.
	*/
	public static function find($args){
		return array_shift(self::exec($args, 1));
	}
	
	/**
	Finds and returns all objects that match the given criteria.
	$args must be an associate array with the following keys:
		class [required] - the name of the class to return
		table [requried] - the name of the table where the object is stored
		prop_map [optional] - an associate array from class properties to db columns. If not provided,
			this map is created using get_class_vars() on the given class and assuming that
			as properties have the same names as their corresponding db columns
		where [optional] - an associative array with where entries. Each entry key is the name of the
			class property or db column (property name is checked first) with the value being either
			an exact value to match or another array with the first entry being the comparative operator
			(eg '>', '<=') and the second the value to compare.
		order [optional] - an array of class properties or db columns (property name is
			checked first) to order by
		asc [optional] - boolean indicating if the rows should be placed in ascending order. 
			The default is true.
		limit [optional] - the maximum number of rows to return
	
	*/
	public static function find_all($args){
		return self::exec($args, null);
	}
	
	/**
	Executes the query for the given arguments
	*/
	private static function exec($args, $limit){
		//pull out the arguments
		$class = $args['class'];
		$table = $args['table'];
		
		//create a property map if we weren't given one
		if (!array_key_exists('prop_map', $args)){
			$prop_map = get_class_vars($class);
			foreach ($prop_map as $var_name => $var_val){
				$prop_map[$var_name] = $var_name;
			}
		} else {
			$prop_map = $args['prop_map'];
		}
		
		$where = self::arr_get($args, 'where');
		$order = self::arr_get($args, 'order');
		
		$asc = true;
		if (array_key_exists('asc', $args)){
			$asc = $args['asc'];
		}
	
		if (!$limit){
			$limit = self::arr_get($args, 'limit');
		}
		
		//create the query
		$query = self::create_query($prop_map, $table, $where, $order, $asc, $limit);
		
		//execute the query
		global $wpdb;
		$rows = $wpdb->get_results($query, ARRAY_A);
		
		//create one object for each row
		$results = array();
		foreach ($rows as $row){
			array_push($results, self::map_row($class, $row, $prop_map));
		}
		
		return $results;
	}
	
	/**
	Creates an object of the given class and maps the row data to its properties
	*/
	private static function map_row($class, $row, $prop_map){
		$obj = new $class;
		
		foreach ($prop_map as $prop => $col){
			$obj->$prop = $row[$col];
		}
		return $obj;
	}

	/**
	Create the query
	*/
	private static function create_query($prop_map, $table, $where, $order, $asc, $limit){
		$query = self::create_select_clause($prop_map);
		
		$query .= " from $table";
		
		if ($where){
			$query .=  ' ' . self::create_where_clause($prop_map, $where);
		}
		
		if ($order){
			$query .=  ' ' . self::create_orderby_clause($prop_map, $order, $asc);
		}
		
		if ($limit){
			$query .= " limit $limit"; 
		}
		
		return $query . ';';
	}
	
	/**
	Create the select clause for the query
	*/
	private static function create_select_clause($prop_map){
		return 'select ' . implode(', ', array_values($prop_map));
	}
	
	/**
	Creates the where clause for the query
	*/
	private static function create_where_clause($prop_map, $where){
		//if this is a string, then return it as-is
		if (is_string($where)){
			return "where $where";
		}
		
		//no arguments means no where clause
		if (!$where || !is_array($where)){
			return '';
		}
		
		//we do have arguments, so create the where clause; all fields are joined with AND
		$where_arr = array();
		
		foreach ($where as $key => $val){
			//look up the column for this property
			$column = self::column($prop_map, $key);
			
			//create variables for the comparison operation
			$comparator = '=';
			$comparison_value = $val;
			
			//if the value is an array, take the first arg as a comparator and the second 
			//as the object for comparison
			if (is_array($val)){
				$comparator = $val[0];
				$comparison_value = $val[1];
			}
			
			//add the where section
			$where = "$column $comparator ";
			if (is_string($val)){
				$where .= "'$comparison_value'"; //quote value
			} else {
				$where .= "$comparison_value"; //do not quote value
			}
			
			array_push($where_arr, $where);
		}
		
		//return all where clauses joined with AND
		return 'where ' . implode(' and ', $where_arr);
	}
	
	/**
	Creates the order by clause for the query
	*/
	private static function create_orderby_clause($prop_map, $order, $asc){
		//if this is a string, then return it unmodified
		if (is_string($order)){
			$column = self::column($prop_map, $order);
			return "order by $column" . ($asc? ' ASC' : ' DESC');
		}
		
		//no arguments
		if (!$order || !is_array($order)){
			return '';
		}
		
		$orderby_arr = array();

		foreach ($order as $val){
			array_push($orderby_arr, self::column($prop_map, $val));
		}
		
		return 'order by ' . implode (', ', $orderby_arr) . ($asc? ' ASC' : ' DESC'); 
	} 
	
	/**
	Returns the column for the given name. If the name is found in the property map,
	then the mapped value is returned. Otherwise, the name is returned unchanged.
	*/
	private static function column($prop_map, $name){
		return array_key_exists($name, $prop_map) ? $prop_map[$name] : $name;
	}
	
	/**
	Helper method for getting a value from an array. If the key doesn't exist, null is returned.
	*/
	private static function arr_get($map, $name){
		return array_key_exists($name, $map) ? $map[$name] : null;
	}
}

?>