<?php
class ControllerModuleDGeoByIp extends Controller {
	private $id = 'd_geo_by_ip';
	private $route = 'module/d_geo_by_ip';
	private $debug = false;

	public function index() {
		if($this->config->get('d_geo_by_ip_status')){  
			$this->load->model('module/d_geo_by_ip');
			$settings = $this->config->get('d_geo_by_ip_setting');

			$geoService = $settings['geolocation_service'];

			$ip = $this->getIp();

			if(!empty($ip)) {

				//data from geo service
				$geodata = $this->setServiceGeolocation($geoService, $ip);

				if($geodata) {
					$country_code = $geodata['country_code'];

					$countryData = $this->model_module_d_geo_by_ip->getCountryData($country_code);

					$countryData['region_name'] = isset($geodata['region_name']) ? $geodata['region_name'] : '';
					$countryData['lat'] = isset($geodata['lat']) ? $geodata['lat'] : '';
					$countryData['lng'] = isset($geodata['lng']) ? $geodata['lng'] : '';

					$dataFromGoogle = $this->getRegionByAddressOrByLatLng($countryData);

					$result = $this->searchMatches($dataFromGoogle, $countryData['country_id']);

					$data = array();
					if($result) {
						$data = array(
							'country_id' => $result['country_id'],
							'zone_id'    => $result['zone_id']
						) ;
					}

					return $data;
				}
			}
		}
	}

	public function getRegionByAddressOrByLatLng($geodata) {
		if(!empty($geodata['region_name'])) {
			$result = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=" . urlencode($geodata['region_name']) . "");
		} else if(!empty($geodata['lat']) && !empty($geodata['lng'])) {
			$result = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=" . $geodata['lat'] . "," . $geodata['lng'] . "");
		} else {
			return false;
		}

		$result = json_decode($result, true);

		if($result && $result['status'] != 'ZERO_RESULTS') {
			return $result;
		}

		return false;
	}

	public function searchMatches($datafromgoogle, $country_id) {
		if($datafromgoogle) {
			foreach ($datafromgoogle['results'] as $item) {
				$data[$item['place_id']] = array(
					'formatted_address' => $item['formatted_address'],
				);
			}

			return $result = $this->model_module_d_geo_by_ip->getMatchesByPlaceId($data, $country_id);
		}
	}

	public function getIp() {
		$ip = '';

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}

	public function setServiceGeolocation($service, $ip) {
		$method_name = $service;
		$method_name = str_replace('.','' , $method_name);

		return $this->load->controller('d_geo_by_ip/geoservices/'.$method_name,$ip);
	}
}