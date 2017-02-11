<?php
/*
 *	location: admin/controller
 */

class ControllerModuleDGeoByIp extends Controller {
	private $codename = 'd_geo_by_ip';
	private $id = 'd_geo_by_ip';
	private $route = 'module/d_geo_by_ip';
	private $sub_versions = array('lite', 'light', 'free');
	private $mbooth = '';
	private $config_file = '';
	private $prefix = '';
	private $store_id = 0;
	private $error = array(); 

	public function __construct($registry) {
		parent::__construct($registry);

		$this->d_shopunity = (file_exists(DIR_SYSTEM.'mbooth/extension/d_shopunity.json'));
		$this->extension = json_decode(file_get_contents(DIR_SYSTEM.'mbooth/extension/'.$this->codename.'.json'), true);
		$this->store_id = (isset($this->request->get['store_id'])) ? $this->request->get['store_id'] : 0;
		if(VERSION >= '2.3.0.0'){
			$this->route = 'extension/'.$this->route;
		}
	}

	public function required(){
		$this->load->language($this->route);

		$this->document->setTitle($this->language->get('heading_title_main'));
		$data['heading_title'] = $this->language->get('heading_title_main');
		$data['text_not_found'] = $this->language->get('text_not_found');
		$data['breadcrumbs'] = array();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->request->get['extension'] = $this->codename;
		if(VERSION >= '2.3.0.0'){
			$this->load->controller('extension/extension/module/uninstall');
		}else{
			$this->load->controller('extension/module/uninstall');
		}
		$this->response->setOutput($this->load->view('error/not_found.tpl', $data));
	}

	public function index(){
		if(!$this->d_shopunity){
			$this->response->redirect($this->url->link($this->route.'/required', 'codename=d_shopunity&token='.$this->session->data['token'], 'SSL'));
		}

		$this->load->model('d_shopunity/mbooth');
		$this->model_d_shopunity_mbooth->validateDependencies($this->codename);
		
		//dependencies
		$this->load->language($this->route);
		$this->load->model('module/d_geo_by_ip');
		$this->load->model('setting/setting');
		$this->load->model('extension/module');
		$this->load->model('d_shopunity/setting');
		
		//save post
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting($this->id, $this->request->post, $this->store_id);
			$this->session->data['success'] = $this->language->get('text_success');

			if(VERSION < '2.3.0.0') {
				$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . "&type=module", 'SSL'));
			}
			
		}

		// styles and scripts
		$this->document->addStyle('view/stylesheet/shopunity/bootstrap.css');
		$this->document->addStyle('view/stylesheet/d_geo_by_ip/style.css');
		
		// switch
		$this->document->addScript('view/javascript/shopunity/bootstrap-switch/bootstrap-switch.min.js');
		$this->document->addStyle('view/stylesheet/shopunity/bootstrap-switch/bootstrap-switch.css');

		// select2
		$this->document->addScript('view/javascript/d_geo_by_ip/select2/select2.min.js');
		$this->document->addStyle('view/stylesheet/d_geo_by_ip/select2/select2.css');

		// sweetalert
		$this->document->addScript('view/javascript/d_geo_by_ip/sweet_alert/sweetalert.min.js');
		$this->document->addStyle('view/stylesheet/d_geo_by_ip/sweet_alert/sweetalert.css');

		$url_params = array();
		$url = '';

		if(isset($this->response->get['store_id'])){
			$url_params['store_id'] = $this->store_id;
		}

		if(isset($this->response->get['config'])){
			$url_params['config'] = $this->response->get['config'];
		}

		// Breadcrumbs
		$data['breadcrumbs'] = array(); 
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
			);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => (VERSION < '2.3.0.0') ? $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL') : $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . "&type=module", 'SSL')
			);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title_main'),
			'href' => $this->url->link($this->route, 'token=' . $this->session->data['token'] . $url, 'SSL')
			);

		// Notification
		foreach($this->error as $key => $error){
			$data['error'][$key] = $error;
		}

		// Heading
		$this->document->setTitle($this->language->get('heading_title_main'));
		$data['heading_title'] = $this->language->get('heading_title_main');
		$data['text_edit'] = $this->language->get('text_edit');
		
		// Variable
		$data['id'] = $this->codename;
		$data['version'] = $this->extension['version'];
		$data['d_shopunity'] = $this->d_shopunity;
		$data['route'] = $this->route;
		$data['store_id'] = $this->store_id;
		$data['stores'] = $this->model_module_d_geo_by_ip->getStores();
		$data['mbooth'] = $this->mbooth;
		$data['config'] = $this->config_file;

		$data['token'] =  $this->session->data['token'];

		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_approved'] = $this->language->get('entry_approved');
		$data['entry_ip'] = $this->language->get('entry_ip');
		$data['entry_date_added'] = $this->language->get('entry_date_added');

		$data['button_approve'] = $this->language->get('button_approve');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_login'] = $this->language->get('button_login');
		$data['button_unlock'] = $this->language->get('button_unlock');

		// Tab
		$data['tab_setting'] = $this->language->get('tab_setting');

		// Button
		$data['button_save'] = $this->language->get('button_save');
		$data['button_save_and_stay'] = $this->language->get('button_save_and_stay');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_clear'] = $this->language->get('button_clear');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_remove'] = $this->language->get('button_remove');
		
		// Entry
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_config_files'] = $this->language->get('entry_config_files');
		$data['entry_select'] = $this->language->get('entry_select');
		$data['entry_text'] = $this->language->get('entry_text');
		$data['entry_radio'] = $this->language->get('entry_radio');
		$data['entry_checkbox'] = $this->language->get('entry_checkbox');
		$data['entry_color'] = $this->language->get('entry_color');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_textarea'] = $this->language->get('entry_textarea');

		// Text
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		//field
		$data['entry_field'] = $this->language->get('entry_field');
		$data['entry_type'] = $this->language->get('entry_type');
		$data['text_field_1'] = $this->language->get('text_field_1');
		$data['text_field_2'] = $this->language->get('text_field_2');
		$data['text_field_3'] = $this->language->get('text_field_3');

		//action
		$data['module_link'] = $this->url->link($this->route, 'token=' . $this->session->data['token'], 'SSL');
		$data['action'] = $this->url->link($this->route, 'token=' . $this->session->data['token'] . $url, 'SSL');
		if(VERSION < '2.3.0.0') {
			$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . "&type=module", 'SSL');
		}

		//debug
		$data['tab_debug'] = $this->language->get('tab_debug');
		$data['entry_debug'] = $this->language->get('entry_debug');
		$data['entry_debug_file'] = $this->language->get('entry_debug_file');
		$data['clear_debug_file'] = $this->model_module_d_geo_by_ip->ajax($this->url->link($this->route.'/clearDebugFile', 'token=' . $this->session->data['token'], 'SSL'));
		
		//support
		$data['tab_support'] = $this->language->get('tab_support');
		$data['text_support'] = $this->language->get('text_support');
		$data['entry_support'] = $this->language->get('entry_support');
		$data['button_support_email'] = $this->language->get('button_support_email');				
		
		//instruction
		$data['tab_instruction'] = $this->language->get('tab_instruction');
		$data['text_instruction'] = $this->language->get('text_instruction');


		if (isset($this->request->post[$this->id.'_status'])) {
			$data[$this->id.'_status'] = $this->request->post[$this->id.'_status'];
		} else {
			$data[$this->id.'_status'] = $this->config->get($this->id.'_status');
		}

		//get setting
		$data['setting'] = $this->model_module_d_geo_by_ip->getConfigData($this->id, $this->id.'_setting', $this->store_id, $this->config_file);

		//geolocation_service
		$data['geolocation_services']= array(
			'geoplugin.net',
			'ip-api.com',
			'freegeoip.net',
		);

		//debug
		if(isset($data['setting']['debug'])){
			//get debug file
			$data['debug_log'] = $this->model_module_d_geo_by_ip->getFileContents(DIR_LOGS.$data['setting']['debug_file']);
			$data['debug_file'] = $data['setting']['debug_file'];
		}
		
		//get config 
		$data['config_files'] = $this->model_module_d_geo_by_ip->getConfigFiles($this->id);

		// direction to function installRegionsBySelectCountry
		$data['install_regions_data'] = str_replace('&amp;', '&', $this->url->link($this->route.'/installRegionsBySelectCountry', 'token=' . $this->session->data['token'], 'SSL'));
		
		$this->load->model('setting/store');

   		//custom_code

		$this->load->model('localisation/country');
		$data['countries'] = $this->model_localisation_country->getCountries();


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/d_geo_by_ip.tpl', $data));
	}

	/*
	*	Если захочешь обновить регионы ВСЕХ СТРАН, Запускай http://YOUR_SITE/admin/index.php?route=module/d_geo_by_ip/ferma
	*	Но делай диапазон от 1 по 60, с 60 по 120. Всего 257 стран.
	*	После половины стран(125 примерно) пересоздай площадку на гугле и поменый KEY на 278 строке, потому что лимит на запросы.
	*/
	public function ferma() {
		for($i = 1; $i <= 60; $i++){
			$this->regions($i);
		}
	} 

	public function regions($c_id) {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($c_id);

		if($country_info) {
			$this->load->model('module/d_geo_by_ip');
			$this->load->model('localisation/zone');

			$zones = $this->model_localisation_zone->getZonesByCountryId($c_id);

			foreach ($zones as $zone) {
				set_time_limit(2000000000);
				$country_id = $zone['country_id'];
				$zone_id    = $zone['zone_id'];
				$zone_name  = $zone['name'];

				$result = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=" . urlencode($zone_name) . "&key=AIzaSyCoNkDlgIYq9hEblUcnLU9he7fdhEVrlhI");
				$result = json_decode($result, true);

				$data = array(
					'country_id'          => $country_id,
					'zone_id'             => $zone_id,
					'zone_name_by_oc'     => $zone_name,
					'zone_name_by_google' => $result['results']['0']['formatted_address'],
					'place_id' 			  => $result['results']['0']['place_id']
				);

				// insert $data into table - oc_geo_by_ip
				$this->model_module_d_geo_by_ip->setRegionsByCountry($data);
			}
		}
	}

	public function installRegionsBySelectCountry() {

		$key = 'AIzaSyCoNkDlgIYq9hEblUcnLU9he7fdhEVrlhI';

		if(isset($this->request->post['country_id'])) {
			$country_id = $this->request->post['country_id'];
		}

		$this->load->model('localisation/country');
		$country_info = $this->model_localisation_country->getCountry($country_id);

		$json = array();

		if(!$country_info){
			$json['error'] = 'Do not see the country';
		} else {
			$this->load->model('module/d_geo_by_ip');
			$this->load->model('localisation/zone');

			// delete rows of country($country_id)
			$this->model_module_d_geo_by_ip->deleteSelectCountry($country_id);

			// get all zones
			$regions = $this->model_localisation_zone->getZonesByCountryId($country_id);

			if(!$regions) {
				$json['error'] = 'Do not see the regions';
			} else {
				foreach ($regions as $region) {
					set_time_limit(200000);

					$data = array(
						'country_id'          => $region['country_id'],
						'zone_id'             => $region['zone_id'],
						'zone_name_by_oc'     => $region['name'],
						'zone_name_by_google' => '',
						'place_id'            => ''
					);

					$result = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=" . urlencode($data['zone_name_by_oc']) . "&key=".$key);
					$result = json_decode($result, true);

					if($result['status'] =='REQUEST_DENIED') {
						$json['error'] = $result['error_message'];

						$this->response->addHeader('Content-Type: application/json');
						$this->response->setOutput(json_encode($json));
						return;
					}

					if($result && $result['status'] != 'ZERO_RESULTS') {
						$data['zone_name_by_google'] = $result['results']['0']['formatted_address'];
						$data['place_id'] = $result['results']['0']['place_id'];
					}

					// insert country id, zone id and zone name into table - oc_geo_by_ip
					$this->model_module_d_geo_by_ip->setRegionsByCountry($data);
				}

				$json['success'] = 'success';
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}


	
	private function validate($permission = 'modify') {

		if (isset($this->request->post['config'])) {
			return false;
		}

		$this->language->load($this->route);
		
		if (!$this->user->hasPermission($permission, $this->route)) {
			$this->error['warning'] = $this->language->get('error_permission');
			return false;
		}

		if(empty($this->request->post[$this->id.'_setting']['geolocation_service'])){
			$this->error['geolocation_service'] = $this->language->get('error_select');
			return false;
		}

		return true;
	}

	public function install() {
		if($this->d_shopunity){
			$this->load->model('d_shopunity/vqmod');
			$this->load->model('module/d_geo_by_ip');
			$this->model_module_d_geo_by_ip->setVqmod('a_vqmod_d_geo_by_ip.xml', 1);

			$this->load->model('d_shopunity/mbooth');
			$this->model_d_shopunity_mbooth->installDependencies($this->codename);
			$this->model_module_d_geo_by_ip->installDatabase();
			$this->model_module_d_geo_by_ip->installData();
		}
	}

	public function uninstall() {
		if($this->d_shopunity) {
			$this->load->model('module/d_geo_by_ip');
			$this->model_module_d_geo_by_ip->setVqmod('a_vqmod_d_geo_by_ip.xml', 0);

			$this->model_module_d_geo_by_ip->uninstallDatabase();
		}
	}


	/*
	*	Ajax: clear debug file.
	*/

	public function clearDebugFile() {
		$this->load->language($this->route);
		$json = array();

		if (!$this->user->hasPermission('modify', $this->route)) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$file = DIR_LOGS.$this->request->post['debug_file'];

			$handle = fopen($file, 'w+');

			fclose($handle);

			$json['success'] = $this->language->get('success_clear_debug_file');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
?>