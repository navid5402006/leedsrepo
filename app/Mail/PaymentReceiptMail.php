<?php
// app/Mail/PaymentReceiptMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $student;
    public $enrollment;
    public $paymentsHistory;
    public $settings;

    public function __construct($payment, $student, $enrollment, $paymentsHistory, $settings)
    {
        $this->payment = $payment;
        $this->student = $student;
        $this->enrollment = $enrollment;
        $this->paymentsHistory = $paymentsHistory;
        $this->settings = $settings;
    }

    public function build()
    {
        return $this->subject('Payment Receipt – Leeds Institute')
                    ->view('emails.payment-receipt')
                    ->with([
                        'payment' => $this->payment,
                        'student' => $this->student,
                        'enrollment' => $this->enrollment,
                        'paymentsHistory' => $this->paymentsHistory,
                        'settings' => $this->settings,
                    ]);
    }
}