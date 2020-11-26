<?php
require_once('vklib/autoload.php'); //подключаем библиотеку
use DigitalStar\vk_api\vk_api; //используем только основной класс

const VK_TOKEN = 'b0a2bf71e09e871e7512b53758299d54d54a1f0748bada9e389f981d307f98ba7d9539ad3664348c5e58c'; //токен из группы
const CONFIRM_STR = '7d56587f'; //строка подтверждения сервера
const VERSION = '5.101';
const helper_String = '';

$vk = vk_api::create(VK_TOKEN, VERSION)->setConfirm(CONFIRM_STR);
$vk->debug(); //включение дебаг режима. Если в коде ошибка - ее можно посмотреть в неудавшихся запросах
$vk->initVars($id, $message, $payload); //инициализация переменных
$info_btn = $vk->buttonText('Регистрация', 'red', ['command' => '/register']); //создание кнопки
$help_btn = $vk->buttonText('Помощь', 'green', ['command' => '/help']); //создание кнопки

if ($payload) { //если пришло нажатие кнопки
    if($payload['command'] == '/register') {
        $vk->reply('Тест регистрации %a_full%'); //отвечает пользователю или в беседу
    }
	if ($payload['command'] == '/help') {
		$vk->reply(helper_String);
	}
} else {
	if ($message == 'Начать') {
		$vk->sendButton($id, 'Кнопка "Регистрация" инициализирована!', [[$info_btn]]);
		$vk->sendButton($id, 'Кнопка "Помощь" инициализирована!', [[$help_btn]]);
	}
}
