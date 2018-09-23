# monolog-telegram
Handler for Monolog to send logs by Telegram in HTML format

Requirements
------------

- PHP 5.6 or above
- Guzzle 6+

Instalation with composer
-------------------------

```bash
composer require optim1zer/monolog-telegram  
```

Declaring handler object
------------------------

To declare this handler, you need to know the bot token and the chat identifier(chat_id) to
which the log will be sent.

```php
// ...
$handler = new \optim1zer\Monolog\TelegramHandler('<token>', <chat_id>, <log_level>);
// ...
```

**Example:**

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

The above example is using standard LineFormatter from Monolog package. You can write and use your own message formatter for better logs format.

**Example with proxy (for russian users):**

```php
$handler = new \optim1zer\Monolog\TelegramHandler('<token>', <chat_id>, <log_level>);
$handler->setProxy('http://username:password@192.168.16.1:80'); // or simply 'http://192.168.16.1:80'
$handler->setFormatter(new \Monolog\Formatter\LineFormatter("%message%", null, true));
```

Creating a bot
--------------

To use this handler, you need to create your bot on telegram and receive the Bot API access token.
To do this, start a conversation with **@BotFather**.

**Conversation example:**

In the example below, I'm talking to **@BotFather**. to create a bot named "Logger Bot" with user "@logger_bot".

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

Get a chat identifier
----------------------

To retrieve the chat_id in which the logs will be sent, the recipient user will first need a conversation with 
the bot. After the conversation has started, make the request below to know the chat_id of that conversation.

**URL:** https://api.telegram.org/bot_token_/getUpdates

**Example:**

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

In the above request, the chat_id is represented by the number "123456789".