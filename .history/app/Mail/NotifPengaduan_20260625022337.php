<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class NotifPengaduan extends Mailable
{
    public $layanan;

    public function __construct($layanan)
    {
        $this->layanan = $layanan;
    }

    public function build()
    {
        return $this->subject('Update Pengaduan Anda')
                    ->view('emails.pengaduan');
    }
}
