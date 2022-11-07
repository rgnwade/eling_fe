<?php

namespace Modules\Shipping;
use Config;

class RajaOngkir {
	private $key;
	private $endpoint;

	public function __construct() {
        $this->key =  Config::get('app.RAJA_ONGKIR_KEY');
        $this->endpoint =  Config::get('app.RAJA_ONGKIR_URL');
	}

	public function getProvince($params=array()) {
		return $this->http('get','province',$params)->results;
	}

	public function getCity($params=array()) {
		return $this->http('get','city',$params)->results;
	}

    public function getDistrict($params=array()) {
		return $this->http('get','subdistrict',$params)->results;
	}

	public function getCost($params=array()) {
		return $this->http('post','cost',$params);
	}

    public function getResiInfo($params=array()) {
		return $this->http('post','waybill',$params)->result;
	}

	private function http($type,$path,$params){
		$client = new \GuzzleHttp\Client();
		$headers = array('headers'=>array('key'=>$this->key));
		if($type=='post'){
			$url = $this->endpoint.$path;
			$headers['form_params'] = $params;
			$response = $client->post($url,$headers);
		}
		else{
			$url = $this->endpoint.$path.$this->query($params);
			$response = $client->get($url,$headers);
		}
        return json_decode($response->getBody()->getContents())->rajaongkir;
	}

	private function query($params){
		return $query = is_array($params)?'?'.http_build_query($params):'';
	}
}
