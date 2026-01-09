<?php
class Mailer
{
    public static function send(string $to, string $subject, string $message, string $from): bool
    {
        $headers = [
            'MIME-Version: 1.0',
            'Content-Type: text/plain; charset=UTF-8',
            'From: ' . $from,
        ];
        return mail($to, $subject, $message, implode("\r\n", $headers));
    }
}
