<?php
class ModelModuleDGeoByIp extends Model {
	public function getCountryData($iso_code_2) {
		$country_data = $this->cache->get('country.' . $iso_code_2);
		
		if(!$country_data) {
			$query = $this->db->query("SELECT country_id, name, iso_code_2  FROM " . DB_PREFIX . "country WHERE iso_code_2 = '" . $iso_code_2 . "'");

			$country_data =  $query->row;

			$this->cache->set('country.' . $iso_code_2, $country_data);
		}

		return $country_data;
	}

	public function getMatchesByPlaceId($data, $country_id) {
		$data = "'" . implode("', '", array_keys($data)) . "'";

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_by_ip WHERE country_id='" . (int)$country_id . "' AND place_id IN(" . $data . ")");

		return $query->row;
	}
}