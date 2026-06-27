<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class NotifPengaduanSelesai extends Mailable
{
    public $layanan;

    public function __construct($layanan)
    {
        $this->layanan = $layanan;
    }

    public function build()
    {
        return $this->subject('✅ Pengaduan Anda Telah Selesai Ditangani')
                    ->view('emails.pengaduan_selesai');
    }
}
