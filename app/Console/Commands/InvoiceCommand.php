<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\DB;

class InvoiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // $datas = DB::SELECT("
        //     SELECT
        //         count( id ) AS jumlah,
        //         supplier_name,
        //         sum( CASE WHEN STATUS = 'Open' THEN 1 ELSE 0 END ) AS 'open_invoice'
        //     FROM
        //         acc_invoice_vendors 
        //     WHERE
        //         deleted_at IS NULL 
        //     GROUP BY
        //         supplier_name 
        //     ORDER BY
        //         jumlah DESC
        // ");

        // $bcc = [];
        // $bcc[1] = 'rio.irvansyah@music.yamaha.com';

        // // $cc = [];
        // // $cc[0] = 'shega.erik.wicaksono@music.yamaha.com';

        // $mail_to = [];
        // $mail_to[0] = 'shega.erik.wicaksono@music.yamaha.com';
        // $mail_to[1] = 'erlangga.kharisma@music.yamaha.com';

        // if (count($datas) > 0) {
        //     Mail::to($mail_to)->bcc($bcc,'BCC')->send(new SendEmail($datas, 'invoice_command'));
        // }

        $message = urlencode("Test Command BFV");

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.whatspie.com/api/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'receiver=6282234955505&device=6281130561777&message=' . $message . '&type=chat',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Bearer UAqINT9e23uRiQmYttEUiFQ9qRMUXk8sADK2EiVSgLODdyOhgU',
            ),
        ));
        curl_exec($curl);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.whatspie.com/api/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'receiver=6282334197238&device=6281130561777&message=' . $message . '&type=chat',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Bearer UAqINT9e23uRiQmYttEUiFQ9qRMUXk8sADK2EiVSgLODdyOhgU',
            ),
        ));
        curl_exec($curl);

        $to = [
            'mokhamad.khamdan.khabibi@music.yamaha.com',
            'rio.irvansyah@music.yamaha.com',
            'muhammad.ikhlas@music.yamaha.com',
            'nasiqul.ibat@music.yamaha.com',
        ];

        $bodyHtml = "BFV Test Mail";

        Mail::raw([], function($message) use($bodyHtml, $to) {
            $message->from('info@bridgeforvendor.com', 'Bridgeforvendor');
            $message->to($to);
            $message->subject('BFV Test Mail');
            $message->setBody($bodyHtml, 'text/html' );
        });
    }
}
