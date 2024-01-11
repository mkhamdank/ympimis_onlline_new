<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $remark;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $remark)
    {
        $this->data = $data;
        $this->remark = $remark;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        if ($this->remark == 'request_reset_password') {
            return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')->subject('Reset Password Request (パスワードリセットの申請)')->view('mails.request_reset_password');
        }

        if ($this->remark == 'register') {
            return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')->subject('Register Vendor Information (登録情報)')->view('mails.register');
        }

        if ($this->remark == 'register_confirmation') {
            return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')->subject('YMPI Register Confirmation')->view('mails.register_confirmation');
        }

        if ($this->remark == 'request_reject') {
            return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')->subject('YMPI Register Confirmation')->view('mails.register_confirmation');
        }

        if ($this->remark == 'change_password') {
            return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')->subject('Change Password Information (パスワード変更の情報)')->view('mails.change_password');
        }

        if ($this->remark == 'critical_true') {
            return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')->subject('Critical Defect PT. TRUE')->view('mails.critical_true');
        }

        if ($this->remark == 'over_limit_ratio_true') {
            return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')->subject('Non Critical Defect Ratio ( > 5%) PT. TRUE')->view('mails.over_limit_ratio_true');
        }

        if ($this->remark == 'over_limit_ratio_cpp') {
            return $this->from('bridgeforvendor@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')->subject('Defect Ratio ( > 5%) PT. CONTINENTAL PANJIPRATAMA')->view('mails.over_limit_ratio_cpp');
        }

        if ($this->remark == 'critical_arisa') {
            return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')->subject('Inpection Report (100%) PT. ARISAMANDIRI PRATAMA')->view('mails.critical_arisa');
        }

        if ($this->remark == 'lot_out_arisa') {
            return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')->subject('Lot Out Report PT. ARISAMANDIRI PRATAMA')->view('mails.lot_out_arisa');
        }

        if ($this->remark == 'recheck_outgoing') {
            return $this->from('bridgeforvendor@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')->subject('Recheck Information PT. CRESTEC INDONESIA')->view('mails.recheck_outgoing');
        }

        if ($this->remark == 'recheck_reminder') {
            return $this->from('bridgeforvendor@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')->subject('Recheck Reminder PT. CRESTEC INDONESIA')->view('mails.recheck_reminder');
        }

        if ($this->remark == 'lot_out_crestec') {
            return $this->from('bridgeforvendor@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')->subject('Lot Out Information PT. CRESTEC INDONESIA')->view('mails.lot_out_crestec');
        }

        if ($this->remark == 'over_limit_ratio_arisa') {
            return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')->subject('Inpection Report (100%) PT. ARISAMANDIRI PRATAMA')->view('mails.over_limit_ratio_arisa');
        }

        if ($this->remark == 'critical_kbi') {
            return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')->subject('Inpection Report (100%) PT. KYORAKU BLOWMOLDING INDONESIA')->view('mails.critical_kbi');
        }

        if ($this->remark == 'over_limit_ratio_kbi') {
            return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')->subject('Inpection Report (100%) PT. KYORAKU BLOWMOLDING INDONESIA')->view('mails.over_limit_ratio_kbi');
        }

        if ($this->remark == 'fixed_asset_check') {
            return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')->subject('Fixed Asset Check Approval (VENDOR)')->view('fixed_asset.mail.fixed_asset_check_approval');
        }

        if ($this->remark == 'payment_request') {
            if ($this->data[0]->pdf != null) {
                return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')
                    ->priority(1)
                    ->subject('Payment Request (支払リクエスト)')
                    ->view('mails.payment_request')
                    ->attach(public_path('payment_list/' . $this->data[0]->pdf));
            } else {
                return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')
                    ->priority(1)
                    ->subject('Payment Request (支払リクエスト)')
                    ->view('mails.payment_request');
            }
        }

        if ($this->remark == 'invoice_command') {
            return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')
                ->subject('Resume Invoice Vendor')
                ->view('mails.invoice_command');
        }

        if ($this->remark == 'vendor') {
            return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')
                ->subject('Vendor Covid19 Assessment')
                ->view('mails.vendor_assessment');
        }
        if ($this->remark == 'guest') {
            return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')
                ->subject('Guest Self Assessment Covid19')
                ->view('mails.guest_assessment')
                ->attach('http://10.109.33.10/ympicoid/public/files/gsa/' . $this->data[0]->file . '');
        }
        if ($this->remark == 'wpos') {
            return $this->from('mis@ympi.co.id', 'PT. Yamaha Musical Products Indonesia')
                ->subject('Work Permit With Enviromental & Safety Analysis')
                ->view('mails.wpos');
            // ->attach('')
        }

        // VENDOR CONTROL
        if ($this->remark == 'send_delivery_order') {
            return $this->from('bridgeforvendor@ympi.co.id', 'Bridge For Vendor')
                ->subject('Surat Jalan Bridge For Vendor')
                ->attach(public_path('files/delivery_order/' . str_replace('//', '.', $this->data['delivery_order']->delivery_order_no) . '.pdf'))
                ->attach(public_path('files/po/' . $this->data['delivery_order']->document_no . '.pdf'))
                ->view('vendor.mails.mail_delivery_order');
        }

        if ($this->remark == 'send_bc_document') {
            return $this->from('bridgeforvendor@ympi.co.id', 'Bridge For Vendor')
                ->subject('Dokumen BC Bridge For Vendor')
                ->attach(public_path('files/document_bc/' . $this->data['delivery_order']->customs_no . '.pdf'))
                ->attach(public_path('files/document_bc/' . $this->data['delivery_order']->customs_no . ' SPPB.pdf'))
                ->view('vendor.mails.mail_bc');
        }

    }
}
