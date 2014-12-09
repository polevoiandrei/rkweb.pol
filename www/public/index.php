<?php

error_reporting(E_ALL);

try {

    /**
     * Read the configuration
     */
    $config = include __DIR__ . "/../app/config/config.php";

    /**
     * Read auto-loader
     */
    include __DIR__ . "/../app/config/loader.php";

    /**
     * Read services
     */
    include __DIR__ . "/../app/config/services.php";



// Simple database connection to localhost
/*    $di->set('mongo', function() {
    	$mongo = new Mongo();
    	return $mongo->selectDb("store");
    }, true);

*/

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);


    $hash='1234';

    /*    	echo $User->usr_name, '<br>',$User->usr_xml_url, '<br>',$User->usr_xml_login, '<br>',$User->usr_xml_password;*/

TODO: запись лога в MongoDB
TODO: запись Меню для Клиента в MongoDB и извлечение если не прошёл таймаут - если не было обновления

    $User = RwUsers::findFirst("usr_hash='{$hash}'");

    if ($User) {

проверяем не просрочилось ли меню, когда следующий раз дёргать

    	if ($User->usr_last_request>) {
    		
    	}

    	записываем дату последнего изменения меню
    	// логируем последнюю активность, что сделали запрос
    	$User->usr_last_request=(new \DateTime())->format('Y-m-d H:i:s');
    	$User->save();



    	/*    	echo $User->usr_name, '<br>',$User->usr_xml_url, '<br>',$User->usr_xml_login, '<br>',$User->usr_xml_password;*/

// инициализируем параметры удаленного XML сервера. 
    	$XMLServer = new \RKWeb\XMLServer(array('url'=>$User->usr_xml_url, 'login'=>$User->usr_xml_login, 'password'=>$User->usr_xml_password));
    	$_MENU = $XMLServer->getMenu();

    	print_r($_MENU);

    } else {
    	throw new \Exception('HashNotFound');
    }
// разбираем XML в массив



    // echo $application->handle()->getContent();





  } catch (\Exception $e) {
  	echo $e->getMessage();
  }




/*запасной вариант, но достаточно в лоб и, говорят, бажный      
$context  = stream_context_create(array('http' =>
  array(
    'method'  => 'GET',
    'header'  => "Content-Type: application/xml\r\n".
     "Authorization: Basic ".base64_encode($User->usr_xml_login.':'.$User->usr_xml_password)."\r\n",
    'content' => $xml_request,
    'timeout' => 60
  )));
$result = file_get_contents($User->usr_xml_url, false, $context, -1, 40000);
print_r($result);*/