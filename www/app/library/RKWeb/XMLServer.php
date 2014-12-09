<?php
/*

Класс для общения с XML сервером под управлением RKeeper 7
Отправляем запросы - получаем ответы

*/
namespace RKWeb;


class XMLServer {

	private $_=array();
	private $_MENU=array();
	private $MegaCurl;


	public function __construct($_) {
		$this->_=$_;
		$this->MegaCurl = new \MegaCurl\MegaCurl();
		return $this;
	}


	public function request($xml_request) {

		$result = $this->MegaCurl->setRequestUrl($this->_['url'])
		->setOptions(array(
			'HEADER'=>1,
			'HTTPHEADER'=>  array(
				'Content-Type: application/xml', 
				'Content-Length: '.strlen($xml_request)
				),
			'POSTFIELDS'=>$xml_request,
			'TIMEOUT'=>CURL_TIMEOUT,
			'CONNECTTIMEOUT'=>CURL_TIMEOUT,
			'SSL_VERIFYHOST'=>false,
			'SSL_VERIFYPEER'=>false,
			'RETURNTRANSFER'=>true,
			'USERPWD' =>$this->_['login'].':'.$this->_['password']
			))
		->setHttpMethod('get')
		->execute();

// print_r($result);

// получаем ответ
		if ($result) {
// разбираем ответ на header и body

			list($header,$body)= explode(SPLIT_RESPONSE_BY, $result, 2);
			$header=trim($header);
			$body=trim($body);

// проверяем правильность ответа - header должен выдавать "200 OK", а body содержать xml
			if ($header&&$body) {
		// print_r($header);
		// print_r($body);

				return $body;
			} else {
				if ($header) {

				} else  {
					throw new \Exception('[RK-XML-SERVER] Incorrect response (not xml)');
				}
			}

		} else {
	// не удалось получить ответ
			throw new \Exception('CurlNoResponse');
		}

	}



public function getMenu() {

// выполняем запрос к серверу и получаем ответ в виде RK XML
    	$XML=$this->request(RK_XML_REQUEST_GET_MENU);

    	if ($XML) {
    		$_TMP=$_MENU=$_PRICES=array();
    		$xml_parser = xml_parser_create();
    		xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, 0);
    		xml_parse_into_struct($xml_parser, $XML, $_TMP);
    		xml_parser_free($xml_parser);


    		if ($_TMP) {
// парсим меню - потом выносим разпрсивание разныхз ответов в отдельные ф-ии
    			foreach ($_TMP as $k => $_v) {
    				if ($_v['tag']=='Item' && isset($_v['attributes']['Ident']) && isset($_v['attributes']['CategPath'])) {
/*    					$_tmp=explode('\\', $_v['attributes']['CategPath']);
    					$obj_key=$_tmp[0];
    					if ($_tmp[1]) {
    						$obj_key=$_tmp[1];
    					}*/
/*
    					$_MENU[$_v['attributes']['Ident']]=array(
    						'Ident'=>$_v['attributes']['Ident'], 
    						'Name'=>$_v['attributes']['Name'], 
    						'AltName'=>$_v['attributes']['AltName'], 
    						'Code'=>$_v['attributes']['Code'], 
    						'CategPath'=>$_v['attributes']['CategPath'], 
    						'LargeImagePath'=>$_v['attributes']['LargeImagePath']
    						);*/

    					$_MENU[$_v['attributes']['Ident']]=$_v['attributes'];


    				}
    			}

    			$_TMP=array();

    			if ($_MENU) {
    				// print_r($_MENU);
    				$prices_flag=false;
    				// берём цены
    				$XML=$this->request(RK_XML_REQUEST_GET_PRICES);
    				$xml_parser = xml_parser_create();
    				xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, 0);
    				xml_parse_into_struct($xml_parser, $XML, $_TMP);
    				xml_parser_free($xml_parser);

    				if ($_TMP) {
/*
TODO: разобраться что делать с модифайерами - типа +лайм для коктейля или +ингридиент к пицце
 					print_r($_TMP);
    					die;
*/
    					foreach ($_TMP as $k => $_v) {
    						if ($_v['tag']=='Item' && isset($_v['attributes']['Ident']) && isset($_v['attributes']['Price'])) {
    							// проверяем есть ли позиция в меню - в прайс выдаче могут быть страые косые значения старых цен
    							if (isset($_MENU[$_v['attributes']['Ident']])) {
    								$_MENU[$_v['attributes']['Ident']]['Price']=$_v['attributes']['Price'];
    								$prices_flag=true;
    							}
    						}
    					}

    					if ($prices_flag) {
    						$this->_MENU=$_MENU;
    						return $this->_MENU;
    					} else {
    						throw new \Exception('[RKWEB-SERVER] xml NO PRICES in XML, but we have MENU');
    					}
    				}		

    			}else {
    						throw new \Exception('[RKWEB-SERVER] xml NO ITEMS in XML');

    					}

    		} else {
    			throw new \Exception('[RKWEB-SERVER] xml response parses to empty array');
    		}
    	}
}

}
