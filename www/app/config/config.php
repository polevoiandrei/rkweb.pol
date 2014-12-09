<?php

// как обрезаем ответ от CURL на header и Body
define('SPLIT_RESPONSE_BY','<?xml version="1.0" encoding="utf-8"?>');
define('CURL_TIMEOUT',30); //таймаут на выполнение ф-ии и коннекта, сек.


// Форматы запросов к XML API
define('RK_XML_REQUEST_GET_MENU','<?xml version="1.0" encoding="utf-8"?><RK7Query><RK7CMD CMD="GetRefData" RefName="MenuItems" IgnoreEnums="1" OnlyActive="1"/></RK7Query>'); // get menu items)
define('RK_XML_REQUEST_GET_PRICES','<?xml version="1.0" encoding="UTF-8"?><RK7Query><RK7CMD CMD="GetOrderMenu" StationCode="1"/></RK7Query>'); // get prices
define('RK_XML_REQUEST_GET_CREATE_ORDER','<?xml version="1.0" encoding="utf-8"?><RK7Query><RK7CMD CMD="CreateOrder"><Order TableCode="4" WaiterCode="4" GuestTypeID="0"><Station code="1"/></Order></RK7CMD></RK7Query>'); // create order


return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => '',
        'dbname'      => 'rkweb',
    ),
    'application' => array(
        'vendorsDir' => __DIR__ . '/../../app/vendors/',
        'controllersDir' => __DIR__ . '/../../app/controllers/',
        'modelsDir'      => __DIR__ . '/../../app/models/',
        'viewsDir'       => __DIR__ . '/../../app/views/',
        'pluginsDir'     => __DIR__ . '/../../app/plugins/',
        'libraryDir'     => __DIR__ . '/../../app/library/',
        'cacheDir'       => __DIR__ . '/../../app/cache/',
        'baseUri'        => '/',
    )
));