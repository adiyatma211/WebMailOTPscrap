<?php

// ==================baru dan logika=====================
namespace App\Jobs;

use App\Models\Sbuser;


use PhpImap\Mailbox;

use App\Models\Otp;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
// use PhpImap\Mailbox;
use Illuminate\Support\Facades\Mail;
use PhpImap\Mailbox\IncomingMail;
use PhpImap\IncomingMail\Address;
use Exception;

class ReadOtpEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

public function handle()
{
    try {
        // Lakukan pengambilan email dari Sbuser
        $sbusers = Sbuser::all();
        Log::info('Total Sbusers yang ditemukan: ' . count($sbusers));

        foreach ($sbusers as $sbuser) {
            Log::info('Memproses email untuk pengguna: ' . $sbuser->email);

            // Lakukan proses membaca email untuk setiap pengguna
            $mailbox = new Mailbox(
                '{mail.<domainmail>.com:993/ssl}INBOX',
                $sbuser->email, // Gunakan email dari Sbuser
                $sbuser->password // Gunakan password dari Sbuser
            );

            $mails = $mailbox->searchMailbox('UNSEEN');

            Log::info('Total email yang ditemukan untuk ' . $sbuser->email . ': ' . count($mails));

            foreach ($mails as $mailId) {
                $mail = $mailbox->getMail($mailId);

                // Ambil semua header email dan ubah menjadi string
                $allHeaders = $mail->headers;

                // Log all headers for debugging
                Log::debug('All Headers:', (array) $allHeaders);

                // Ambil alamat email penerima dari header 'to'
                $emailTo = null;
                if (isset($allHeaders->to)) {
                    if (is_array($allHeaders->to)) {
                        $toHeader = $allHeaders->to[0];
                        $emailTo = $toHeader->mailbox . '@' . $toHeader->host;
                    } elseif (is_object($allHeaders->to)) {
                        $emailTo = $allHeaders->to->mailbox . '@' . $allHeaders->to->host;
                    }
                }

                // Cek jenis email berdasarkan kata kunci unik
                if (strpos($mail->textPlain, 'Enter this code to sign in') !== false) {
                    preg_match('/Enter this code to sign in\s+(\d+)/', $mail->textPlain, $matches);
                    $otp = $matches[1] ?? null;

                    if ($otp) {
                        // Simpan alamat email pengirim dan OTP ke database
                        $otpModel = new Otp();
                        $otpModel->code = $otp;
                        $otpModel->email_from = $mail->fromAddress;
                        $otpModel->email_to = $emailTo;
                        $otpModel->save();

                        Log::info('OTP dan Email berhasil diambil dan disimpan: ' . $otp . ' - ' . $emailTo);
                    } else {
                        Log::warning('OTP tidak ditemukan dalam email untuk ' . $sbuser->email);
                    }
                } elseif (strpos($mail->textPlain, 'Kode akses sementara') !== false) {
                    preg_match('/Dapatkan Kode/', $mail->textPlain, $matches);

                    if (preg_match('/(http:\/\/[^\s]+)/', $mail->textPlain, $urlMatches)) {
                        $otpLink = $urlMatches[1];

                        $client = new Client();
                        $response = $client->get($otpLink);
                        $body = $response->getBody()->getContents();

                        if (preg_match('/OTP:\s+(\d+)/', $body, $otpMatches)) {
                            $otp = $otpMatches[1];

                            // Simpan alamat email pengirim dan OTP ke database
                            $otpModel = new Otp();
                            $otpModel->code = $otp;
                            $otpModel->email_from = $mail->fromAddress;
                            $otpModel->email_to = $emailTo;
                            $otpModel->save();

                            Log::info('OTP berhasil diambil dan disimpan: ' . $otp . ' - ' . $emailTo);
                        } else {
                            Log::warning('OTP tidak ditemukan dalam body email untuk ' . $sbuser->email);
                        }
                    } else {
                        Log::warning('Link OTP tidak ditemukan dalam email untuk ' . $sbuser->email);
                    }
                }

                // Hapus email setelah memproses (opsional)
                $mailbox->deleteMail($mailId);
            }
        }
    } catch (\Exception $e) {
        // Tangkap exception dan catat ke log
        Log::error('Error dalam menjalankan job ReadOtpEmail: ' . $e->getMessage());
    }
}


}


