<?php

// if the 'term' variable is not sent with the request, exit
if ( !isset($_REQUEST['term']) )
	exit;
 
// connect to the database server and select the appropriate database for use
/*$dblink = mysql_connect('server', 'username', 'password') or die( mysql_error() );
mysql_select_db('database_name');
*/
 
// query the database table for zip codes that match 'term'
//$forms = dbFetchRows("SELECT id, name FROM Form where name LIKE '%". mysql_real_escape_string($_REQUEST['term']) ."%' ORDER BY name ASC limit 0, 10");
$results = array(
	array(
		'id' => 1,
		'name' => 'Steve Wu'
	),
	array(
		'id' => 2,
		'name' => 'Jackie Chan'
	),
	array(
		'id' => 3,
		'name' => 'Jet Li'
	),
);

 
// loop through each zipcode returned and format the response for jQuery
$data = array();

if (count($forms)) {
	foreach ($results as $result) {
		$data[] = array(
			'label' => $result['id'] . ' - ' . $result['name'],
			'value' => $result['name']
		);
	}
}

// jQuery wants JSON data
echo json_encode($data);
flush();