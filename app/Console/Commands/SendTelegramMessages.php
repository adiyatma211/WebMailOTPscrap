<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Message; // Assume your model is named Message

class SendTelegramMessages extends Command
{
    protected $signature = 'telegram:send-messages';
    protected $description = 'Send messages from the database to a Telegram bot';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $token = '7041977828:AAHeWao5YWe_OWqhrzzCtygn70p4fiTUbek';
        $chat_id = '604963944';
        $otp = '123456';
        $email = 'test@gengsfun.com';
        // Membuat pesan dengan format yang diinginkan
        $message = "Kode Netflix OTP: $otp\nEmail: $email";
        $client = new Client();


        // $messages = Message::where('sent', false)->get(); // Assuming you have a 'sent' column to track sent messages

        $response = $client->post("https://api.telegram.org/bot{$token}/sendMessage", [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => $message,
            ],
        ]);

        if ($response->getStatusCode() == 200) {
            $this->info('Message sent successfully!');
        } else {
            $this->error('Failed to send message.');
        }
    }
}
