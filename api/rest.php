<?php

Class SimpleRest{
	
	private $httpVersion = "HTTP/1.1";
    private $orderURL = "http://www.route4me.com/api.v4/order.php";

	public function getVendors($filters=array()){
		$args = $response = array();

		if (isset($filters['size'])) {
			$size = $filters['size'];
			if($size !== 'global' && $size !== 'regional' && $size !== 'local'){
				$response['errors'][] = 'Incorrect Size';
			}
			$args['size'] = $size;
		}
        if(isset($filters['is_integrated'])){
            $integrated = $filters['is_integrated'];
            if($integrated !== '1' && $integrated !== '0'){
                $response['errors'][] = 'Incorrect is_integrated value';
            }
            $args['is_integrated'] = $integrated;
        }
		if (isset($filters['feature'])) {
            $features = r4me_get_features();
            $feature = $filters['feature'];
            if(!r4me_search_array($feature, $features)){
                $response['errors'][] = 'There is no such feature';
            }
			$args['feature'] = $feature;
		}
        if(isset($filters['country'])){
            $countries = r4me_get_countries();
            $country = strtoupper($filters['country']);
            if(!r4me_search_array($country, $countries)){
                $response['errors'][] = 'There is no such country';
            }
            $args['country'] = $country;
        }   
        if(isset($filters['search'])){
            $args['search'] = r4me_param_encode($filters['search']);
        }
        if(isset($filters['page']) && is_numeric($filters['page'])){
            $args['page'] = $filters['page'];
        }else{
            $args['page'] = 1;
        }
        if(isset($filters['per_page']) && is_numeric($filters['per_page'])){
            $args['per_page'] = $filters['per_page'];
        }else{
            $args['per_page'] = 48;
        }


        if(empty($response['errors'])){
            $query = new R4Me_Query($args);
            if($query->has_vendors()):
                while($row = $query->get_vendors()): 
                    unset($row['description']);
                    $response['vendors'][] = $row;
                endwhile;
            endif;
        }
            
        return $response;
	}

    public function getVendor($id){
        $response = array();

        if(!is_numeric($id)){
            $response['errors'][] = 'Incorrect vendor ID';
            return $response;
        }

        $args = array('vendor_id' => $id);

        $query = new R4ME_Query($args);

        if($query->has_vendors()):
        while($row = $query->get_vendors()): 
            $countries = r4me_get_vendor_country($row['id']);
            $features = r4me_get_vendor_feature($row['id']);
        
            $response['vendor'] = $row;
            $response['vendor']['features'] = $features;
            $response['vendor']['countries'] = $countries;

        endwhile; endif;

        return $response;
    } 

	public function setHttpHeaders($statusCode){
		$statusMessage = $this->getHttpStatusMessage($statusCode);
		header($this->httpVersion." ".$statusCode ." ".$statusMessage);
		header("Content-Type: application/json");
	}

	public function getHttpStatusMessage($statusCode){
		$httpStatus = array(
    		100 => 'Continue',
    		101 => 'Switching Protocols',
    		102 => 'Processing',
    		200 => 'OK',
    		201 => 'Created',
    		202 => 'Accepted',
    		203 => 'Non-Authoritative Information',
    		204 => 'No Content',
    		205 => 'Reset Content',
    		206 => 'Partial Content',
    		207 => 'Multi-Status',
    		300 => 'Multiple Choices',
    		301 => 'Moved Permanently',
    		302 => 'Found',
    		303 => 'See Other',
    		304 => 'Not Modified',
    		305 => 'Use Proxy',
    		306 => 'Switch Proxy',
    		307 => 'Temporary Redirect',
    		400 => 'Bad Request',
    		401 => 'Unauthorized',
    		402 => 'Payment Required',
    		403 => 'Forbidden',
    		404 => 'Not Found',
    		405 => 'Method Not Allowed',
    		406 => 'Not Acceptable',
    		407 => 'Proxy Authentication Required',
    		408 => 'Request Timeout',
    		409 => 'Conflict',
    		410 => 'Gone',
    		411 => 'Length Required',
    		412 => 'Precondition Failed',
    		413 => 'Request Entity Too Large',
    		414 => 'Request-URI Too Long',
    		415 => 'Unsupported Media Type',
    		416 => 'Requested Range Not Satisfiable',
    		417 => 'Expectation Failed',
    		418 => 'I\'m a teapot',
    		422 => 'Unprocessable Entity',
    		423 => 'Locked',
    		424 => 'Failed Dependency',
    		425 => 'Unordered Collection',
    		426 => 'Upgrade Required',
    		449 => 'Retry With',
    		450 => 'Blocked by Windows Parental Controls',
    		500 => 'Internal Server Error',
    		501 => 'Not Implemented',
    		502 => 'Bad Gateway',
    		503 => 'Service Unavailable',
    		504 => 'Gateway Timeout',
    		505 => 'HTTP Version Not Supported',
    		506 => 'Variant Also Negotiates',
    		507 => 'Insufficient Storage',
    		509 => 'Bandwidth Limit Exceeded',
    		510 => 'Not Extended'
		);
		
		return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $httpStatus[500];
	}


    public function isValidKey($api_key){

        $data = array(
            'api_key' => $api_key
        );
        
        $response = $this->curlHttpGetRequest($this->orderURL, $data);
        
        $response = json_decode($response);

        if (isset($response->results)) return true;
        
        return false;
    }


    private function curlHttpGetRequest($url, $query = ''){
        
        $url = $url . '?' . http_build_query($query);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $errno    = curl_errno($ch);
        $error    = curl_error($ch);
        curl_close($ch);
        
        if ($errno)
            throw new R4MeCurlException($error, $errno);
        
        return $response;
    }
}