<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Response;

class workshopController extends Controller
{
	public function indexCheckMolding()
	{
		$title = 'Audit Molding Vendor';
		$title_jp = '??';

		return view('workshop.check_molding.index', array(
					'title' => $title,
					'title_jp' => $title_jp,
				)
				)->with('page', 'Workshop Audit Molding');
	}

	public function fetchCheckMoldingMonitoring(Request $request)
	{
		try {
			$datas = db::table('pe_molding_findings');
			$data_all = db::table('pe_molding_findings');

			if (strlen($request->get('datefrom') > 0)) {
				$datas = $datas->where('check_date', '>=', $request->get('datefrom'));
				$data_all = $data_all->where('check_date', '>=', $request->get('datefrom'));
			}

			if (strlen($request->get('dateto') > 0)) {
				$datas = $datas->where('check_date', '<=', $request->get('dateto'));
				$data_all = $data_all->where('check_date', '<=', $request->get('dateto'));
			}

			if ($request->get('status')) {
				$datas = $datas->whereIn('status', $request->get('status'));
				$data_all = $data_all->whereIn('status', $request->get('status'));
			} else {
				$datas = $datas->whereIn('status', ["Open", "Temporary Close", "In-Progress", "Close"]);
				$data_all = $data_all->whereIn('status', ["Open", "Temporary Close", "In-Progress", "Close"]);
			}

			$datas = $datas->select('check_date', 'status', db::raw('count(id) as jml'))
				->groupBy('check_date', 'status')
				->get();

			$data_all = $data_all->select("pe_molding_findings.id", "check_date", "molding_name", "part_name", "problem", "problem_att", "pic", "handling_temporary", "handling_att", "note_problem", "close_date", "status", "pe_molding_findings.remark")
				->orderBy("pe_molding_findings.id", "ASC")
				->get();

			$response = array(
				'status' => true,
				'datas' => $datas,
				'data_all' => $data_all,
			);
			return Response::json($response);
		} catch (Exception $e) {
			$response = array(
				'status' => false,
				'message' => $e->getMessage()
			);
			return Response::json($response);
		}
	}

	public function indexCreateCheckMolding()
	{
		$title = 'Audit Molding Vendor';
		$title_jp = '??';

		$cek_poin = db::table('pe_molding_check_masters')
			->select('check_point', 'standard', 'how_check', 'handle', db::raw("SPLIT_STRING(check_point, ' - ', 1) as poin_cek"), db::raw("SPLIT_STRING(standard, ' - ', 1) as std"), db::raw("SPLIT_STRING(how_check, ' - ', 1) as how"), db::raw("SPLIT_STRING(handle, ' - ', 1) as handle2"))
			->get();

		$molding = db::table('pe_molding_masters')
			->select('molding_name', 'mold_number', 'molding_type')
			->get();

		$pic = db::table('employee_datas')->select('employee_id', db::raw('employee_name as name'))->orderBy('employee_name', 'asc')->get();

		return view('workshop.check_molding.index_form', array(
					'title' => $title,
					'title_jp' => $title_jp,
					'check_points' => $cek_poin,
					'moldings' => $molding,
					'pics' => $pic
				)
				)->with('page', 'Workshop Audit Molding');
	}

	public function postCheckMolding(Request $request)
	{
		try {
			$before1_name = null;
			$before2_name = null;
			$after1_name = null;
			$after2_name = null;
			$aktifitas1_name = null;
			$aktifitas2_name = null;

			$insert_master = DB::table('pe_molding_checks')->insertGetId([
				'check_date' => $request->get('date'),
				'molding_name' => $request->get('molding_name'),
				'molding_type' => $request->get('molding_type'),
				'pic' => $request->get('pic'),
				'location' => $request->get('location'),
				'conclusion' => 'OK',
				'status' => 'Open',
				'created_by' => Auth::user()->username,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			]);

			$parts = explode(',', $request->get('part'));
			$cek_poin = explode(',', $request->get('cek_poin'));
			$judgement = explode(',', $request->get('judgement'));

			$cek_id = $insert_master;

			for ($i = 0; $i < count($parts); $i++) {

				$cek_data = db::table('pe_molding_check_masters')
					->where('check_point', '=', $cek_poin[$i])
					->select('check_point', 'standard', 'how_check', 'handle')
					->first();

				$tujuan_upload = 'workshop/Audit_Molding/Check_Molding/check_att';

				// before
				if ($request->file('before1_' . $i) != null) {
					$before1 = $request->file('before1_' . $i);
					$before1_file = $before1->getClientOriginalName();
					// $before1_filename = pathinfo($before1_file, PATHINFO_FILENAME);
					$before1_ext = pathinfo($before1_file, PATHINFO_EXTENSION);

					$before1_name = md5('Before1_' . date('YmdHis')) . '.' . $before1_ext;
					$before1->move($tujuan_upload, $before1_name);
				}

				if ($request->file('before2_' . $i) != null) {
					$before2 = $request->file('before2_' . $i);
					$before2_file = $before2->getClientOriginalName();
					// $before2_filename = pathinfo($before2_file, PATHINFO_FILENAME);
					$before2_ext = pathinfo($before2_file, PATHINFO_EXTENSION);

					$before2_name = md5('Before2_' . date('YmdHis')) . '.' . $before2_ext;
					$before2->move($tujuan_upload, $before2_name);
				}

				// After
				if ($request->file('after1_' . $i) != null) {
					$after1 = $request->file('after1_' . $i);
					$after1_file = $after1->getClientOriginalName();
					// $after1_filename = pathinfo($after1_file, PATHINFO_FILENAME);
					$after1_ext = pathinfo($after1_file, PATHINFO_EXTENSION);

					$after1_name = md5('after1_' . date('YmdHis')) . '.' . $after1_ext;
					$after1->move($tujuan_upload, $after1_name);
				}

				if ($request->file('after2_' . $i) != null) {
					$after2 = $request->file('after2_' . $i);
					$after2_file = $after2->getClientOriginalName();
					// $after2_filename = pathinfo($after2_file, PATHINFO_FILENAME);
					$after2_ext = pathinfo($after2_file, PATHINFO_EXTENSION);

					$after2_name = md5('after2_' . date('YmdHis')) . '.' . $after2_ext;
					$after2->move($tujuan_upload, $after2_name);
				}

				// Activity
				if ($request->file('aktifitas1_' . $i) != null) {
					$aktifitas1 = $request->file('aktifitas1_' . $i);
					$aktifitas1_file = $aktifitas1->getClientOriginalName();
					// $aktifitas1_filename = pathinfo($aktifitas1_file, PATHINFO_FILENAME);
					$aktifitas1_ext = pathinfo($aktifitas1_file, PATHINFO_EXTENSION);

					$aktifitas1_name = md5('aktifitas1_' . date('YmdHis')) . '.' . $aktifitas1_ext;
					$aktifitas1->move($tujuan_upload, $aktifitas1_name);
				}

				if ($request->file('aktifitas2_' . $i) != null) {
					$aktifitas2 = $request->file('aktifitas2_' . $i);
					$aktifitas2_file = $aktifitas2->getClientOriginalName();
					// $aktifitas2_filename = pathinfo($aktifitas2_file, PATHINFO_FILENAME);
					$aktifitas2_ext = pathinfo($aktifitas2_file, PATHINFO_EXTENSION);

					$aktifitas2_name = md5('aktifitas2_' . date('YmdHis')) . '.' . $aktifitas2_ext;
					$aktifitas2->move($tujuan_upload, $aktifitas2_name);
				}

				$insert_detail = DB::table('pe_molding_check_details')->insert([
					'check_id' => $cek_id,
					'part_name' => $parts[$i],
					'point_check' => $cek_poin[$i],
					'standard' => $cek_data->standard,
					'how_check' => $cek_data->how_check,
					'handle' => $cek_data->handle,
					'photo_before1' => $before1_name,
					'photo_before2' => $before2_name,
					'photo_after1' => $after1_name,
					'photo_after2' => $after2_name,
					'photo_activity1' => $aktifitas1_name,
					'photo_activity2' => $aktifitas2_name,
					'judgement' => $judgement[$i],
					'note' => '',
					'status' => '',
					'created_by' => Auth::user()->username,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				]);
			}

			$response = array(
				'status' => true,
			);
			return Response::json($response);
		} catch (Exception $e) {
			$response = array(
				'status' => false,
				'message' => $e->getMessage()
			);
			return Response::json($response);
		}
	}

	public function postFindingMolding(Request $request)
	{
		try {
			$tujuan_upload = 'workshop/Audit_Molding/Check_Molding/problem_att';

			$problem_att = null;
			$handling_att = null;

			// Permasalahan
			if ($request->file('permasalahan1') != null) {
				$permasalahan1 = $request->file('permasalahan1');
				$permasalahan1_file = $permasalahan1->getClientOriginalName();
				$permasalahan1_ext = pathinfo($permasalahan1_file, PATHINFO_EXTENSION);

				$permasalahan1_name = md5('permasalahan1' . date('YmdHis')) . '.' . $permasalahan1_ext;
				$permasalahan1->move($tujuan_upload, $permasalahan1_name);

				$problem_att .= $permasalahan1_name;
			}

			if ($request->file('permasalahan2') != null) {
				$permasalahan2 = $request->file('permasalahan2');
				$permasalahan2_file = $permasalahan2->getClientOriginalName();
				$permasalahan2_ext = pathinfo($permasalahan2_file, PATHINFO_EXTENSION);

				$permasalahan2_name = md5('permasalahan2' . date('YmdHis')) . '.' . $permasalahan2_ext;
				$permasalahan2->move($tujuan_upload, $permasalahan2_name);

				$problem_att .= ',' . $permasalahan2_name;
			}

			// Perbaikan
			if ($request->file('perbaikan1') != null) {
				$perbaikan1 = $request->file('perbaikan1');
				$perbaikan1_file = $perbaikan1->getClientOriginalName();
				$perbaikan1_ext = pathinfo($perbaikan1_file, PATHINFO_EXTENSION);

				$perbaikan1_name = md5('perbaikan1' . date('YmdHis')) . '.' . $perbaikan1_ext;
				$perbaikan1->move($tujuan_upload, $perbaikan1_name);

				$handling_att .= $perbaikan1_name;
			}

			if ($request->file('perbaikan2') != null) {
				$perbaikan2 = $request->file('perbaikan2');
				$perbaikan2_file = $perbaikan2->getClientOriginalName();
				$perbaikan2_ext = pathinfo($perbaikan2_file, PATHINFO_EXTENSION);

				$perbaikan2_name = md5('perbaikan2' . date('YmdHis')) . '.' . $perbaikan2_ext;
				$perbaikan2->move($tujuan_upload, $perbaikan2_name);

				$handling_att .= ',' . $perbaikan2_name;
			}

			$insert_detail = DB::table('pe_molding_findings')->insert([
				'check_date' => $request->get('date'),
				'pic' => $request->get('pic'),
				'molding_name' => $request->get('molding_name'),
				'molding_type' => $request->get('molding_type'),
				'part_name' => $request->get('part_name'),
				'problem' => $request->get('problem'),
				'problem_att' => $problem_att,
				'handling_temporary' => $request->get('handling_temporary'),
				'handling_att' => $handling_att,
				'note_problem' => $request->get('notes'),
				'status' => $request->get('status'),
				'created_by' => Auth::user()->username,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			]);

			$response = array(
				'status' => true,
			);
			return Response::json($response);
		} catch (Exception $e) {
			$response = array(
				'status' => false,
				'message' => $e->getMessage()
			);
			return Response::json($response);
		}
	}

	public function fetchCheckMolding(Request $request)
	{
		$datas = db::table('pe_molding_checks')
			->leftJoin('pe_molding_check_details', 'pe_molding_checks.id', '=', 'pe_molding_check_details.check_id');

		if (strlen($request->get('date_from')) > 0) {
			$datas = $datas->where('check_date', '>=', $request->get('date_from'));
		}

		if (strlen($request->get('date_to')) > 0) {
			$datas = $datas->where('check_date', '<=', $request->get('date_to'));
		}

		if (strlen($request->get('molding_select')) > 0) {
			$datas = $datas->where('molding_name', '=', $request->get('molding_select'));
		}

		$datas = $datas->select('pe_molding_checks.id', 'pe_molding_checks.check_date', 'pe_molding_checks.molding_name', 'pic', 'conclusion', 'pe_molding_check_details.part_name', 'pe_molding_check_details.point_check', 'judgement', 'photo_before1', 'photo_before2', 'photo_after1', 'photo_after2', 'photo_activity1', 'photo_activity2', 'note', 'status')->get();

		$emp = db::table('employee_datas')->get();

		$response = array(
			'status' => true,
			'datas' => $datas,
			'employees' => $emp
		);
		return Response::json($response);
	}

	public function fetchFindingMolding(Request $request)
	{
		try {
			$datas = db::table('pe_molding_findings');

			if (strlen($request->get('date_from')) > 0) {
				$datas = $datas->where('check_date', '>=', $request->get('date_from'));
			}

			if (strlen($request->get('date_to')) > 0) {
				$datas = $datas->where('check_date', '<=', $request->get('date_to'));
			}

			if (strlen($request->get('molding_select')) > 0) {
				$datas = $datas->where('molding_name', '=', $request->get('molding_select'));
			}

			$datas = $datas->select('pe_molding_findings.id', 'pe_molding_findings.check_date', 'pe_molding_findings.molding_name', 'part_name', 'problem', 'problem_att', 'handling_temporary', 'handling_att', 'note_problem', 'status', 'close_date')
				->get();

			$response = array(
				'status' => true,
				'datas' => $datas
			);
			return Response::json($response);
		} catch (\Throwable $th) {
			$response = array(
				'status' => false,
				'message' => $th
			);
			return Response::json($response);
		}
	}

	public function fetchHandlingLog(Request $request)
	{
		try {
			$datas = db::table('pe_molding_handlings');

			if (strlen($request->get('id')) > 0) {
				$datas = $datas->where('finding_id', '=', $request->get('id'));
			}

			if (strlen($request->get('date_from')) > 0) {
				$datas = $datas->where('check_date', '>=', $request->get('date_from'));
			}

			if (strlen($request->get('date_to')) > 0) {
				$datas = $datas->where('check_date', '<=', $request->get('date_to'));
			}

			$datas = $datas->orderBy('id', 'DESC')->get();

			$response = array(
				'status' => true,
				'datas' => $datas
			);
			return Response::json($response);
		} catch (\Throwable $th) {
			$response = array(
				'status' => false,
				'message' => $th
			);
			return Response::json($response);
		}
	}

	public function postHandling(Request $request)
	{
		try {
			$handling_att1 = null;
			$handling_att2 = null;

			$tujuan_upload = 'workshop/Audit_Molding/Check_Molding/handling_att';

			// Perbaikan
			if ($request->file('perbaikan1') != null) {
				$perbaikan1 = $request->file('perbaikan1');
				$perbaikan1_file = $perbaikan1->getClientOriginalName();
				$perbaikan1_ext = pathinfo($perbaikan1_file, PATHINFO_EXTENSION);

				$perbaikan1_name = md5('perbaikan1' . date('YmdHis')) . '.' . $perbaikan1_ext;
				$perbaikan1->move($tujuan_upload, $perbaikan1_name);

				$handling_att1 = $perbaikan1_name;
			}

			if ($request->file('perbaikan2') != null) {
				$perbaikan2 = $request->file('perbaikan2');
				$perbaikan2_file = $perbaikan2->getClientOriginalName();
				$perbaikan2_ext = pathinfo($perbaikan2_file, PATHINFO_EXTENSION);

				$perbaikan2_name = md5('perbaikan2' . date('YmdHis')) . '.' . $perbaikan2_ext;
				$perbaikan2->move($tujuan_upload, $perbaikan2_name);

				$handling_att2 = $perbaikan2_name;
			}

			$insert_detail = DB::table('pe_molding_handlings')->insert([
				'finding_id' => $request->get('finding_id'),
				'check_date' => $request->get('check_date'),
				'handling_date' => date("Y-m-d"),
				'pic' => $request->get('pic'),
				'molding_name' => $request->get('molding_name'),
				'part_name' => $request->get('part_name'),
				'handling_note' => $request->get('handling_note'),
				'handling_att1' => $handling_att1,
				'handling_att2' => $handling_att2,
				'status' => $request->get('status'),
				'created_by' => Auth::user()->username,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			]);

			$response = array(
				'status' => true				
			);
			return Response::json($response);
		} catch (\Throwable $th) {
			$response = array(
				'status' => false,
				'message' => $th
			);
			return Response::json($response);
		}
	}
}