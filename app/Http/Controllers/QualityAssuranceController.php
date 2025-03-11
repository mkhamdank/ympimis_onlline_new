<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use Response;
use Excel;
use App\CodeGenerator;
use App\ErrorLog;

class QualityAssuranceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        if (isset($_SERVER['HTTP_USER_AGENT']))
        {
            $http_user_agent = $_SERVER['HTTP_USER_AGENT']; 
            if (preg_match('/Word|Excel|PowerPoint|ms-office/i', $http_user_agent)) 
            {
                die();
            }
        }

        $this->timestamp = date('Y-m-d H:i:s');
    }

    public function indexDocumentControl($vendor)
    {
        if ($vendor == 'arisa') {
            $title = 'Document Control - PT. ARISAMANDIRI PRATAMA';
            $page = 'Document Control - ARISA';
            $title_jp = '';
        }

        $material = DB::table('qa_materials')->where('vendor_shortname',strtoupper($vendor))->get();

        return view('qa.document.index', array(
            'title' => $title,
            'vendor' => $vendor,
            'title_jp' => $title_jp,
            'material' => $material,
            'material2' => $material,
        ))->with('page', $page)->with('head', $page);
    }

    public function fetchDocumentControl(Request $request)
    {
        try {
            $document = DB::table('qa_documents')->where('vendor',$request->get('vendor'));

            if ($request->get('category') != '') {
                $document = $document->where('category',$request->get('category'));
            }
            $document = $document->get();
            $response = array(
                'status' => true,
                'document' => $document
            );
            return Response::json($response);
        } catch (\Exception $e) {
            $response = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
            return Response::json($response);
        }
    }

    public function inputDocumentControl(Request $request)
    {
        try {
            $code_generator = CodeGenerator::where('note', '=', 'qa_document')->first();
            $serial_number = $code_generator->prefix.sprintf("%'.0" . $code_generator->length . "d", $code_generator->index+1);
            $code_generator->index = $code_generator->index+1;
            $code_generator->save();

            $vendor = $request->get('vendor');
            $category = $request->get('category');
            $document_number = $request->get('document_number');
            $title = $request->get('title');
            $version = $request->get('version');
            $version_date = $request->get('version_date');
            $status = $request->get('status');
            $material_number = $request->get('material_number');
            $material_description = $request->get('material_description');

            if ($material_number == 'null') {
                $material_number = null;
            }

            if ($material_description == 'null') {
                $material_description = null;
            }

            $filename = "";
            $file_destination = 'qa/document';

            if (count($request->file('fileData')) > 0) {
                $file = $request->file('fileData');
                $filename = 'document_'.$vendor.'_'.$version.'_'.date('YmdHisa').'.pdf';
                $file->move($file_destination, $filename);
            }

            $input = DB::table('qa_documents')->insert([
                'document_id' => $serial_number,
                'vendor' => $vendor,
                'category' => $category,
                'material_number' => $material_number,
                'material_description' => $material_description,
                'document_number' => $document_number,
                'title' => $title,
                'version' => $version,
                'version_date' => $version_date,
                'status' => $status,
                'file_name_pdf' => $filename,
                'created_by' => Auth::user()->id,
                'created_at' => $this->timestamp,
                'updated_at' => $this->timestamp,
            ]);
            $response = array(
                'status' => true,
            );
            return Response::json($response);
        } catch (\Exception $e) {
            $response = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
            return Response::json($response);
        }
    }

    public function updateDocumentControl(Request $request)
    {
        try {
            $document_id = $request->get('document_id');
            $vendor = $request->get('vendor');
            $category = $request->get('category');
            $document_number = $request->get('document_number');
            $title = $request->get('title');
            $version = $request->get('version');
            $version_date = $request->get('version_date');
            $status = $request->get('status');
            $material_number = $request->get('material_number');
            $material_description = $request->get('material_description');

            $data = DB::table('qa_documents')->where('document_id',$document_id)->first();
            $filename = $data->file_name_pdf;
            $file_destination = 'qa/document';

            if ($request->file('fileData') != null) {
                $file = $request->file('fileData');
                $filename = 'document_'.$vendor.'_'.$version.'_'.date('YmdHisa').'.pdf';
                $file->move($file_destination, $filename);
            }

            if ($material_number == 'null') {
                $material_number = null;
            }

            if ($material_description == 'null') {
                $material_description = null;
            }

            $update = DB::table('qa_documents')->where('document_id',$document_id)->update([
                'vendor' => $vendor,
                'category' => $category,
                'material_number' => $material_number,
                'material_description' => $material_description,
                'document_number' => $document_number,
                'title' => $title,
                'version' => $version,
                'version_date' => $version_date,
                'status' => $status,
                'file_name_pdf' => $filename,
                'created_by' => Auth::user()->id,
                'updated_at' => $this->timestamp,
            ]);
            $response = array(
                'status' => true,
            );
            return Response::json($response);
        } catch (\Exception $e) {
            $response = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
            return Response::json($response);
        }
    }

    public function deleteDocumentControl(Request $request)
    {
        try {
            $delete = DB::table('qa_documents')->where('document_id',$request->get('document_id'))->delete();
            $response = array(
                'status' => true,
            );
            return Response::json($response);
        } catch (\Exception $e) {
            $response = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
            return Response::json($response);
        }
    }

    public function indexTroubleInfo($vendor)
    {
        $mail_to = '';
        $cc = '';
        if ($vendor == 'arisa') {
            $mail_to .= 'anang.zahroni@music.yamaha.com;';
            $mail_to .= 'rozaki@music.yamaha.com;';
            $mail_to .= 'eko.prasetyo.wicaksono@music.yamaha.com';
            $cc .= 'imbang.prasetyo@music.yamaha.com';
            $title = 'Trouble Info - PT. ARISAMANDIRI PRATAMA';
            $vendor_name = 'PT. ARISAMANDIRI PRATAMA';
            $page = 'Trouble Info';
            $title_jp = '';
        }

        if ($vendor == 'true') {
            $mail_to .= 'mukhammad.furqoon@music.yamaha.com;';
            $mail_to .= 'wachid.hasyim@music.yamaha.com;';
            $mail_to .= 'nanang.kurniawan@music.yamaha.com;';
            $mail_to .= 'tofik.nur.hidayat@music.yamaha.com;';
            $mail_to .= 'ardiyanto@music.yamaha.com';
            $cc .= 'imbang.prasetyo@music.yamaha.com';
            $title = 'Trouble Info - PT. TRUE INDONESIA';
            $vendor_name = 'PT. TRUE INDONESIA';
            $page = 'Trouble Info';
            $title_jp = '';
        }

        if ($vendor == 'crestec') {
            $mail_to .= 'anang.zahroni@music.yamaha.com;';
            $mail_to .= 'rozaki@music.yamaha.com;';
            $mail_to .= 'eko.prasetyo.wicaksono@music.yamaha.com;';
            $mail_to .= 'mukhammad.furqoon@music.yamaha.com;';
            $mail_to .= 'wachid.hasyim@music.yamaha.com;';
            $mail_to .= 'nanang.kurniawan@music.yamaha.com;';
            $mail_to .= 'tofik.nur.hidayat@music.yamaha.com';
            $cc .= 'imbang.prasetyo@music.yamaha.com';
            $title = 'Trouble Info - PT. CRESTEC INDONESIA';
            $vendor_name = 'PT. CRESTEC INDONESIA';
            $page = 'Trouble Info';
            $title_jp = '';
        }

        if ($vendor == 'rk') {
            $mail_to .= 'mukhammad.furqoon@music.yamaha.com;';
            $mail_to .= 'wachid.hasyim@music.yamaha.com;';
            $mail_to .= 'nanang.kurniawan@music.yamaha.com;';
            $mail_to .= 'tofik.nur.hidayat@music.yamaha.com;';
            $mail_to .= 'ardiyanto@music.yamaha.com';
            $cc .= 'imbang.prasetyo@music.yamaha.com';
            $title = 'Trouble Info - CV. RAHAYU KUSUMA';
            $vendor_name = 'CV. RAHAYU KUSUMA';
            $page = 'Trouble Info';
            $title_jp = '';
        }

        $material = DB::SELECT("SELECT
            a.material_number,
            a.material_description,
            LOWER(a.vendor) AS vendor 
            FROM
            (
                (SELECT material_number, material_description, 'rk' AS vendor FROM `vendor_materials` WHERE category = 'FINISH MATERIAL') UNION ALL
            (SELECT material_number, material_description, vendor_shortname AS vendor FROM qa_materials)) a 
            WHERE LOWER(a.vendor) = '".$vendor."'
            GROUP BY
            a.material_number,
            a.material_description,
            a.vendor");

        return view('qa.trouble.index_report', array(
            'title' => $title,
            'vendor' => $vendor,
            'vendor_name' => $vendor_name,
            'title_jp' => $title_jp,
            'mail_to' => $mail_to,
            'cc' => $cc,
            'material' => $material,
            'material2' => $material,
        ))->with('page', $page)->with('head', $page);
    }

    function fetchTroubleinfo($vendor, Request $request) {
        try {
            $trouble_info = DB::table('trouble_infos')->where('vendor_shortname',$vendor);

            if ($request->get('category') != '') {
                $trouble_info = $trouble_info->where('category',$request->get('category'));
            }
            $trouble_info = $trouble_info->get();
            $response = array(
                'status' => true,
                'trouble_info' => $trouble_info
            );
            return Response::json($response);
        } catch (\Exception $e) {
            $response = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
            return Response::json($response);
        }
    }
    
    function inputTroubleInfo(Request $request) {
        try {
            $vendor = $request->get('vendor');
            $vendor_name = $request->get('vendor_name');
            $category = $request->get('category');
            $trouble = $request->get('trouble');
            $date_from = $request->get('date_from');
            $date_to = $request->get('date_to');
            $mail_tos = explode(';',$request->get('mail_to'));
            $ccs = $request->get('cc');
            $supporting = $request->get('supporting');
            $material = $request->get('material');
            if($category == 'Quality' || $category == 'Delivery' || $category == 'Material') {
                $supporting = str_replace('(Khamdan)',' - ',$supporting);
            }
            $material = str_replace('(Khamdan)',' - ',$material);
            $effect = $request->get('effect');
            // $handling = $request->get('handling');
            // $results = $request->get('results');
            $surat_jalan = $request->get('surat_jalan');

            $handling_choice = $request->get('handling_choice');
            $qty_wip = $request->get('qty_wip');
            $qty_delivery = $request->get('qty_delivery');
            $qty_check = $request->get('qty_check');
            $qty_ng = $request->get('qty_ng');
            $qty_ok = $request->get('qty_ok');

            $input = DB::table('trouble_infos')->insert([
                'vendor_shortname' => $vendor,
                'category' => $category,
                'trouble' => $trouble,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'supporting' => $supporting,
                'material' => $material,
                'handling_choice' => $handling_choice,
                'qty_wip' => $qty_wip,
                'qty_delivery' => $qty_delivery,
                'qty_check' => $qty_check,
                'qty_ng' => $qty_ng,
                'qty_ok' => $qty_ok,
                'effect' => $effect,
                // 'handling' => $handling,
                // 'results' => $results,
                'surat_jalan' => $surat_jalan,
                'created_by' => Auth::user()->id,
                'created_at' => $this->timestamp,
                'updated_at' => $this->timestamp,
            ]);

            $mail_to = [];
            $cc = [];
            $bcc = [];
            $data = array(
                'vendor' => $vendor,
                'vendor_name' => $vendor_name,
                'category' => $category,
                'trouble' => $trouble,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'supporting' => $supporting,
                'effect' => $effect,
                'material' => $material,
                'handling_choice' => $handling_choice,
                'qty_wip' => $qty_wip,
                'qty_delivery' => $qty_delivery,
                'qty_check' => $qty_check,
                'qty_ng' => $qty_ng,
                'qty_ok' => $qty_ok,
                // 'handling' => $handling,
                // 'results' => $results,
                'surat_jalan' => $surat_jalan,
            );
            
            array_push($cc,'silvy.firliani@music.yamaha.com');
            array_push($cc,'yusli.erwandi@music.yamaha.com');
            array_push($cc,'yayuk.wahyuni@music.yamaha.com');
            array_push($cc,$ccs);
            array_push($mail_to,'istiqomah@music.yamaha.com');
            array_push($mail_to,'jihan.rusdi@music.yamaha.com');
            array_push($mail_to,'hanin.hamidi@music.yamaha.com');
            array_push($mail_to,'nunik.erwantiningsih@music.yamaha.com');
            array_push($mail_to,'sulismawati@music.yamaha.com');
            array_push($mail_to,'amelia.novrinta@music.yamaha.com');
            array_push($mail_to,'shega.erik.wicaksono@music.yamaha.com');
            array_push($mail_to,'erlangga.kharisma@music.yamaha.com');
            array_push($mail_to,'lukmannul.arif@music.yamaha.com');
            array_push($mail_to,'noviera.prasetyarini@music.yamaha.com');
            array_push($mail_to,'sutrisno@music.yamaha.com');
            array_push($mail_to,'rani.nurdiyana.sari@music.yamaha.com');
            array_push($mail_to,'basyiruddin.muchamad@music.yamaha.com');
            array_push($mail_to,'abdissalam.saidi@music.yamaha.com');
            foreach ($mail_tos as $mail_toss) {
                array_push($mail_to,$mail_toss);
            }
            
            array_push($bcc,'ympi-mis-ML@music.yamaha.com');

            Mail::to($mail_to)
            ->cc($cc,'CC')
            ->bcc($bcc,'BCC')
            ->send(new SendEmail($data, 'trouble_info'));

            $response = array(
                'status' => true,
            );
            return Response::json($response);
        } catch (\Exception $e) {
            $response = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
            return Response::json($response);
        }
    }

    function inputTroubleInfoHandling(Request $request) {
        try {
            $vendor = $request->get('vendor');
            $vendor_name = $request->get('vendor_name');
            $id = $request->get('id');
            $handling = $request->get('handling');
            $results = $request->get('results');
            $mail_tos = explode(';',$request->get('mail_to'));
            $ccs = $request->get('cc');

            $data = DB::table('trouble_infos')
            ->where('id',$id)
            ->first();

            $input = DB::table('trouble_infos')
            ->where('id',$id)
            ->update([
                'handling' => $handling,
                'results' => $results,
                'updated_at' => $this->timestamp,
            ]);

            $mail_to = [];
            $cc = [];
            $bcc = [];
            $data = array(
                'vendor' => $vendor,
                'vendor_name' => $vendor_name,
                'category' => $data->category,
                'trouble' => $data->trouble,
                'date_from' => $data->date_from,
                'date_to' => $data->date_to,
                'supporting' => $data->supporting,
                'effect' => $data->effect,
                'material' => $data->material,
                'handling_choice' => $data->handling_choice,
                'qty_wip' => $data->qty_wip,
                'qty_delivery' => $data->qty_delivery,
                'qty_check' => $data->qty_check,
                'qty_ng' => $data->qty_ng,
                'qty_ok' => $data->qty_ok,
                'surat_jalan' => $data->surat_jalan,
                'handling' => $handling,
                'results' => $results,
            );
            
            array_push($cc,'silvy.firliani@music.yamaha.com');
            array_push($cc,'yusli.erwandi@music.yamaha.com');
            array_push($cc,'yayuk.wahyuni@music.yamaha.com');
            array_push($cc,$ccs);
            array_push($mail_to,'istiqomah@music.yamaha.com');
            array_push($mail_to,'jihan.rusdi@music.yamaha.com');
            array_push($mail_to,'hanin.hamidi@music.yamaha.com');
            array_push($mail_to,'nunik.erwantiningsih@music.yamaha.com');
            array_push($mail_to,'sulismawati@music.yamaha.com');
            array_push($mail_to,'amelia.novrinta@music.yamaha.com');
            array_push($mail_to,'shega.erik.wicaksono@music.yamaha.com');
            array_push($mail_to,'erlangga.kharisma@music.yamaha.com');
            array_push($mail_to,'lukmannul.arif@music.yamaha.com');
            array_push($mail_to,'noviera.prasetyarini@music.yamaha.com');
            array_push($mail_to,'sutrisno@music.yamaha.com');
            array_push($mail_to,'rani.nurdiyana.sari@music.yamaha.com');
            array_push($mail_to,'basyiruddin.muchamad@music.yamaha.com');
            array_push($mail_to,'abdissalam.saidi@music.yamaha.com');
            foreach ($mail_tos as $mail_toss) {
                array_push($mail_to,$mail_toss);
            }
            
            array_push($bcc,'ympi-mis-ML@music.yamaha.com');

            Mail::to($mail_to)
            ->cc($cc,'CC')
            ->bcc($bcc,'BCC')
            ->send(new SendEmail($data, 'trouble_info_handling'));

            $response = array(
                'status' => true,
            );
            return Response::json($response);
        } catch (\Exception $e) {
            $response = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
            return Response::json($response);
        }
    }

    function updateTroubleInfo(Request $request) {
        try {
            $vendor = $request->get('vendor');
            $vendor_name = $request->get('vendor_name');
            $id = $request->get('id');
            $category = $request->get('category');
            $trouble = $request->get('trouble');
            $date_from = $request->get('date_from');
            $date_to = $request->get('date_to');
            $mail_tos = explode(';',$request->get('mail_to'));
            $ccs = $request->get('cc');
            $supporting = $request->get('supporting');
            $material = $request->get('material');
            if($category == 'Quality' || $category == 'Delivery' || $category == 'Material') {
                $supporting = str_replace('(Khamdan)',' - ',$supporting);
            }
            $material = str_replace('(Khamdan)',' - ',$material);
            $effect = $request->get('effect');
            $handling = $request->get('handling');
            $results = $request->get('results');
            $surat_jalan = $request->get('surat_jalan');    

            $handling_choice = $request->get('handling_choice');
            $qty_wip = $request->get('qty_wip');
            $qty_delivery = $request->get('qty_delivery');
            $qty_check = $request->get('qty_check');
            $qty_ng = $request->get('qty_ng');
            $qty_ok = $request->get('qty_ok');

            $data_before = DB::table('trouble_infos')->where('id',$id)->first();
            
            $update = DB::table('trouble_infos')->where('id',$id)->update([
                'category' => $category,
                'trouble' => $trouble,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'supporting' => $supporting,
                'effect' => $effect,
                'material' => $material,
                'handling_choice' => $handling_choice,
                'qty_wip' => $qty_wip,
                'qty_delivery' => $qty_delivery,
                'qty_check' => $qty_check,
                'qty_ng' => $qty_ng,
                'qty_ok' => $qty_ok,
                'handling' => $handling,
                'results' => $results,
                'surat_jalan' => $surat_jalan,
                'created_by' => Auth::user()->id,
                'updated_at' => $this->timestamp,
            ]);

            $mail_to = [];
            $cc = [];
            $bcc = [];
            $data = array(
                'vendor' => $vendor,
                'vendor_name' => $vendor_name,
                'category' => $category,
                'trouble' => $trouble,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'supporting' => $supporting,
                'effect' => $effect,
                'material' => $material,
                'handling_choice' => $handling_choice,
                'qty_wip' => $qty_wip,
                'qty_delivery' => $qty_delivery,
                'qty_check' => $qty_check,
                'qty_ng' => $qty_ng,
                'qty_ok' => $qty_ok,
                'handling' => $handling,
                'results' => $results,
                'surat_jalan' => $surat_jalan,
                'data_before' => $data_before,
            );

            array_push($cc,'silvy.firliani@music.yamaha.com');
            array_push($cc,'yusli.erwandi@music.yamaha.com');
            array_push($cc,'yayuk.wahyuni@music.yamaha.com');
            array_push($cc,$ccs);
            array_push($mail_to,'istiqomah@music.yamaha.com');
            array_push($mail_to,'jihan.rusdi@music.yamaha.com');
            array_push($mail_to,'hanin.hamidi@music.yamaha.com');
            array_push($mail_to,'nunik.erwantiningsih@music.yamaha.com');
            array_push($mail_to,'sulismawati@music.yamaha.com');
            array_push($mail_to,'amelia.novrinta@music.yamaha.com');
            array_push($mail_to,'shega.erik.wicaksono@music.yamaha.com');
            array_push($mail_to,'erlangga.kharisma@music.yamaha.com');
            array_push($mail_to,'lukmannul.arif@music.yamaha.com');
            array_push($mail_to,'noviera.prasetyarini@music.yamaha.com');
            array_push($mail_to,'sutrisno@music.yamaha.com');
            array_push($mail_to,'rani.nurdiyana.sari@music.yamaha.com');
            array_push($mail_to,'basyiruddin.muchamad@music.yamaha.com');
            array_push($mail_to,'abdissalam.saidi@music.yamaha.com');
            foreach ($mail_tos as $mail_toss) {
                array_push($mail_to,$mail_toss);
            }
            
            array_push($bcc,'ympi-mis-ML@music.yamaha.com');

            Mail::to($mail_to)
            ->cc($cc,'CC')
            ->bcc($bcc,'BCC')
            ->send(new SendEmail($data, 'trouble_info_change'));

            $response = array(
                'status' => true,
            );
            return Response::json($response);
        } catch (\Exception $e) {
            $response = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
            return Response::json($response);
        }
    }

    function deleteTroubleInfo(Request $request) {
        try {
            $id = $request->get('id');
            $vendor = $request->get('vendor');
            $vendor_name = $request->get('vendor_name');
            $mail_tos = explode(';',$request->get('mail_to'));
            $ccs = $request->get('cc');

            $data_before = DB::table('trouble_infos')->where('id',$id)->first();

            $delete = DB::table('trouble_infos')->where('id',$id)->delete();

            $mail_to = [];
            $cc = [];
            $bcc = [];
            $data = array(
                'vendor' => $vendor,
                'vendor_name' => $vendor_name,
                'data_before' => $data_before,
            );

            array_push($cc,'silvy.firliani@music.yamaha.com');
            array_push($cc,'yusli.erwandi@music.yamaha.com');
            array_push($cc,'yayuk.wahyuni@music.yamaha.com');
            array_push($cc,$ccs);
            array_push($mail_to,'istiqomah@music.yamaha.com');
            array_push($mail_to,'jihan.rusdi@music.yamaha.com');
            array_push($mail_to,'hanin.hamidi@music.yamaha.com');
            array_push($mail_to,'nunik.erwantiningsih@music.yamaha.com');
            array_push($mail_to,'sulismawati@music.yamaha.com');
            array_push($mail_to,'amelia.novrinta@music.yamaha.com');
            array_push($mail_to,'shega.erik.wicaksono@music.yamaha.com');
            array_push($mail_to,'erlangga.kharisma@music.yamaha.com');
            array_push($mail_to,'lukmannul.arif@music.yamaha.com');
            array_push($mail_to,'noviera.prasetyarini@music.yamaha.com');
            array_push($mail_to,'sutrisno@music.yamaha.com');
            array_push($mail_to,'rani.nurdiyana.sari@music.yamaha.com');
            array_push($mail_to,'basyiruddin.muchamad@music.yamaha.com');
            array_push($mail_to,'abdissalam.saidi@music.yamaha.com');
            foreach ($mail_tos as $mail_toss) {
                array_push($mail_to,$mail_toss);
            }
            
            array_push($bcc,'ympi-mis-ML@music.yamaha.com');

            Mail::to($mail_to)
            ->cc($cc,'CC')
            ->bcc($bcc,'BCC')
            ->send(new SendEmail($data, 'trouble_info_delete'));

            $response = array(
                'status' => true,
            );
            return Response::json($response);
        } catch (\Exception $e) {
            $response = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
            return Response::json($response);
        }
    }
}
