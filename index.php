<?php

use DigitalStar\vk_api\vk_api;
use TheCarryLove\Rcon;
use TheCarryLove\Config;

require_once('libs/autoload.php');
require_once('libs/rcon.php');
require_once('libs/config.php');

$vk = vk_api::create(Config::$VK_TOKEN, Config::$VERSION)->setConfirm(Config::$CONFIRM_STR);

if (Config::$DEBUG != false) {
	$vk->debug();
}

$vk->initVars($id, $message, $payload);

$rcon = new Rcon(Config::$HOST, Config::$PORT, Config::$PASSWORD, Config::$TIMEOUT);

$password_valid = false;

$info_btn = $vk->buttonText('Регистрация', 'red', ['command' => 'Регистрация']);
$help_btn = $vk->buttonText('Помощь', 'green', ['command' => 'Помощь']);
$ip_btn = $vk->buttonText('Айпи', 'blue', ['command' => 'Айпи']);

if ($payload) {

    if(strpos($payload['command'], 'Регистрация') != false) {

			$register_args = explode(" ", $payload['command']);

			if (count($register_args) == 3) {

					if ($register_args[2] == $register_args[3]) {
						$password_valid = true;
					} else {
						$password_valid = false;
					}
					if ($password_valid) {
						if ($rcon->connect()) {
							$rcon->sendCommand(Config::$AuthCommand . " " . $register_args[1] . " " . $register_args[2]);
							$rcon->sendCommand(Config::$MessageAfterRegister . " " . $register_args[1] . " !");
							$vk->reply(Config::$SUCCESFULL);
						}
					}
			} else {
				$vk->reply(Config::ErrorMSG);
			}

		}

	if($payload['command'] == 'Помощь') {
		$vk->reply(Config::$HELPER_STRING);
	}
	if($payload['command'] == 'Айпи') {
		$vk->reply(Config::$IP_STRING);
	}
} else {
	if ($message == 'Начать') {
		$vk->sendButton($id,'Кнопки инициализированы!', [[$info_btn], [$help_btn], [$ip_btn]]);
		$vk->reply('Список доступных команд -> Помощь');
	}

}
