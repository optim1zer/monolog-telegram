<?php
/**
 * @author: Optim1zer <optim1zer777@gmail.com>
 * Date: 23.08.2018
 * Time: 13:03
 */

namespace optim1zer\Monolog;


use GuzzleHttp\Client;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

/**
 * Sends notifications through Telegram API.
 * @see https://core.telegram.org/bots/api
 */
class TelegramHandler extends AbstractProcessingHandler
{
    /** @var string Telegram API token */
    private $token;

    /** @var int Chat identifier */
    private $chatId;

    private $options = [
        'timeout' => 10,
    ];

    /**
     * @param string $token Telegram API token
     * @param int $chatId Chat identifier
     * @param int $level The minimum logging level at which this handler will be triggered
     * @param bool $bubble Whether the messages that are handled can bubble up the stack or not
     */
    public function __construct($token, $chatId, $level = Logger::CRITICAL, $bubble = true) {
        $this->token = $token;
        $this->chatId = $chatId;
        parent::__construct($level, $bubble);
    }

    /**
     * @param string $url proxy URL formatted as "http://username:password@192.168.16.1:10" OR "http://192.168.16.1:10"
     */
    public function setProxy($url)
    {
        $this->options['proxy'] = $url;
    }

    /**
     * @param array $options Guzzle options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * @param array $options Guzzle options
     */
    public function addOptions(array $options)
    {
        foreach ($options as $option => $value) {
            $this->options[$option] = $value;
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param array $record
     */
    protected function write(array $record)
    {
        $client = $this->getClient();
        $client->request('POST', sprintf('https://api.telegram.org/bot%s/sendMessage', $this->token), [
            'json' => [
                'chat_id'    => $this->chatId,
                'text'       => $record['formatted'],
                'parse_mode' => 'HTML',
            ]
        ]);
    }

    protected function getClient()
    {
        return new Client($this->options);
    }
}
