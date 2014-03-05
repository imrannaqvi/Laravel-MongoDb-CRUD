<a href="<?php echo(URL::action('home'));?>">BACK</a>
<?php
if($message){
	echo('<br><br>'.$message);
}
?>
<h2><?php if(isset($heading)) echo($heading);?></h2>
<?php
//generate form html
echo(Form::open(array('method' => $form['method'])));
for($i=0; $i<count($form['elements']); $i++){
	$element = $form['elements'][$i];
	$value = null;
	if(array_key_exists('value', $element)){
		$value = $element['value'];
	}
	?><div><?php
		//generate label
		if(array_key_exists('label', $element)){
			echo(Form::label($element['name'], $element['label']));
		}
		//common attributes
		$attr = array(
			'id' => $element['name']
		);
		if(array_key_exists('attr', $element) && is_array($element['attr'])){
			$attr = array_merge((array) $attr, (array) $element['attr']);
		}
		//generate element
		if($element['type']=='text'){
			echo(Form::text($element['name'], $value, $attr));
		}elseif($element['type']=='checkbox'){
			echo(Form::checkbox($element['name'], 1, $value));
		}
	?></div><?php
}
echo(Form::submit('Submit!'));
echo(Form::close());
?>