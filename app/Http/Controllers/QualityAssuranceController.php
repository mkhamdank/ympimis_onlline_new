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
}
