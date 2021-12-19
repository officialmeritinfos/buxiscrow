<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    protected $title;
    protected $type;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details,$title,$type=1)
    {
        //initialize property
        $this->details=$details;
        $this->title=$title;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        switch ($this->type){
            case 1 :
                    return $this->subject($this->title)
                    ->view('mails.new_invoice');
                break;
            case 2:
                return $this->subject($this->title)
                    ->view('mails.invoice_paid');
                break;
            default :
                return $this->subject($this->title)
                    ->view('mails.invoice_pending_payment');
        }
    }
}
