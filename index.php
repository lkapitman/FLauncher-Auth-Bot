<?php

require_once('libs/autoload.php');
require_once('libs/rcon.php');

use DigitalStar\vk_api\vk_api;
use TheCarryLove\Rcon;

$config = include('libs/config.php');

$vk = vk_api::create($config['VK_TOKEN'], $config['VK_VERSION'])->setConfirm($config['VK_CONFIRM_STR']);

if ($config['VK_DEBUG'] == 0) {
    $vk->debug();
}

$vk->initVars($id, $message, $payload);

$rcon = new Rcon($config['RCON_HOST'], $config['RCON_PORT'], $config['RCON_PASSWORD'], $config['RCON_TIMEOUT']);

$info_btn = $vk->buttonText('Регистрация', 'red', ['command' => 'Регистрация']);
$help_btn = $vk->buttonText('Помощь', 'green', ['command' => 'Помощь']);
$ip_btn = $vk->buttonText('Айпи', 'blue', ['command' => 'Айпи']);
$PASSWORD_VALID = 0;

if ($payload) {

    if($payload['command'] == 'Регистрация') {
        $vk->reply($config['SYNTAX_REGISTER']);
    }

	if($payload['command'] == 'Помощь') {
		$vk->sendMessage($id, $config['HELPER_STRING']);
	}

	if($payload['command'] == 'Айпи') {
		$vk->sendMessage($id, $config['IP_STRING']);
	}

} else {
    if ($message == 'Начать') {
        $vk->sendButton($id, 'Кнопки инициализированы!', [[$info_btn], [$help_btn], [$ip_btn]]);
        $vk->sendMessage($id, 'Список доступных команд -> Помощь');
    }

    if (strpos($message, 'Регистрация') !== false) {

        $register_args = explode(" ", $message);

        if (count($register_args) == 3) {
            if ($register_args[2] == $register_args[3]) {
                $PASSWORD_VALID = 0;
            } else {
                $PASSWORD_VALID = 1;
            }

            if ($PASSWORD_VALID == 0) {
                if ($rcon->connect()) {

                    $rcon->sendCommand($config['COMMAND_FOR_REGISTER'] . " " . $register_args[1] . " " . $register_args[2]);

                    if ($config['MSG_NEW_PLAYER_ENABLE']) {
                        $rcon->sendCommand($config['MSG_NEW_PLAYER'] . " " . $register_args[1] . " !");
                    }

                    $vk->reply("Успешно!");
                } else {
                    $vk->reply($config['NO_CONNECTION_MSG']);
                }
            } else {
                $vk->reply($config['PASSWORD_NO_VALID']);
            }

        } else {
            $vk->reply($config['PARAMS_COMMAND_NOT_REALY']);
        }

    }
}
