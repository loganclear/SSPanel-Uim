<?php

declare(strict_types=1);

namespace App\Utils;

use Exception;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

final class Telegram
{
    /**
     * 发送讯息，默认给群组发送
     *
     * @throws TelegramSDKException
     * @throws TelegramSDKException
     */
    public static function send(string $messageText, int $chat_id = 0): void
    {
        $bot = null;

        if ($chat_id === 0) {
            $chat_id = $_ENV['telegram_chatid'];
        }

        if ($_ENV['enable_telegram'] === true) {
            // 发送给非群组时使用异步
            $async = ($chat_id !== $_ENV['telegram_chatid']);

            $bot = new Api($_ENV['telegram_token'], $async);

            $sendMessage = [
                'chat_id' => $chat_id,
                'text' => $messageText,
                'parse_mode' => '',
                'disable_web_page_preview' => false,
                'reply_to_message_id' => null,
                'reply_markup' => null,
            ];

            $bot->sendMessage($sendMessage);
        }
    }

    /**
     * 以 Markdown 格式发送讯息，默认给群组发送
     *
     * @throws TelegramSDKException
     */
    public static function sendMarkdown(string $messageText, int $chat_id = 0): void
    {
        $bot = null;

        if ($chat_id === 0) {
            $chat_id = $_ENV['telegram_chatid'];
        }

        if ($_ENV['enable_telegram'] === true) {
            // 发送给非群组时使用异步
            $async = ($chat_id !== $_ENV['telegram_chatid']);

            $bot = new Api($_ENV['telegram_token'], $async);

            $sendMessage = [
                'chat_id' => $chat_id,
                'text' => $messageText,
                'parse_mode' => 'Markdown',
                'disable_web_page_preview' => false,
                'reply_to_message_id' => null,
                'reply_markup' => null,
            ];
            try {
                $bot->sendMessage($sendMessage);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
}
