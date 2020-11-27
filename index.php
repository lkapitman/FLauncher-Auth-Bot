<?php
require_once('vklib/autoload.php'); //подключаем библиотеку
use DigitalStar\vk_api\vk_api; //используем только основной класс



const VK_TOKEN = 'b0a2bf71e09e871e7512b53758299d54d54a1f0748bada9e389f981d307f98ba7d9539ad3664348c5e58c'; //токен из группы
const CONFIRM_STR = '25d60c84'; //строка подтверждения сервера
const VERSION = '5.92';
const helper_String = 'Мои команды: <br> 1) /register <username> <password> <repassword> <br> 2) /help';
const ip_String = 'В разработке!';

$vk = vk_api::create(VK_TOKEN, VERSION)->setConfirm(CONFIRM_STR);
$vk->debug(); //включение дебаг режима. Если в коде ошибка - ее можно посмотреть в неудавшихся запросах
$vk->initVars($id, $message, $payload); //инициализация переменных

$info_btn = $vk->buttonText('Регистрация', 'red', ['command' => 'Регистрация']); //создание кнопки
$help_btn = $vk->buttonText('Помощь', 'green', ['command' => 'Помощь']); //создание кнопки
$ip_btn = $vk->buttonText('Айпи', 'blue', ['command' => 'Айпи']); //создание кнопки

if ($payload) { //если пришло нажатие кнопки
    if($payload['command'] == 'Регистрация') {
		// TODO : Регистрация пользователя
        $vk->reply('Тест клаввиатуры %a_full%'); //отвечает пользователю или в беседу
		// TODO: Сделать регистрацию,лол.
		}
		if($payload['command'] == 'Помощь') {
			$vk->sendMessage($id, helper_String);
		}
		if($payload['command'] == 'Айпи') {
			$vk->sendMessage($id, ip_String);
		}
} else {
	if ($message == 'Начать') {
		$vk->sendButton($id,'[DEBUG] Кнопки инициализированы!', [[$info_btn], [$help_btn], [$ip_btn]]);
		$vk->sendMessage($id,'[INFO] Список доступных команд -> Помощь');
	}

}
