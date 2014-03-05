<?php
class DataSetController extends BaseController {
	
	public $form = array(
		'method' => 'POST',
		'elements' =>array(
			array(
				'type' => 'text',
				'name' => 'uid',
				'label' => 'UID',
				'attr' => array(
					'required' => true
				)
			),
			array(
				'type' => 'text',
				'name' => 'networks[nid]',
				'label' => 'Network ID',
				'attr' => array(
					'required' => true
				)
			),
			array(
				'type' => 'text',
				'name' => 'networks[n_name]',
				'label' => 'Network Name',
				'attr' => array(
					'required' => true
				)
			),
			array(
				'type' => 'text',
				'name' => 'networks[n_ip]',
				'label' => 'Network IP',
				'attr' => array(
					'required' => true
				)
			),
			array(
				'type' => 'checkbox',
				'name' => 'networks[n_status]',
				'label' => 'Network Status'
			),
			array(
				'type' => 'text',
				'name' => 'hostnames[hostname]',
				'label' => 'Hostname',
				'attr' => array(
					'required' => true
				)
			),
			array(
				'type' => 'checkbox',
				'name' => 'hostnames[block]',
				'label' => 'Hostname Blocked'
			)
		)
	);
	
	public function index()
	{
		$dsc = new DataSetCollection();
		/*echo('<pre>');
		$data = array(
			'uid' => 123 ,
			'networks' => array(
				'nid' => 1,
				'n_name' => 'network name',
				'n_ip' => 'network ip',
				'n_status' => true
			),
			'hostnames' => array(
				'hostname' => 'hostname',
				'block' => false
			)
		);
		print_r($dsc->insert($data));*/
		$rd = DB::collection($dsc->getTable())->get();
		//print_r($dsc->get());
		//die();
		return View::make('dataset/index', array(
			'rd' => $rd
		));
	}
	
	public function add()
	{
		$message = false;
		$ds_collection = new DataSetCollection();
		if (Request::isMethod('post')){
			$post = Input::get();
			//remove csrf token
			if(array_key_exists('_token', $post)){
				unset($post['_token']);
			}
			//TODO: this should be in form class
			//check for checkboxes
			if(array_key_exists('n_status', $post['networks'])){
				$post['networks']['n_status'] = true;
			}else{
				$post['networks']['n_status'] = false;
			}
			if(array_key_exists('block', $post['hostnames'])){
				$post['hostnames']['block'] = true;
			}else{
				$post['hostnames']['block'] = false;
			}
			if($ds_collection->insert($post)){
				$message = '<b>Inserted Successfully.</b>';
			}
		}
		//view
		return View::make('dataset/form', array(
			'heading' => 'Add New Network',
			'form' => $this->form,
			'message' => $message
		));
	}
	
	public function edit($id)
	{
		$ds_collection = new DataSetCollection();
		$doc = $ds_collection->find($id);
		$message = false;
		if (Request::isMethod('post')){
			$post = Input::get();
			//remove csrf token
			if(array_key_exists('_token', $post)){
				unset($post['_token']);
			}
			//TODO: this should be in form class
			//check for checkboxes
			if(array_key_exists('n_status', $post['networks'])){
				$post['networks']['n_status'] = true;
			}else{
				$post['networks']['n_status'] = false;
			}
			if(array_key_exists('block', $post['hostnames'])){
				$post['hostnames']['block'] = true;
			}else{
				$post['hostnames']['block'] = false;
			}
			Eloquent::unguard();
			if($doc->update($post)){
				$updated = true;
				$message = '<b>Updated Successfully.</b>';
			}
			$doc = $ds_collection->find($id);
		}
		//view
		return View::make('dataset/form', array(
			'heading' => 'Edit Network',
			'form' => $this->setFormData($this->form, $doc->getAttributes()),
			'message' => $message
		));
	}
	
	public function delete($id)
	{
		$ds_collection = new DataSetCollection();
		$doc = $ds_collection->find($id);
		if($doc){
			$doc->delete();
		}
		return Redirect::route('home');
	}
	
	public function setFormData($form, $data)
	{
		if(
			//if form has elements
			array_key_exists('elements', $form) && 
			is_array($form['elements']) &&
			// and there is some data
			is_array($data)
		){
			for($i=0; $i<count($form['elements']); $i++){
				$element = $form['elements'][$i];
				//if name attribute exists
				if(array_key_exists('name', $element)){
					$name_map = explode('[',$element['name']);
					//clean name map
					for($j=0; $j<count($name_map); $j++){
						$name_map[$j] = rtrim(trim($name_map[$j]), ']');
					}
					//now find value
					$found_value = 0;
					$value = $data;
					for($j=0; $j<count($name_map); $j++){
						if(is_array($value) && array_key_exists($name_map[$j], $value)){
							$value = $value[$name_map[$j]];
							$found_value++;
						}else{
							break;
						}
					}
					if($found_value!==count($name_map)){
						$value =  null;
					}
					$element['value'] = $value;
					$form['elements'][$i] = $element;
				}
			}
		}
		return $form;
	}
}