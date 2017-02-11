<?php
class ControllerDGeoByIpGeoservices extends Controller
{
	public function geopluginnet($ip) {
		$geo_data = @file_get_contents("http://geoplugin.net/json.gp?ip={$ip}");
		$geo_data = json_decode($geo_data, true);

		//return $geo_data; //-> you can get everything data

		// checking connect to geoplugin.net
		if ($geo_data) {

			$geo_data_req = array(
				'city' => $geo_data['geoplugin_city'],
				'region_name' => $geo_data['geoplugin_region'],
				'country_name' => $geo_data['geoplugin_countryName'],
				'country_code' => $geo_data['geoplugin_countryCode'],
				'lat' => $geo_data['geoplugin_latitude'],
				'lng' => $geo_data['geoplugin_longitude']
			);

			return array_filter($geo_data_req);
		} else {
			return false;
		}
	}

	public function ipapicom($ip) {
		// get evrything from ipinfo.io
		$geo_data = @file_get_contents("http://ip-api.com/json/{$ip}");

		// json decode
		$geo_data =  json_decode($geo_data, true);

		//return $geo_data; //-> you can get everything data

		// checking connect to ipinfo.io
		if($geo_data) {
			// required rows from ipinfo.io
			$geo_data_req = array(
				'city' 			=> isset($geo_data['city']) ? $geo_data['city'] : '',
				'region_name' 	=> isset($geo_data['regionName']) ? $geo_data['regionName'] : '',
				'country_name'  => isset($geo_data['country']) ? $geo_data['country'] : '',
				'country_code'  => isset($geo_data['countryCode']) ? $geo_data['countryCode'] : '',
				'lat' => isset($geo_data['lat']) ? $geo_data['lat'] : '',
				'lng' => isset($geo_data['lon']) ? $geo_data['lon'] : '',
			);

			return array_filter($geo_data_req);
		}
		else {
			return false;
		}
	}

	public function freegeoipnet($ip) {
		// get evrything from freegeoip.net
		$geo_data = @file_get_contents("http://freegeoip.net/json/{$ip}");

		// json decode
		$geo_data =  json_decode($geo_data, true);

		//return $geo_data -> you can get everything data

		// checking connect to freegeoip.net
		if($geo_data) {
			// required rows from freegeoip.net
			$geo_data_req = array(
				'city' 			=> $geo_data['city'],
				'region_name' 	=> $geo_data['region_name'],
				'country_name'  => $geo_data['country_name'],
				'country_code'  => $geo_data['country_code'],
			);

			return array_filter($geo_data_req);
		}
		else {
			return false;
		}
	}
}