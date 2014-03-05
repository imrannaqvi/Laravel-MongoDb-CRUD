<a href="<?php echo(URL::action('home_add'));?>">ADD NEW</a>
<table border="1">
<tr>
	<th>UID</th>
	<th>networks:id</th>
	<th>networks:name</th>
	<th>networks:ip</th>
	<th>networks:status</th>
	<th>hostnames:name</th>
	<th>hostnames:block</th>
	<th>EDIT</th>
	<th>DELETE</th>
</tr>
<?php
if(count($rd)==0){
	?><tr><td colspan="9" align="center">No Documents Found.</td></tr><?php
}
for($i=0; $i<count($rd); $i++){
	?><tr>
		<td><?php
			if(array_key_exists('uid', $rd[$i])){
				echo($rd[$i]['uid']);
			}
		?></td><td><?php
			if(array_key_exists('networks', $rd[$i]) && array_key_exists('nid', $rd[$i]['networks'])){
				print_r($rd[$i]['networks']['nid']);
			}
		?></td><td><?php
			if(array_key_exists('networks', $rd[$i]) && array_key_exists('n_name', $rd[$i]['networks'])){
				echo($rd[$i]['networks']['n_name']);
			}
		?></td><td><?php
			if(array_key_exists('networks', $rd[$i]) && array_key_exists('n_ip', $rd[$i]['networks'])){
				echo($rd[$i]['networks']['n_ip']);
			}
		?></td><td><?php
			if(array_key_exists('networks', $rd[$i]) && array_key_exists('n_status', $rd[$i]['networks'])){
				echo($rd[$i]['networks']['n_status']);
			}
		?></td><td><?php
			if(array_key_exists('hostnames', $rd[$i]) && array_key_exists('hostname', $rd[$i]['hostnames'])){
				echo($rd[$i]['hostnames']['hostname']);
			}
		?></td><?php
		?><td><?php
			if(array_key_exists('hostnames', $rd[$i]) && array_key_exists('block', $rd[$i]['hostnames'])){
				echo($rd[$i]['hostnames']['block']);
			}
		?></td>
		<td><a href="<?php echo(URL::action('home_edit', array($rd[$i]['_id']))); ?>">EDIT</td>
		<td><a href="<?php echo(URL::action('home_delete', array($rd[$i]['_id']))); ?>">DELETE</td>
	</tr><?php
}
?>
</table>