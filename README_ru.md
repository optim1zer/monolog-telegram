# monolog-telegram
Handler для Monolog, который позволяет отправлять логи в Telegram в формате HTML

Требования
------------

- PHP 5.6 or above
- Guzzle 6+

Установка через composer
-------------------------

```bash
composer require optim1zer/monolog-telegram  
```

Инициализация объекта
------------------------

Для инициализации объекта хэндлера вы должны знать токен бота и ID чата, в который бот будет слать логи.
Где их взять описано чуть ниже.

```php
// ...
$handler = new \optim1zer\Monolog\TelegramHandler('<token>', <chat_id>, <log_level>);
// ...
```

**Пример использования:**

```php
$log = new \Monolog\Logger('telegram_channel');

$handler = new \optim1zer\Monolog\TelegramHandler(
    '000000000:XXXXX-xxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
    123456789,
    \Monolog\Logger::DEBUG
);
$handler->setFormatter(new \Monolog\Formatter\LineFormatter("%message%", null, true));
$log->pushHandler($handler);

$log->debug('Test message');
```

В примере используется стандартный LineFormatter, который идет в комплекте с Monolog. Вы можете написать собственный formatter, чтобы сделать ваши логи более наглядными.

**Пример с прокси (для русских серверов):**

```php
$handler = new \optim1zer\Monolog\TelegramHandler('<token>', <chat_id>, <log_level>);
$handler->setProxy('http://username:password@192.168.16.1:80'); // or simply 'http://192.168.16.1:80'
$handler->setFormatter(new \Monolog\Formatter\LineFormatter("%message%", null, true));
```

Создание бота
--------------

Чтобы создать бота и получить для него API-токен обратимся **@BotFather** в Telegram.

**Пример создания:**

В примере ниже, я создаю бота с именем "Logger Bot" и ником "@logger_bot" с помощью **@BotFather**.

```
Me: /newbot
---
@BotFather: Alright, a new bot. How are we going to call it? Please choose a name for your bot.
---
Me: Logger Bot
---
@BotFather: Good. Now let's choose a username for your bot. It must end in `bot`. Like this, for example: 
TetrisBot or tetris_bot.
---
Me: logger_bot
---
@BotFather: Done! Congratulations on your new bot. You will find it at telegram.me/cronus_bot. You can now add a 
description, about section and profile picture for your bot, see /help for a list of commands. By the way, when 
you've finished creating your cool bot, ping our Bot Support if you want a better username for it. Just make sure 
the bot is fully operational before you do this.

Use this token to access the HTTP API:
000000000:XXXXX-xxxxxxxxxxxxxxxxxxxxxxxxxxxxx

For a description of the Bot API, see this page: https://core.telegram.org/bots/api
```

Получение ID чата
----------------------

Чтобы получить ID чата найдите вашего бота в Telegram и напишите ему личное сообщение.
После этого выполните следующий запрос, чтобы узнать ID чата. Не забудьте заменить <token> на полученный выше токен. 

**URL:** https://api.telegram.org/bot<token>/getUpdates

**Пример:**

```
Request
-------
GET https://api.telegram.org/bot000000000:XXXXX-xxxxxxxxxxxxxxxxxxxxxxxxxxxxx/getUpdates

Response
--------
{
  "ok": true,
  "result": [
    {
      "update_id": 121227832,
      "message": {
        "message_id": 1,
        "from": {
          "id": 1583498345345,
          "first_name": "*****",
          "last_name": "*****",
          "username": "Optim1zer"
        },
        "chat": {
          "id": 123456789,
          "first_name": "*****",
          "last_name": "*****",
          "username": "Optim1zer",
          "type": "private"
        },
        "date": 1510701612,
        "text": "test message"
      }
    }
  ]
}
```

В примере выше ID чата: "123456789" (result.message.chat.id).