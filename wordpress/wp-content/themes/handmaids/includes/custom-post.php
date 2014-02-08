<?php 
/**
A class with static methods for accessing post types with custom extension fields. The extra
fields are expected to be stored in a db table with the name "custom_<name of class>". The class
passed as the first argument to the methods here are expected to contain static properties with
the names 'property_map' and 'post_type_name'.

The 'property_map' field should contain an associate array of class property names to their corresponding
db column names. The column names must be prefixed with "posts." for columns in the 
standard wp_posts table and "custom." for columns in the custom extension table. For exapmle,
if a class contains the regular field ID and a custom field named "my_field", then the property map should
look like this:

public static $property_map = array(
		'ID' => 'posts.ID',
		'my_field' => 'custom.my_field'
	);

The 'post_type_name' field should contain the name of the post_type that will identify this custom type.
For example, in order to extend the 'attachment' built-in WordPress type, you would add this to your class:

public static $post_type_name = 'attachment';
*/

class CustomPost {
	private static $DB_PREFIX = 'custom_'; 

	/**
	Same as find_all but only returns a single item. This overrides the any 'limit' value passed as
	an argument.
	*/
	public static function find($class, $args = array()){
		$result = self::exec($class, $args, 1);
		return array_shift($result);
	}
	
	/**
	Finds and returns an array with all objects that match the given criteria.
	
	Arguments:
	class [required] - the class name of the objects to return
	$args [optional] - an associate array with one or more of the following keys:
		where - an associative array with where entries. Each entry key is the name of the
			class property with the value being either
			an exact value to match or another array with the first entry being the comparative operator
			(eg '>', '<=') and the second the value to compare.
		order - an array of class properties to order by; or a single string property to order by
		asc - boolean indicating if the rows should be placed in ascending order. 
			The default is true.
		limit  - the maximum number of rows to return
	
	*/
	public static function find_all($class, $args = array()){
		return self::exec($class, $args, null);
	}
	
	/**
	Executes the query for the given arguments
	*/
	private static function exec($class, $args, $limit){
		//pull the property map as a static field of the class
		if (!property_exists($class, 'property_map')){
			throw new Exception("Class $class is missing required static property 'property_map'");
		}
		$prop_map = $class::$property_map;
		
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
		$query = self::create_query($class, $prop_map, $where, $order, $asc, $limit);
		
		//execute the query
		global $wpdb;
		$rows = $wpdb->get_results($query, ARRAY_A);
		
		return self::map_rows($class, $rows, $prop_map);
	}
	
	/**
	Creates an object of the given class and maps the row data to its properties
	*/
	private static function map_rows($class, $rows, $prop_map){
		$results = array();
		$props = array_keys($prop_map);
		
		foreach ($rows as $row){
				$obj = new $class;
				
				foreach ($props as $prop){
					$obj->$prop = $row[$prop];
				}
				
				array_push($results, $obj);
		}
		return $results;
	}

	/**
	Create the query
	*/
	private static function create_query($class, $prop_map, $where, $order, $asc, $limit){
		global $wpdb;
		
		$query = self::create_select_clause($prop_map);
		
		$custom_table = self::$DB_PREFIX . strtolower($class);
		$query .= " from $wpdb->posts posts left outer join $custom_table custom on posts.ID = custom.post_ID";
		
		//add the post_type filter 
		if (!property_exists($class, 'post_type_name')){
			throw new Exception("Class $class is missing required static property 'post_type_name'");
		} 
		$post_type_name = $class::$post_type_name;
		$query .=  ' ' . self::create_where_clause($prop_map, $post_type_name, $where);
		
		if ($order){
			$query .=  ' ' . self::create_orderby_clause($prop_map, $order, $asc);
		}
		
		if ($limit && is_numeric($limit)){
			$query .= " limit $limit"; 
		}
		
		return $query . ';';
	}
	
	/**
	Creates the select clause for the query.
	*/
	private static function create_select_clause($prop_map){
		$fields = array();
		foreach ($prop_map as $prop=>$col){
			array_push($fields, "$col as $prop");
		}
		
		return 'select ' . implode(', ', array_values($fields));
	}
	
	/**
	Creates the where clause for the query. All conditions are joined with AND.
	*/
	private static function create_where_clause($prop_map, $post_type_name, $where){
		$where_arr = array("posts.post_type = '$post_type_name'");
		
		if ($where){
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
				
				$where = "$column $comparator ";
				if (is_string($comparison_value)){
					$where .= "'$comparison_value'"; //quote value
				} else {
					$where .= "$comparison_value"; //do not quote value
				}
				
				array_push($where_arr, $where);
			}
		}
		
		return "where " . implode(' and ', $where_arr);
	}
	
	/**
	Creates the order by clause for the query
	*/
	private static function create_orderby_clause($prop_map, $order, $asc){
		$orderby_arr = array();

		if (is_string($order)){
			$order = array($order);
		}
		
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