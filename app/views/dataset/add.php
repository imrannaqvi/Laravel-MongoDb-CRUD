<a href="<?php echo(URL::action('home'));?>">BACK</a>
<h2>Add New Network</h2>
<?php
echo(Form::open(array('method' => $form['method'])));
for($i=0; $i<count($form['elements']); $i++){
	$element = $form['elements'][$i];
	?><div><?php
		//generate label
		if(array_key_exists('label', $element)){
			echo Form::label($element['name'], $element['label']);
		}
		//generate element
		if($element['type']=='text'){
			$attr = array( 'id' => $element['name'] );
			if(array_key_exists('attr', $element) && is_array($element['attr'])){
				$attr = array_merge((array) $attr, (array) $element['attr']);
			}
			echo(Form::text($element['name'], null, $attr));
		}elseif($element['type']=='checkbox'){
			echo(Form::checkbox($element['name'], 1));
		}
	?></div><?php
}
echo(Form::submit('Submit!'));
echo(Form::close());
?>