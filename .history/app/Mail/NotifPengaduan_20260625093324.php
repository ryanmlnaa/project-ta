<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class NotifPengaduan extends Mailable
{
    public $layanan;
    public $tipe; // 'diproses' atau 'selesai'

    public function __construct($layanan, $tipe = 'diproses')
    {
        $this->layanan = $layanan;
        $this->tipe    = $tipe;
    }

    public function build()
    {
        if ($this->tipe === 'selesai') {
            return $this->subject('✅ Pengaduan Anda Telah Selesai Ditangani')
                        ->view('emails.pengaduan_selesai');
        }

        return $this->subject('Update Pengaduan Anda')
                    ->view('emails.pengaduan');
    }
}
