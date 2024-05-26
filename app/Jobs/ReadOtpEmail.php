<?php

// namespace App\Jobs;

// use App\Models\Otp;
// use App\Models\sbuser;
// use PhpImap\Mailbox;
// use Illuminate\Bus\Queueable;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Queue\SerializesModels;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Foundation\Bus\Dispatchable;

// class ReadOtpEmail implements ShouldQueue
// {
//     use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    // public function handle()
    // {
    //     $mailbox = new Mailbox(
    //         '{mail.gengsfun.com:993/ssl}INBOX',
    //         'test@gengsfun.com',
    //         'Harris2424.'
    //     );

    //     $mails = $mailbox->searchMailbox('UNSEEN');

    //     foreach ($mails as $mailId) {
    //         $mail = $mailbox->getMail($mailId);

    //         // Cek apakah email mengandung kata kunci "Enter this code to sign in"
    //         if (strpos($mail->textPlain, 'Enter this code to sign in') !== false) {
    //             // Ambil OTP
    //             preg_match('/Enter this code to sign in\s+(\d+)/', $mail->textPlain, $matches);
    //             $otp = $matches[1]; // OTP berada di indeks pertama hasil preg_match

    //             // Lakukan sesuatu dengan OTP, misalnya simpan ke database atau kirim ke aplikasi lain
    //             // Contoh:
    //             // \App\Models\Otp::create(['code' => $otp]);

    //             // Hapus email setelah mengambil OTP (opsional)
    //             $mailbox->deleteMail($mailId);
    //         }
    //     }
    // }
    // ===================INI BISA START========================
//     public function handle()
// {
//     try {
//         $mailbox = new Mailbox(
//             '{mail.gengsfun.com:993/ssl}INBOX',
//             'test@gengsfun.com',
//             'Harris2424.'
//         );

//         $mails = $mailbox->searchMailbox('UNSEEN');

//         foreach ($mails as $mailId) {
//             $mail = $mailbox->getMail($mailId);

//             // Cek apakah email mengandung kata kunci "Enter this code to sign in"
//             if (strpos($mail->textPlain, 'Enter this code to sign in') !== false) {
//                 // Ambil OTP
//                 preg_match('/Enter this code to sign in\s+(\d+)/', $mail->textPlain, $matches);
//                 $otp = $matches[1]; // OTP berada di indeks pertama hasil preg_match

//                 // Simpan OTP ke database
//                 $otpModel = new \App\Models\Otp();
//                 $otpModel->code = $otp;
//                 $otpModel->save();

//                 // Berikan log bahwa OTP berhasil diambil dan disimpan
//                 Log::info('OTP berhasil diambil dan disimpan: ' . $otp);

//                 // Hapus email setelah mengambil OTP (opsional)
//                 $mailbox->deleteMail($mailId);
//             }
//         }
//     } catch (\Exception $e) {
//         // Tangkap exception dan catat ke log
//         Log::error('Error dalam menjalankan job ReadOtpEmail: ' . $e->getMessage());
//     }
// }
// public function handle()
// {
//     try {
//         $mailbox = new Mailbox(
//             '{mail.gengsfun.com:993/ssl}INBOX',
//             'test@gengsfun.com',
//             'Harris2424.'
//         );

//         $mails = $mailbox->searchMailbox('UNSEEN');

//         foreach ($mails as $mailId) {
//             $mail = $mailbox->getMail($mailId);

//             // Cek jenis email berdasarkan kata kunci unik
//             if (strpos($mail->textPlain, 'Enter this code to sign in') !== false) {
//                 // Model pertama: langsung ambil OTP dari teks email
//                 preg_match('/Enter this code to sign in\s+(\d+)/', $mail->textPlain, $matches);
//                 $otp = $matches[1]; // OTP berada di indeks pertama hasil preg_match

//                 // Simpan OTP ke database
//                 $otpModel = new \App\Models\Otp();
//                 $otpModel->code = $otp;
//                 $otpModel->email = $mail->fromAddress; // simpan email pengirim jika diperlukan
//                 $otpModel->save();

//                 Log::info('OTP dari model pertama berhasil diambil dan disimpan: ' . $otp);
//             } elseif (strpos($mail->textPlain, 'Kode akses sementara') !== false) {
//                 // Model kedua: Link di email untuk mendapatkan kode OTP
//                 preg_match('/Dapatkan Kode/', $mail->textPlain, $matches);

//                 // Ambil link dari teks email
//                 if (preg_match('/(http:\/\/[^\s]+)/', $mail->textPlain, $urlMatches)) {
//                     $otpLink = $urlMatches[1];

//                     // Lakukan permintaan HTTP ke link untuk mendapatkan OTP
//                     $client = new \GuzzleHttp\Client();
//                     $response = $client->get($otpLink);
//                     $body = $response->getBody()->getContents();

//                     // Ekstrak OTP dari respons
//                     if (preg_match('/OTP:\s+(\d+)/', $body, $otpMatches)) {
//                         $otp = $otpMatches[1];

//                         // Simpan OTP ke database
//                         $otpModel = new \App\Models\Otp();
//                         $otpModel->code = $otp;
//                         $otpModel->email = $mail->fromAddress; // simpan email pengirim jika diperlukan
//                         $otpModel->save();

//                         Log::info('OTP dari model kedua berhasil diambil dan disimpan: ' . $otp);
//                     }
//                 }
//             }

//             // Hapus email setelah memproses (opsional)
//             $mailbox->deleteMail($mailId);
//         }
//     } catch (\Exception $e) {
//         // Tangkap exception dan catat ke log
//         Log::error('Error dalam menjalankan job ReadOtpEmail: ' . $e->getMessage());
//     }
// }========================INI BISA END========================
// public function handle()
// {
//     try {
//         // Ambil email dan kata sandi dari database
//         $emailCredentials = sbuser::first(); // Anda perlu menyesuaikan dengan model dan tabel yang sesuai

//         // Pastikan informasi email dan kata sandi ada
//         if ($emailCredentials) {
//             $mailbox = new Mailbox(
//                 '{mail.gengsfun.com:993/ssl}INBOX',
//                 $emailCredentials->email,
//                 $emailCredentials->password
//             );

//             $mails = $mailbox->searchMailbox('UNSEEN');

//             foreach ($mails as $mailId) {
//                 $mail = $mailbox->getMail($mailId);

//                 // Cek jenis email berdasarkan kata kunci unik
//                 if (strpos($mail->textPlain, 'Enter this code to sign in') !== false) {
//                     // Model pertama: langsung ambil OTP dari teks email
//                     preg_match('/Enter this code to sign in\s+(\d+)/', $mail->textPlain, $matches);
//                     $otp = $matches[1]; // OTP berada di indeks pertama hasil preg_match

//                     // Simpan OTP ke database
//                     $otpModel = new \App\Models\Otp();
//                     $otpModel->code = $otp;
//                     $otpModel->email = $mail->fromAddress; // simpan email pengirim jika diperlukan
//                     $otpModel->save();

//                     Log::info('OTP dari model pertama berhasil diambil dan disimpan: ' . $otp);
//                 } elseif (strpos($mail->textPlain, 'Kode akses sementara') !== false) {
//                     // Model kedua: Link di email untuk mendapatkan kode OTP
//                     preg_match('/Dapatkan Kode/', $mail->textPlain, $matches);

//                     // Ambil link dari teks email
//                     if (preg_match('/(http:\/\/[^\s]+)/', $mail->textPlain, $urlMatches)) {
//                         $otpLink = $urlMatches[1];

//                         // Lakukan permintaan HTTP ke link untuk mendapatkan OTP
//                         $client = new \GuzzleHttp\Client();
//                         $response = $client->get($otpLink);
//                         $body = $response->getBody()->getContents();

//                         // Ekstrak OTP dari respons
//                         if (preg_match('/OTP:\s+(\d+)/', $body, $otpMatches)) {
//                             $otp = $otpMatches[1];

//                             // Simpan OTP ke database
//                             $otpModel = new \App\Models\Otp();
//                             $otpModel->code = $otp;
//                             $otpModel->email = $mail->fromAddress; // simpan email pengirim jika diperlukan
//                             $otpModel->save();

//                             Log::info('OTP dari model kedua berhasil diambil dan disimpan: ' . $otp);
//                         }
//                     }
//                 }

//                 // Hapus email setelah memproses (opsional)
//                 $mailbox->deleteMail($mailId);
//             }
//         } else {
//             Log::error('Tidak ada informasi email dan kata sandi yang ditemukan dalam database.');
//         }
//     } catch (\Exception $e) {
//         // Tangkap exception dan catat ke log
//         Log::error('Error dalam menjalankan job ReadOtpEmail: ' . $e->getMessage());
//     }
// }

// }


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


    /**
     * Execute the job.
     *
     * @return void
     */
//     public function handle()
// {
//     try {
//         // Lakukan pengambilan email dari Sbuser
//         $sbusers = Sbuser::all();

//         foreach ($sbusers as $sbuser) {
//             // Lakukan proses membaca email untuk setiap pengguna
//             $mailbox = new Mailbox(
//                 '{mail.gengsfun.com:993/ssl}INBOX',
//                 $sbuser->email, // Gunakan email dari Sbuser
//                 $sbuser->password // Gunakan password dari Sbuser
//             );

//             $mails = $mailbox->searchMailbox('UNSEEN');

//             foreach ($mails as $mailId) {
//                 $mail = $mailbox->getMail($mailId);

//                 // Ambil semua header email dan ubah menjadi string
//                 $allHeaders = $mail->headers;

//                 // Log all headers for debugging
//                 Log::debug('All Headers:', (array) $allHeaders);

//                 // Ambil alamat email penerima dari header 'to'
//                 $emailTo = null;
//                 if (isset($allHeaders->to)) {
//                     if (is_array($allHeaders->to)) {
//                         $toHeader = $allHeaders->to[0];
//                         $emailTo = $toHeader->mailbox . '@' . $toHeader->host;
//                     } elseif (is_object($allHeaders->to)) {
//                         $emailTo = $allHeaders->to->mailbox . '@' . $allHeaders->to->host;
//                     }
//                 }

//                 // Cek jenis email berdasarkan kata kunci unik
//                 if (strpos($mail->textPlain, 'Enter this code to sign in') !== false) {
//                     preg_match('/Enter this code to sign in\s+(\d+)/', $mail->textPlain, $matches);
//                     $otp = $matches[1] ?? null;

//                     // Simpan alamat email pengirim dan OTP ke database
//                     $otpModel = new Otp();
//                     $otpModel->code = $otp;
//                     $otpModel->email_from = $mail->fromAddress;
//                     $otpModel->email_to = $emailTo;
//                     $otpModel->save();

//                     Log::info('OTP dan Email berhasil diambil dan disimpan: ' . $otp . ' - ' . $emailTo);
//                 } elseif (strpos($mail->textPlain, 'Kode akses sementara') !== false) {
//                     preg_match('/Dapatkan Kode/', $mail->textPlain, $matches);

//                     if (preg_match('/(http:\/\/[^\s]+)/', $mail->textPlain, $urlMatches)) {
//                         $otpLink = $urlMatches[1];

//                         $client = new Client();
//                         $response = $client->get($otpLink);
//                         $body = $response->getBody()->getContents();

//                         if (preg_match('/OTP:\s+(\d+)/', $body, $otpMatches)) {
//                             $otp = $otpMatches[1];

//                             // Simpan alamat email pengirim dan OTP ke database
//                             $otpModel = new Otp();
//                             $otpModel->code = $otp;
//                             $otpModel->email_from = $mail->fromAddress;
//                             $otpModel->email_to = $emailTo;
//                             $otpModel->save();

//                             Log::info('OTP berhasil diambil dan disimpan: ' . $otp . ' - ' . $emailTo);
//                         }
//                     }
//                 }

//                 // Hapus email setelah memproses (opsional)
//                 $mailbox->deleteMail($mailId);
//             }
//         }
//     } catch (\Exception $e) {
//         // Tangkap exception dan catat ke log
//         Log::error('Error dalam menjalankan job ReadOtpEmail: ' . $e->getMessage());
//     }
// }

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
                '{mail.gengsfun.com:993/ssl}INBOX',
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


