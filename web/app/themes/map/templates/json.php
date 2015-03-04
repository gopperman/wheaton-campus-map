<?php $output = array();
while (have_posts()) : the_post(); 
	$row = array(
		'title' => get_the_title(),
		'permalink' => get_the_permalink(),
		'tags' => get_the_tags(),
		'categories' => get_the_category()
	);
	$fields = get_fields();
	if ($fields) {
		foreach($fields as $field_name => $value) {
			$field = get_field_object($field_name, false, array('load_value' => false));
			$row[$field_name] = $value; 
		}
	}
	$output[] = $row;	
?>
<?php endwhile; ?>
<?= json_encode($output); ?>
