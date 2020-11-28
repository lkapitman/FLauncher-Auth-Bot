<?php

namespace TheCarryLove;

class Config {

  // [OUR SETTINGS]
  static $DEBUG = false;
  private $CharForReplace = ';';

  // [VK]
  static $VK_TOKEN = 'b0a2bf71e09e871e7512b53758299d54d54a1f0748bada9e389f981d307f98ba7d9539ad3664348c5e58c';
  static $CONFIRM_STR = 'f186a969';
  static $VERSION = '5.92';

  // [MESSAGES]
  static $HELPER_STRING = $this->replaceChar($CharForReplace , 'Мои команды: ; 1) /register <username> <password> <repassword> ; 2) /help');
  static $IP_STRING = 'В разработке!';
  static $SUCCESFULL = 'Успешно!';
  static $MessageAfterRegister = "me Был зарегестрирован новый игрок с никнеймом";
  static $AuthCommand = "authme register";
  static $ErrorMSG = "Параметры команды указаны не верно!";

  // [RCON]
  static $HOST = '2.tcp.ngrok.io:13862';
  static $PORT = 25575;
  static $PASSWORD = 'putin125';
  static $TIMEOUT = 5;

  private function replaceChar($replaced, $msg) {
    return str_replace($replaced, '<br>', $msg);
  }

  

}
