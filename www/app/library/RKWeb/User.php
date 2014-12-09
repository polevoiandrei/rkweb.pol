<?php
/*

Класс для работы с пользователями


*/
namespace RKWeb;


class User {

	public function __construct($_=array())
	{
		if (!empty($_)) {

			if($User = RwUsers::findFirst("usr_hash='{$_[hash]}'")) {
				return $User;
			} else {
				throw new \Exception('[RKWebUser] Hash Not Found');
			}
		}
	}


}
