<?php

namespace App\Http\Controllers;

use App\CodeGenerator;
use App\Http\Controllers\Controller;
use App\Mail\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Response;

class InventoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->logistic = array(
            'telasati.murnomo.fitri@music.yamaha.com',
            'rudianto@music.yamaha.com',
            'indriana.kusumawati@music.yamaha.com'
        );
        $this->pch = array(
            'noviera.prasetyarini@music.yamaha.com',
            'bakhtiar.muslim@music.yamaha.com',
            'jihan.rusdi@music.yamaha.com',
            'nunik.erwantiningsih@music.yamaha.com',
        );
        $this->mis = array(
            'muhammad.ikhlas@music.yamaha.com',
        );

        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $http_user_agent = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/Word|Excel|PowerPoint|ms-office/i', $http_user_agent)) {
                // Prevent MS office products detecting the upcoming re-direct .. forces them to launch the browser to this link
                die();
            }
        }

    }

    public function indexDashboard()
    {

        if (strtoupper(Auth::user()->role_code) == 'RK' || strtoupper(Auth::user()->role_code) == 'MIS' || Auth::user()->role_code == 'E - Purchasing') {
            return view('vendor.dashboard', array(
                'title' => 'Dashboard',
                'title_jp' => '',
                'vendor_nickname' => 'RK',
                'vendor' => 'UD. RAHAYU KUSUMA',
            ))->with('page', 'Stock Control Dashboard');
        }

    }

    public function indexStockControl($role)
    {
        if (strtoupper($role) == 'RK') {
            return view('vendor.index_stock_control', array(
                'title' => 'Stock Control',
                'title_jp' => '',
                'vendor' => 'UD. RAHAYU KUSUMA',
                'role' => $role,
            ))->with('page', 'RK Stock Control');
        } else {
            return view('404');
        }
    }

    public function indexMaterialMaster($role)
    {

        $user_role = db::table('roles')
            ->where('role_code', $role)
            ->first();

        if (Auth::user()->role_code == 'E - Purchasing' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == strtoupper($role)) {

            return view('vendor.material_master', array(
                'title' => 'Material Master',
                'title_jp' => '',
                'vendor_nickname' => $role,
                'vendor' => $user_role->role_name,
            ))->with('page', 'RK Stock Control');

        } else {
            return view('404');
        }

    }

    public function indexMaterialBom($role)
    {

        $user_role = db::table('roles')
            ->where('role_code', $role)
            ->first();

        if (Auth::user()->role_code == 'E - Purchasing' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == strtoupper($role)) {

            return view('vendor.bom', array(
                'title' => 'BILL OF MATERIAL (BOM)',
                'title_jp' => '',
                'vendor_nickname' => $role,
                'vendor' => $user_role->role_name,
            ))->with('page', 'RK Stock Control');

        } else {
            return view('404');
        }

    }

    public function indexStockInquiry($role)
    {
        $user_role = db::table('roles')
            ->where('role_code', $role)
            ->first();

        if (Auth::user()->role_code == 'E - Purchasing' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == strtoupper($role)) {

            return view('vendor.inquiry', array(
                'title' => 'Stock Inquiry',
                'title_jp' => '',
                'vendor_nickname' => $role,
                'vendor' => $user_role->role_name,
            ))->with('page', 'RK Stock Control');

        } else {
            return view('404');
        }

    }

    public function indexTransactionLog($role)
    {
        $user_role = db::table('roles')
            ->where('role_code', $role)
            ->first();

        if (Auth::user()->role_code == 'E - Purchasing' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == strtoupper($role)) {

            return view('vendor.transaction_log', array(
                'title' => 'Transaction Log',
                'title_jp' => '',
                'vendor_nickname' => $role,
                'vendor' => $user_role->role_name,
            ))->with('page', 'RK Stock Control');

        } else {
            return view('404');
        }

    }

    public function indexForecast($role)
    {
        $user_role = db::table('roles')
            ->where('role_code', $role)
            ->first();

        if (Auth::user()->role_code == 'E - Purchasing' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == strtoupper($role)) {

            return view('vendor.forecast', array(
                'title' => 'YMPI Forecast',
                'title_jp' => '',
                'vendor_nickname' => $role,
                'vendor' => $user_role->role_name,
            ))->with('page', 'RK Stock Control');

        } else {
            return view('404');
        }

    }
    public function indexPlanDelivery($role)
    {
        $user_role = db::table('roles')
            ->where('role_code', $role)
            ->first();

        if (Auth::user()->role_code == 'E - Purchasing' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == strtoupper($role)) {

            return view('vendor.plan_delivery', array(
                'title' => 'YMPI Plan Delivery',
                'title_jp' => '',
                'vendor_nickname' => $role,
                'vendor' => $user_role->role_name,
            ))->with('page', 'RK Stock Control');

        } else {
            return view('404');
        }

    }

    public function indexDeliveryOrder($role)
    {
        $user_role = db::table('roles')
            ->where('role_code', $role)
            ->first();

        $materials = db::select("
            SELECT material_number, material_description, 'YMPI Material' AS material_type FROM vendor_material_matriks
            WHERE vendor_nickname = '" . strtoupper($role) . "'
            AND material_number = subcont_material_number
            UNION ALL
            SELECT material_number, material_description, 'SUBCONT Material' AS material_type FROM vendor_materials
            WHERE vendor_nickname = '" . strtoupper($role) . "'
            AND category = 'FINISH MATERIAL'");

        if (Auth::user()->role_code == 'E - Purchasing' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == strtoupper($role)) {

            return view('vendor.delivery_order', array(
                'title' => 'Shipment',
                'title_jp' => '',
                'materials' => $materials,
                'vendor_nickname' => $role,
                'vendor' => $user_role->role_name,
            ))->with('page', 'RK Stock Control');

        } else {
            return view('404');
        }

    }

    public function indexDeliveryOrderBc()
    {

        return view('logistic.delivery_order', array(
            'title' => 'Delivery Order',
            'title_jp' => '',
        ))->with('page', 'RK Stock Control');

    }

    public function indexMrpSimulation($role)
    {
        $user_role = db::table('roles')
            ->where('role_code', $role)
            ->first();

        if (Auth::user()->role_code == 'E - Purchasing' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == strtoupper($role)) {

            $materials = db::table('vendor_materials')->get();
            $boms = db::table('vendor_boms')->get();
            $stocks = db::table('vendor_stocks')
                ->where('storage_location', 'RKWIP')
                ->select(
                    'material_number',
                    'material_description',
                    db::raw('SUM(stock) AS stock')
                )
                ->groupBy(
                    'material_number',
                    'material_description'
                )
                ->get();

            return view('vendor.mrp_simulation', array(
                'title' => 'MRP Simulation',
                'title_jp' => '',
                'vendor_nickname' => $role,
                'vendor' => $user_role->role_name,
                'materials' => $materials,
                'boms' => $boms,
                'stocks' => $stocks,
            ))->with('page', 'RK Stock Control');

        } else {
            return view('404');
        }

    }

    public function indexGoodsReceiptPage($role)
    {
        $user_role = db::table('roles')
            ->where('role_code', $role)
            ->first();

        $materials = db::table('vendor_materials')
            ->where('vendor_nickname', $role)
            ->where('category', 'SUPPORTING MATERIAL')
            ->get();

        $storage_locations = db::table('vendor_storage_locations')
            ->where('vendor_nickname', $role)
            ->where('category', 'WAREHOUSE')
            ->get();

        return view('vendor.goods_receipt', array(
            'title' => 'Goods Receipt',
            'title_jp' => '',
            'vendor_nickname' => $role,
            'vendor' => $user_role->role_name,
            'materials' => $materials,
            'storage_locations' => $storage_locations,
        ))->with('page', 'RK Stock Control');

    }

    public function indexCompletionPage($role)
    {
        $user_role = db::table('roles')
            ->where('role_code', $role)
            ->first();

        $materials = db::table('vendor_materials')
            ->where('vendor_nickname', $role)
            ->where('category', 'FINISH MATERIAL')
            ->get();

        $storage_locations = db::table('vendor_storage_locations')
            ->where('vendor_nickname', $role)
            ->where('category', 'WIP')
            ->get();

        return view('vendor.completion', array(
            'title' => 'Completion',
            'title_jp' => '',
            'vendor_nickname' => $role,
            'vendor' => $user_role->role_name,
            'materials' => $materials,
            'storage_locations' => $storage_locations,
        ))->with('page', 'RK Stock Control');
    }

    public function fetchPlanDelivery(Request $request)
    {

        $month = $request->get('month');
        if (strlen($month) <= 0) {
            $month = date('Y-m');
        }

        $material = db::table('vendor_materials')
            ->where('category', 'FINISH MATERIAL')
            ->where('vendor_nickname', $request->get('vendor_nickname'))
            ->get();

        $delivery = db::table('vendor_plan_deliveries')
            ->where('due_date', 'LIKE', '%' . $month . '%')
            ->where('vendor_nickname', $request->get('vendor_nickname'))
            ->select(
                'material_number',
                'material_description',
                'due_date',
                db::raw('date_format(due_date, "%d-%b") AS date'),
                'plan',
                'actual'
            )
            ->get();

        $calendar = db::table('weekly_calendars')
            ->where('week_date', 'LIKE', '%' . $month . '%')
            ->select(
                'weekly_calendars.*',
                db::raw('date_format(week_date, "%d-%b") AS date')
            )
            ->orderBy('week_date')
            ->get();

        $response = array(
            'status' => true,
            'month' => $month,
            'material' => $material,
            'delivery' => $delivery,
            'calendar' => $calendar,
        );
        return Response::json($response);

    }

    public function fetchMaterialMaster(Request $request)
    {

        $materials = db::table('vendor_materials')
            ->where('vendor_nickname', $request->get('vendor_nickname'))
            ->get();

        $response = array(
            'status' => true,
            'materials' => $materials,
        );
        return Response::json($response);

    }

    public function fetchAvailability(Request $request)
    {

        $type = db::select("SELECT DISTINCT category FROM vendor_boms");

        $policy = db::select("
            SELECT
                vendor_materials.material_number,
                vendor_materials.material_description,
                vendor_materials.category,
                boms.category AS material_type,
                vendor_materials.policy,
                COALESCE ( vendor_stocks.stock, 0 ) AS stock,
                ( COALESCE ( vendor_stocks.stock, 0 )/ vendor_materials.policy * 100 ) AS percentage
            FROM vendor_materials
                LEFT JOIN (
                    SELECT material_number, SUM(stock) AS stock FROM `vendor_stocks`
                    GROUP BY material_number
                    ) vendor_stocks
                    ON vendor_stocks.material_number = vendor_materials.material_number
                LEFT JOIN (
                    SELECT DISTINCT vendor_material_number, vendor_material_description, category
                    FROM vendor_boms
                    ) AS boms
                    ON boms.vendor_material_number = vendor_materials.material_number
            WHERE
                vendor_materials.category = 'SUPPORTING MATERIAL'
                AND vendor_materials.policy > 0");

        $percentage = [];
        for ($i = 0; $i < count($policy); $i++) {
            $row = array();
            $row['material_number'] = $policy[$i]->material_number;
            $row['material_description'] = $policy[$i]->material_description;
            $row['category'] = $policy[$i]->category;
            $row['material_type'] = $policy[$i]->material_type;
            $row['policy'] = $policy[$i]->policy;
            $row['stock'] = $policy[$i]->stock;
            $row['percentage'] = $policy[$i]->percentage;

            if ($policy[$i]->percentage == 0 || $policy[$i]->percentage == null) {
                $row['remark'] = '0%';
            } elseif ($policy[$i]->percentage < 100) {
                if ($policy[$i]->percentage < 30) {
                    $row['remark'] = '< 30%';
                } elseif ($policy[$i]->percentage < 70) {
                    $row['remark'] = '< 70%';
                } else {
                    $row['remark'] = '< 100%';
                }
            } elseif ($policy[$i]->percentage > 100) {
                if ($policy[$i]->percentage > 300) {
                    $row['remark'] = '> 300%';
                } elseif ($policy[$i]->percentage > 200) {
                    $row['remark'] = '> 200%';
                } else {
                    $row['remark'] = '> 100%';
                }
            }

            $percentage[] = (object) $row;
        }

        $response = array(
            'status' => true,
            'type' => $type,
            'percentage' => $percentage,
        );
        return Response::json($response);

    }

    public function fetchMaterialBom(Request $request)
    {

        $boms = db::table('vendor_boms')
            ->where('vendor_nickname', $request->get('vendor_nickname'))
            ->get();

        $response = array(
            'status' => true,
            'boms' => $boms,
        );
        return Response::json($response);

    }

    public function fetchStockInquiry(Request $request)
    {
        $stocks = db::table('vendor_stocks')
            ->leftJoin('vendor_materials', 'vendor_materials.material_number', '=', 'vendor_stocks.material_number')
            ->where('vendor_stocks.vendor_nickname', $request->get('vendor_nickname'))
            ->select(
                'vendor_stocks.*',
                'vendor_materials.category'
            )
            ->get();

        $response = array(
            'status' => true,
            'stocks' => $stocks,
        );
        return Response::json($response);

    }

    public function fetchTransactionLog(Request $request)
    {
        $log = db::table('vendor_transaction_logs')
            ->where('vendor_nickname', $request->get('vendor_nickname'))
            ->orderBy('created_at', 'DESC')
            ->get();

        $response = array(
            'status' => true,
            'log' => $log,
        );
        return Response::json($response);

    }

    public function fetchForecast(Request $request)
    {

        $materials = db::table('vendor_materials')
            ->where('category', 'FINISH MATERIAL')
            ->get();

        $calendars = db::table('weekly_calendars')
            ->where('week_date', '>=', date('Y-m-d'))
            ->where('week_date', '<=', date('Y-m-d', strtotime('+90 day')))
            ->select(
                db::raw('DATE_FORMAT(week_date, "%Y-%m") AS month'),
                db::raw('DATE_FORMAT(week_date, "%b-%y") AS month_text')
            )
            ->distinct()
            ->orderBy('week_date', 'ASC')
            ->get();

        $forecasts = db::table('vendor_forecasts')
            ->where(db::raw('DATE_FORMAT(forecast_month, "%Y-%m")'), '>=', date('Y-m'))
            ->where('vendor_nickname', $request->get('vendor_nickname'))
            ->get();

        $response = array(
            'status' => true,
            'materials' => $materials,
            'calendars' => $calendars,
            'forecasts' => $forecasts,
        );
        return Response::json($response);

    }

    public function fetchPlanDeliveryData(Request $request)
    {

        $month = $request->get('month');
        if (strlen($month) <= 0) {
            $month = date('Y-m');
        }

        $materials = db::table('vendor_materials')
            ->where('category', 'FINISH MATERIAL')
            ->get();

        $calendars = db::table('weekly_calendars')
            ->where(db::raw('DATE_FORMAT(week_date, "%Y-%m")'), $month)
            ->select(
                db::raw('DATE_FORMAT(week_date, "%Y-%m") AS month'),
                db::raw('DATE_FORMAT(week_date, "%d-%b") AS date_text'),
                'week_date',
                'remark'
            )
            ->orderBy('week_date', 'ASC')
            ->get();

        $plan_deliveries = db::table('vendor_plan_deliveries')
            ->where(db::raw('DATE_FORMAT(vendor_plan_deliveries.due_date, "%Y-%m")'), '=', $month)
            ->where('vendor_nickname', $request->get('vendor_nickname'))
            ->get();

        $response = array(
            'status' => true,
            'materials' => $materials,
            'calendars' => $calendars,
            'plan_deliveries' => $plan_deliveries,
            'month' => $month,
        );
        return Response::json($response);

    }

    public function fetchIventoryCheck(Request $request)
    {

        $bom_stocks = db::select("SELECT vendor_boms.*, COALESCE(vendor_stocks.stock,0) AS stock FROM vendor_boms
            LEFT JOIN (SELECT * FROM vendor_stocks
            WHERE vendor_stocks.storage_location = '" . $request->get('issue') . "') AS vendor_stocks
            ON vendor_stocks.material_number = vendor_boms.vendor_material_number
            WHERE vendor_boms.ympi_material_number = '" . $request->get('material_number') . "'");

        for ($i = 0; $i < count($bom_stocks); $i++) {
            if (($bom_stocks[$i]->usage * $request->get('quantity')) > $bom_stocks[$i]->stock) {
                $response = array(
                    'status' => false,
                    'bom' => $bom_stocks[$i],
                );
                return Response::json($response);
            }
        }

        $response = array(
            'status' => true,
        );
        return Response::json($response);

    }

    public function fetchDeliveryOrder(Request $request)
    {

        $month = $request->get('month');
        if (strlen($month) <= 0) {
            $month = date('Y-m');
        }

        $delivery_orders = db::table('vendor_delivery_orders')
            ->where('vendor_nickname', strtoupper($request->get('vendor_nickname')))
            ->where('shipment_date', 'LIKE', '%' . $month . '%')
            ->orderBy('created_at', 'DESC')
            ->orderBy('delivery_order_no', 'ASC')
            ->get();

        $delivery_order_details = db::table('vendor_delivery_order_details')
            ->where('vendor_nickname', strtoupper($request->get('vendor_nickname')))
            ->where('shipment_date', 'LIKE', '%' . $month . '%')
            ->get();

        $response = array(
            'status' => true,
            'delivery_orders' => $delivery_orders,
            'delivery_order_details' => $delivery_order_details,
        );
        return Response::json($response);

    }

    public function fetchDeliveryOrderBc(Request $request)
    {

        $delivery_orders = db::table('vendor_delivery_orders');
        if (strlen($request->get('month')) > 0) {
            $month = $request->get('month');
            $delivery_orders = $delivery_orders->where('shipment_date', 'LIKE', '%' . $month . '%');
        } else {
            $delivery_orders = $delivery_orders->whereNull('customs_no');
        }
        $delivery_orders = $delivery_orders->whereNotNull('delivery_order_sent_at')
            ->orderBy('delivery_order_sent_at', 'ASC')
            ->get();

        $delivery_order_no = [];
        for ($i = 0; $i < count($delivery_orders); $i++) {
            $delivery_order_no[] = $delivery_orders[$i]->delivery_order_no;
        }

        $delivery_order_details = db::table('vendor_delivery_order_details')
            ->whereIn('delivery_order_no', $delivery_order_no)
            ->get();

        $response = array(
            'status' => true,
            'delivery_orders' => $delivery_orders,
            'delivery_order_details' => $delivery_order_details,
        );
        return Response::json($response);

    }

    public function inputDeliveryOrder(Request $request)
    {

        $now = date('Y-m-d H:i:s');
        $deliveries = json_decode($request->get('delivery_materials'));
        $vendor_nickname = $request->get('vendor_nickname');
        $count_delivery_order = [];

        $fg_location = db::table('vendor_storage_locations')
            ->where('vendor_nickname', strtoupper($vendor_nickname))
            ->where('category', 'WAREHOUSE FG')
            ->first();

        for ($i = 0; $i < count($deliveries); $i++) {
            if ($deliveries[$i]->material_type == 'SUBCONT') {
                $stock = db::table('vendor_stocks')
                    ->where('vendor_nickname', strtoupper($vendor_nickname))
                    ->where('material_number', $deliveries[$i]->material_number)
                    ->where('storage_location', $fg_location->storage_location)
                    ->first();

                if ($stock) {
                    if ($deliveries[$i]->quantity > $stock->stock) {
                        $response = array(
                            'status' => false,
                            'message' => 'Stock FG tidak cukup',
                        );
                        return Response::json($response);
                    }
                } else {
                    $response = array(
                        'status' => false,
                        'message' => 'Stock FG tidak cukup',
                    );
                    return Response::json($response);
                }

            }
        }

        DB::beginTransaction();

        $year = date('y', strtotime($request->get('date')));
        $month = date('m', strtotime($request->get('date')));

        try {

            $is_401 = '';
            if (str_contains($request->get('type'), '401')) {
                $is_401 = '401 ';
            }

            $type = '';
            $document_no = '';
            $prefix_now = $vendor_nickname . '-' . $year;
            $code_generator = CodeGenerator::where('note', '=', 'rk-delivery-order')->first();
            if ($prefix_now != $code_generator->prefix) {
                $code_generator->prefix = $prefix_now;
                $code_generator->index = '0';
                $code_generator->save();
            }
            $delivery_order_no = $code_generator->index + 1;
            $code_generator->index = $code_generator->index + 1;
            $code_generator->save();

            if (str_contains($request->get('type'), 'SUBCONT')) {

                // SURAT JALAN JO
                $type = 'A';
                $document_no = $request->get('jo');
                $delivery_order = $delivery_order_no . '-' . $type . '//' . strtoupper($vendor_nickname) . '//' . $month . '//' . $year;
                $count_delivery_order[] = $delivery_order;

                if ($request->file('jo_file') != null) {
                    if ($files = $request->file('jo_file')) {
                        $filename = $document_no . '.pdf';
                        $files->move('files/po', $filename);
                    }
                } else {
                    $response = array(
                        'status' => false,
                        'message' => 'File JO tidak boleh kosong',
                    );
                    return Response::json($response);
                }

                $insert_delivery_order = db::table('vendor_delivery_orders')
                    ->insert([
                        'vendor_code' => $fg_location->vendor_code,
                        'vendor_nickname' => $fg_location->vendor_nickname,
                        'vendor_name' => $fg_location->vendor_name,
                        'delivery_order_no' => $delivery_order,
                        'shipment_date' => $request->get('date'),
                        'delivery_order_type' => $is_401 . 'Job Order',
                        'document_no' => $document_no,
                        'reference_no' => $request->get('reff'),
                        'vehicle_registration_no' => $request->get('no_pol'),
                        'created_by' => Auth::id(),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                for ($i = 0; $i < count($deliveries); $i++) {

                    $insert_delivery_order = db::table('vendor_delivery_order_details')
                        ->insert([
                            'vendor_code' => $fg_location->vendor_code,
                            'vendor_nickname' => $fg_location->vendor_nickname,
                            'vendor_name' => $fg_location->vendor_name,
                            'delivery_order_no' => $delivery_order,
                            'shipment_date' => $request->get('date'),
                            'material_number' => $deliveries[$i]->material_number,
                            'material_description' => $deliveries[$i]->material_description,
                            'quantity' => $deliveries[$i]->quantity,
                            'created_by' => Auth::id(),
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);

                    if ($deliveries[$i]->material_type == 'SUBCONT Material') {
                        // UPDATE STOCK
                        $stock = db::table('vendor_stocks')
                            ->where('vendor_nickname', strtoupper($vendor_nickname))
                            ->where('material_number', $deliveries[$i]->material_number)
                            ->where('storage_location', $fg_location->storage_location)
                            ->first();

                        if ($stock) {
                            $update_stock = db::table('vendor_stocks')
                                ->where('vendor_nickname', strtoupper($vendor_nickname))
                                ->where('material_number', $deliveries[$i]->material_number)
                                ->where('storage_location', $fg_location->storage_location)
                                ->update([
                                    'stock' => ($stock->stock - $deliveries[$i]->quantity),
                                ]);
                        }
                    }

                }

                // SURAT JALAN PO
                $type = 'B';
                $document_no = $request->get('po');
                $delivery_order = $delivery_order_no . '-' . $type . '//' . strtoupper($vendor_nickname) . '//' . $month . '//' . $year;
                $count_delivery_order[] = $delivery_order;

                if ($request->file('po_file') != null) {
                    if ($files = $request->file('po_file')) {
                        $filename = $document_no . '.pdf';
                        $files->move('files/po', $filename);
                    }
                } else {
                    $response = array(
                        'status' => false,
                        'message' => 'File PO tidak boleh kosong',
                    );
                    return Response::json($response);
                }

                $insert_delivery_order = db::table('vendor_delivery_orders')
                    ->insert([
                        'vendor_code' => $fg_location->vendor_code,
                        'vendor_nickname' => $fg_location->vendor_nickname,
                        'vendor_name' => $fg_location->vendor_name,
                        'delivery_order_no' => $delivery_order,
                        'shipment_date' => $request->get('date'),
                        'delivery_order_type' => $is_401 . 'Purchase Order',
                        'document_no' => $document_no,
                        'vehicle_registration_no' => $request->get('no_pol'),
                        'created_by' => Auth::id(),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                for ($i = 0; $i < count($deliveries); $i++) {

                    $vendor_material_matriks = db::table('vendor_material_matriks')
                        ->where('subcont_material_number', $deliveries[$i]->material_number)
                        ->first();

                    $insert_delivery_order = db::table('vendor_delivery_order_details')
                        ->insert([
                            'vendor_code' => $fg_location->vendor_code,
                            'vendor_nickname' => $fg_location->vendor_nickname,
                            'vendor_name' => $fg_location->vendor_name,
                            'delivery_order_no' => $delivery_order,
                            'shipment_date' => $request->get('date'),
                            'material_number' => $vendor_material_matriks->material_number,
                            'material_description' => $vendor_material_matriks->material_description,
                            'quantity' => $deliveries[$i]->quantity,
                            'created_by' => Auth::id(),
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);

                }

            } else {

                // SURAT JALAN PO
                $document_no = $request->get('po');
                $delivery_order = $delivery_order_no . '//' . strtoupper($vendor_nickname) . '//' . $month . '//' . $year;
                $count_delivery_order[] = $delivery_order;

                if ($request->file('po_file') != null) {
                    if ($files = $request->file('po_file')) {
                        $filename = $document_no . '.pdf';
                        $files->move('files/po', $filename);
                    }
                } else {
                    $response = array(
                        'status' => false,
                        'message' => 'File PO tidak boleh kosong',
                    );
                    return Response::json($response);
                }

                $insert_delivery_order = db::table('vendor_delivery_orders')
                    ->insert([
                        'vendor_code' => $fg_location->vendor_code,
                        'vendor_nickname' => $fg_location->vendor_nickname,
                        'vendor_name' => $fg_location->vendor_name,
                        'delivery_order_no' => $delivery_order,
                        'shipment_date' => $request->get('date'),
                        'delivery_order_type' => $is_401 . 'Purchase Order',
                        'document_no' => $document_no,
                        'vehicle_registration_no' => $request->get('no_pol'),
                        'created_by' => Auth::id(),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                for ($i = 0; $i < count($deliveries); $i++) {

                    $insert_delivery_order = db::table('vendor_delivery_order_details')
                        ->insert([
                            'vendor_code' => $fg_location->vendor_code,
                            'vendor_nickname' => $fg_location->vendor_nickname,
                            'vendor_name' => $fg_location->vendor_name,
                            'delivery_order_no' => $delivery_order,
                            'shipment_date' => $request->get('date'),
                            'material_number' => $deliveries[$i]->material_number,
                            'material_description' => $deliveries[$i]->material_description,
                            'quantity' => $deliveries[$i]->quantity,
                            'created_by' => Auth::id(),
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);

                }

            }

        } catch (\Exception $e) {
            DB::rollback();
            $response = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
            return Response::json($response);
        }

        for ($i = 0; $i < count($count_delivery_order); $i++) {
            $this->generateDeliveryOrder($count_delivery_order[$i]);
        }

        DB::commit();
        $response = array(
            'status' => true,
            'message' => 'Surat jalan berhasil dibuat',
        );
        return Response::json($response);

    }

    public function inputBcDocument(Request $request)
    {

        $now = date('Y-m-d H:i:s');
        $delivery_order_no = $request->get('delivery_order');
        $bc_type = $request->get('bc_type');
        $bc_no = $request->get('bc_no');

        DB::beginTransaction();

        try {

            if ($request->file('bc_file') != null) {
                if ($files = $request->file('bc_file')) {
                    $bc_filename = $bc_no . '.pdf';
                    $files->move('files/document_bc', $bc_filename);
                }
            } else {
                $response = array(
                    'status' => false,
                    'message' => 'File BC tidak boleh kosong',
                );
                return Response::json($response);
            }

            if ($request->file('sppb_file') != null) {
                if ($files = $request->file('sppb_file')) {
                    $sppb_filename = $bc_no . ' SPPB.pdf';
                    $files->move('files/document_bc', $sppb_filename);
                }
            } else {
                $response = array(
                    'status' => false,
                    'message' => 'File SPPB tidak boleh kosong',
                );
                return Response::json($response);
            }

            $update = db::table('vendor_delivery_orders')
                ->where('delivery_order_no', $delivery_order_no)
                ->update([
                    'customs_type' => $bc_type,
                    'customs_no' => $bc_no,
                    'custom_sent_at' => $now,
                    'updated_at' => $now,
                ]);

            $delivery_order = db::table('vendor_delivery_orders')
                ->where('delivery_order_no', $delivery_order_no)
                ->first();

            $delivery_order_details = db::table('vendor_delivery_order_details')
                ->where('delivery_order_no', $delivery_order_no)
                ->get();

            $data = [
                'delivery_order' => $delivery_order,
                'delivery_order_details' => $delivery_order_details,
            ];

            $vendor = db::table('vendor_mails')
                ->where('vendor_code', $delivery_order->vendor_code)
                ->where('remark', 'to')
                ->get();

            $vendor_mail = [];
            foreach ($vendor as $mail) {
                $vendor_mail[] = $mail->email;
            }

            Mail::to($vendor_mail)
                ->cc($this->logistic)
                ->bcc($this->mis)
                ->send(new SendEmail($data, 'send_bc_document'));

            $messages = "*Informasi Dokumen BC :*%0A%0A";
            $messages .= "Dear *" . $delivery_order->vendor_name . "*%0A";
            $messages .= "YMPI telah merilis dokumen BC untuk surat jalan No. *" . $delivery_order_no . "*. ";
            $messages .= "Mohon untuk segera melakukan pengiriman barang sesuai dengan surat jalan yang telah diterbitkan. ";
            $messages .= "Saat melakukan pengiriman, pastikan membawa dokumen BC yang telah diterbitkan oleh YMPI. ";
            $messages .= "Terima kasih. ";
            $messages .= '%0A%0A';
            $messages .= "_Ini adalah pesan otomatis. Mohon untuk tidak membalas pesan ini. ";
            $messages .= "Tambahkan nomor WA pada daftar kontak untuk memastikan anda mendapatkan pesan WA otomatis dari BridgeForVendor._";

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
                CURLOPT_POSTFIELDS => "receiver=6282234955505&device=6281130561777&message=" . $messages . '&type=chat',
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
                CURLOPT_POSTFIELDS => "receiver=6287864082230&device=6281130561777&message=" . $messages . '&type=chat',
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    'Content-Type: application/x-www-form-urlencoded',
                    'Authorization: Bearer UAqINT9e23uRiQmYttEUiFQ9qRMUXk8sADK2EiVSgLODdyOhgU',
                ),
            ));
            curl_exec($curl);

            DB::commit();
            $response = array(
                'status' => true,
                'message' => 'Dokumen BC berhasil disubmit',
            );
            return Response::json($response);

        } catch (\Exception $e) {
            DB::rollback();
            $response = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
            return Response::json($response);
        }
    }

    public function deleteDeliveryOrder(Request $request)
    {

        DB::beginTransaction();
        try {

            $vendor_delivery_order = db::table('vendor_delivery_orders')
                ->where('id', $request->get('id'))
                ->first();

            $vendor_delivery_order_details = db::table('vendor_delivery_order_details')
                ->where('delivery_order_no', $vendor_delivery_order->delivery_order_no)
                ->get();

            $fg_location = db::table('vendor_storage_locations')
                ->where('vendor_nickname', $vendor_delivery_order->vendor_nickname)
                ->where('category', 'WAREHOUSE FG')
                ->first();

            $delete = db::table('vendor_delivery_orders')
                ->where('id', $request->get('id'))
                ->update([
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);

            for ($i = 0; $i < count($vendor_delivery_order_details); $i++) {
                $delete_details = db::table('vendor_delivery_order_details')
                    ->where('id', $vendor_delivery_order_details[$i]->id)
                    ->update([
                        'deleted_at' => date('Y-m-d H:i:s'),
                    ]);

                $stock = db::table('vendor_stocks')
                    ->where('vendor_nickname', $vendor_delivery_order->vendor_nickname)
                    ->where('material_number', $vendor_delivery_order_details[$i]->material_number)
                    ->where('storage_location', $fg_location->storage_location)
                    ->first();

                if ($stock) {
                    $update_stock = db::table('vendor_stocks')
                        ->where('vendor_nickname', $vendor_delivery_order->vendor_nickname)
                        ->where('material_number', $vendor_delivery_order_details[$i]->material_number)
                        ->where('storage_location', $fg_location->storage_location)
                        ->update([
                            'stock' => ($stock->stock - $vendor_delivery_order_details[$i]->quantity),
                        ]);
                }

            }

            DB::commit();
            $response = array(
                'status' => true,
                'message' => 'Surat jalan berhasil dihapus',
            );
            return Response::json($response);

        } catch (\Exception $e) {
            DB::rollback();
            $response = array(
                'status' => false,
                'message' => $e->getMessage(),
            );
            return Response::json($response);

        }

    }

    public function generateDeliveryOrder($delivery_order_no)
    {
        $filename = str_replace("//", ".", $delivery_order_no);

        $delivery_order = db::table('vendor_delivery_orders')
            ->where('delivery_order_no', strtoupper($delivery_order_no))
            ->first();

        $delivery_order_detail = db::table('vendor_delivery_order_details')
            ->where('delivery_order_no', strtoupper($delivery_order_no))
            ->get();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        $pdf->loadView('vendor.delivery_order_pdf', array(
            'delivery_order' => $delivery_order,
            'delivery_order_detail' => $delivery_order_detail,
        ));
        $pdf->save(public_path() . "/files/delivery_order/" . $filename . ".pdf");

    }

    public function inputCompletion(Request $request)
    {
        $now = date('Y-m-d H:i:s');
        DB::beginTransaction();
        $production_results = $request->get('production_results');

        for ($i = 0; $i < count($production_results); $i++) {

            $vendor = db::table('vendor_storage_locations')
                ->where('vendor_nickname', strtoupper($production_results[$i]['vendor_nickname']))
                ->first();

            $child = db::table('vendor_boms')
                ->where('ympi_material_number', $production_results[$i]['material_number'])
                ->get();

            for ($j = 0; $j < count($child); $j++) {
                $mvt = 'MC01';
                $koef = 1;
                if ($production_results[$i]['quantity'] < 0) {
                    $mvt = 'MC02';
                    $koef = -1;
                }

                try {
                    // INSERT TRX LOG
                    $insert_trx_log = db::table('vendor_transaction_logs')
                        ->insert([
                            'vendor_nickname' => strtoupper($production_results[$i]['vendor_nickname']),
                            'mvt' => $mvt,
                            'result_date' => $production_results[$i]['date'],
                            'material_number' => $child[$j]->vendor_material_number,
                            'material_description' => $child[$j]->vendor_material_description,
                            'issue_storage_location' => $production_results[$i]['location'],
                            'quantity' => $production_results[$i]['quantity'] * $child[$j]->usage * $koef,
                            'created_by' => Auth::id(),
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);

                    // UPDATE STOCK
                    $stock = db::table('vendor_stocks')
                        ->where('vendor_nickname', $production_results[$i]['vendor_nickname'])
                        ->where('material_number', $child[$j]->vendor_material_number)
                        ->where('storage_location', $production_results[$i]['location'])
                        ->first();

                    if ($stock) {
                        $update_stock = db::table('vendor_stocks')
                            ->where('vendor_nickname', $production_results[$i]['vendor_nickname'])
                            ->where('material_number', $child[$j]->vendor_material_number)
                            ->where('storage_location', $production_results[$i]['location'])
                            ->update([
                                'stock' => $stock->stock - ($production_results[$i]['quantity'] * $child[$j]->usage * $koef),
                            ]);
                    } else {
                        $insert_stock = db::table('vendor_stocks')
                            ->insert([
                                'vendor_code' => $vendor->vendor_code,
                                'vendor_nickname' => strtoupper($production_results[$i]['vendor_nickname']),
                                'vendor_name' => $vendor->vendor_name,
                                'material_number' => $child[$j]->vendor_material_number,
                                'material_description' => $child[$j]->vendor_material_description,
                                'storage_location' => $production_results[$i]['location'],
                                'stock' => $child[$j]->usage * $koef,
                                'created_by' => Auth::id(),
                                'created_at' => $now,
                                'updated_at' => $now,
                            ]);

                    }

                } catch (\Exception $e) {
                    DB::rollback();
                    $response = array(
                        'status' => false,
                        'message' => $e->getMessage(),
                    );
                    return Response::json($response);

                }
            }

            $mvt = 'PR01';

            $rk_issue = 'RKWIP';
            $rk_receive = 'RKFST';
            if ($production_results[$i]['quantity'] < 0) {
                $mvt = 'PR02';

                $rk_issue = 'RKFST';
                $rk_receive = 'RKWIP';
            }

            try {
                // INSERT TRX LOG
                $insert_trx_log = db::table('vendor_transaction_logs')
                    ->insert([
                        'vendor_nickname' => strtoupper($production_results[$i]['vendor_nickname']),
                        'mvt' => $mvt,
                        'result_date' => $production_results[$i]['date'],
                        'material_number' => $production_results[$i]['material_number'],
                        'material_description' => $production_results[$i]['material_description'],
                        'issue_storage_location' => $production_results[$i]['location'],
                        'quantity' => $production_results[$i]['quantity'] * $koef,
                        'created_by' => Auth::id(),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                // UPDATE STOCK
                $stock = db::table('vendor_stocks')
                    ->where('vendor_nickname', $production_results[$i]['vendor_nickname'])
                    ->where('material_number', $production_results[$i]['material_number'])
                    ->where('storage_location', $production_results[$i]['location'])
                    ->first();

                if ($stock) {
                    $update_stock = db::table('vendor_stocks')
                        ->where('vendor_nickname', $production_results[$i]['vendor_nickname'])
                        ->where('material_number', $production_results[$i]['material_number'])
                        ->where('storage_location', $production_results[$i]['location'])
                        ->update([
                            'stock' => $stock->stock + ($production_results[$i]['quantity'] * $koef),
                        ]);
                } else {
                    $insert_stock = db::table('vendor_stocks')
                        ->insert([
                            'vendor_code' => $vendor->vendor_code,
                            'vendor_nickname' => strtoupper($production_results[$i]['vendor_nickname']),
                            'vendor_name' => $vendor->vendor_name,
                            'material_number' => $production_results[$i]['material_number'],
                            'material_description' => $production_results[$i]['material_description'],
                            'storage_location' => $production_results[$i]['location'],
                            'stock' => $production_results[$i]['quantity'] * $koef,
                            'created_by' => Auth::id(),
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);

                }

                // KHUSUS RK
                if (strtoupper($production_results[$i]['vendor_nickname']) == 'RK') {

                    // INSERT TRX LOG
                    $insert_trx_log = db::table('vendor_transaction_logs')
                        ->insert([
                            'vendor_nickname' => strtoupper($production_results[$i]['vendor_nickname']),
                            'mvt' => 'SD01',
                            'result_date' => $production_results[$i]['date'],
                            'material_number' => $production_results[$i]['material_number'],
                            'material_description' => $production_results[$i]['material_description'],
                            'issue_storage_location' => $rk_issue,
                            'receive_storage_location' => $rk_receive,
                            'quantity' => $production_results[$i]['quantity'] * $koef,
                            'created_by' => Auth::id(),
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);

                    // UPDATE STOCK ISSUE
                    $stock = db::table('vendor_stocks')
                        ->where('vendor_nickname', $production_results[$i]['vendor_nickname'])
                        ->where('material_number', $production_results[$i]['material_number'])
                        ->where('storage_location', 'RKWIP')
                        ->first();

                    if ($stock) {
                        $update_stock = db::table('vendor_stocks')
                            ->where('vendor_nickname', $production_results[$i]['vendor_nickname'])
                            ->where('material_number', $production_results[$i]['material_number'])
                            ->where('storage_location', 'RKWIP')
                            ->update([
                                'stock' => $stock->stock + ($production_results[$i]['quantity'] * -1),
                            ]);
                    }

                    // UPDATE STOCK RECEIVE
                    $stock = db::table('vendor_stocks')
                        ->where('vendor_nickname', $production_results[$i]['vendor_nickname'])
                        ->where('material_number', $production_results[$i]['material_number'])
                        ->where('storage_location', 'RKFST')
                        ->first();

                    if ($stock) {
                        $update_stock = db::table('vendor_stocks')
                            ->where('vendor_nickname', $production_results[$i]['vendor_nickname'])
                            ->where('material_number', $production_results[$i]['material_number'])
                            ->where('storage_location', 'RKFST')
                            ->update([
                                'stock' => $stock->stock + ($production_results[$i]['quantity'] * 1),
                            ]);
                    } else {
                        $insert_stock = db::table('vendor_stocks')
                            ->insert([
                                'vendor_code' => $vendor->vendor_code,
                                'vendor_nickname' => strtoupper($production_results[$i]['vendor_nickname']),
                                'vendor_name' => $vendor->vendor_name,
                                'material_number' => $production_results[$i]['material_number'],
                                'material_description' => $production_results[$i]['material_description'],
                                'storage_location' => 'RKFST',
                                'stock' => $production_results[$i]['quantity'] * 1,
                                'created_by' => Auth::id(),
                                'created_at' => $now,
                                'updated_at' => $now,
                            ]);
                    }

                }

            } catch (\Exception $e) {
                DB::rollback();
                $response = array(
                    'status' => false,
                    'message' => $e->getMessage(),
                );
                return Response::json($response);
            }

        }

        DB::commit();
        $response = array(
            'status' => true,
            'message' => 'Data berhasil disimpan',
        );
        return Response::json($response);

    }

    public function inputGoodsReceipt(Request $request)
    {

        $now = date('Y-m-d H:i:s');
        DB::beginTransaction();
        $goods_receipt = $request->get('goods_receipt');

        for ($i = 0; $i < count($goods_receipt); $i++) {

            $mvt = 'GR01';
            $koef = 1;

            $rk_issue = 'RKMST';
            $rk_receive = 'RKWIP';
            if ($goods_receipt[$i]['quantity'] < 0) {
                $mvt = 'GR02';
                $koef = -1;

                $rk_issue = 'RKWIP';
                $rk_receive = 'RKMST';

            }

            $vendor = db::table('vendor_storage_locations')
                ->where('vendor_nickname', strtoupper($goods_receipt[$i]['vendor_nickname']))
                ->first();

            try {
                // INSERT TRX LOG
                $insert_trx_log = db::table('vendor_transaction_logs')
                    ->insert([
                        'vendor_nickname' => strtoupper($goods_receipt[$i]['vendor_nickname']),
                        'mvt' => $mvt,
                        'result_date' => $goods_receipt[$i]['date'],
                        'material_number' => $goods_receipt[$i]['material_number'],
                        'material_description' => $goods_receipt[$i]['material_description'],
                        'issue_storage_location' => $goods_receipt[$i]['location'],
                        'quantity' => $goods_receipt[$i]['quantity'] * $koef,
                        'created_by' => Auth::id(),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                // UPDATE STOCK
                $stock = db::table('vendor_stocks')
                    ->where('vendor_nickname', $goods_receipt[$i]['vendor_nickname'])
                    ->where('material_number', $goods_receipt[$i]['material_number'])
                    ->where('storage_location', $goods_receipt[$i]['location'])
                    ->first();

                if ($stock) {
                    $update_stock = db::table('vendor_stocks')
                        ->where('vendor_nickname', $goods_receipt[$i]['vendor_nickname'])
                        ->where('material_number', $goods_receipt[$i]['material_number'])
                        ->where('storage_location', $goods_receipt[$i]['location'])
                        ->update([
                            'stock' => $stock->stock + $goods_receipt[$i]['quantity'],
                        ]);
                } else {
                    $insert_trx_log = db::table('vendor_stocks')
                        ->insert([
                            'vendor_code' => $vendor->vendor_code,
                            'vendor_nickname' => strtoupper($goods_receipt[$i]['vendor_nickname']),
                            'vendor_name' => $vendor->vendor_name,
                            'material_number' => $goods_receipt[$i]['material_number'],
                            'material_description' => $goods_receipt[$i]['material_description'],
                            'storage_location' => $goods_receipt[$i]['location'],
                            'stock' => $goods_receipt[$i]['quantity'],
                            'created_by' => Auth::id(),
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
                }

                // KHUSUS RK
                if (strtoupper($goods_receipt[$i]['vendor_nickname']) == 'RK') {

                    // INSERT TRX LOG
                    $insert_trx_log = db::table('vendor_transaction_logs')
                        ->insert([
                            'vendor_nickname' => strtoupper($goods_receipt[$i]['vendor_nickname']),
                            'mvt' => 'SD01',
                            'result_date' => $goods_receipt[$i]['date'],
                            'material_number' => $goods_receipt[$i]['material_number'],
                            'material_description' => $goods_receipt[$i]['material_description'],
                            'issue_storage_location' => $rk_issue,
                            'receive_storage_location' => $rk_receive,
                            'quantity' => $goods_receipt[$i]['quantity'] * $koef,
                            'created_by' => Auth::id(),
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);

                    // UPDATE STOCK ISSUE
                    $stock = db::table('vendor_stocks')
                        ->where('vendor_nickname', $goods_receipt[$i]['vendor_nickname'])
                        ->where('material_number', $goods_receipt[$i]['material_number'])
                        ->where('storage_location', 'RKMST')
                        ->first();

                    if ($stock) {
                        $update_stock = db::table('vendor_stocks')
                            ->where('vendor_nickname', $goods_receipt[$i]['vendor_nickname'])
                            ->where('material_number', $goods_receipt[$i]['material_number'])
                            ->where('storage_location', 'RKMST')
                            ->update([
                                'stock' => $stock->stock + ($goods_receipt[$i]['quantity'] * -1),
                            ]);
                    }

                    // UPDATE STOCK RECEIVE
                    $stock = db::table('vendor_stocks')
                        ->where('vendor_nickname', $goods_receipt[$i]['vendor_nickname'])
                        ->where('material_number', $goods_receipt[$i]['material_number'])
                        ->where('storage_location', 'RKWIP')
                        ->first();

                    if ($stock) {
                        $update_stock = db::table('vendor_stocks')
                            ->where('vendor_nickname', $goods_receipt[$i]['vendor_nickname'])
                            ->where('material_number', $goods_receipt[$i]['material_number'])
                            ->where('storage_location', 'RKWIP')
                            ->update([
                                'stock' => $stock->stock + ($goods_receipt[$i]['quantity'] * 1),
                            ]);
                    } else {
                        $insert_stock = db::table('vendor_stocks')
                            ->insert([
                                'vendor_code' => $vendor->vendor_code,
                                'vendor_nickname' => strtoupper($goods_receipt[$i]['vendor_nickname']),
                                'vendor_name' => $vendor->vendor_name,
                                'material_number' => $goods_receipt[$i]['material_number'],
                                'material_description' => $goods_receipt[$i]['material_description'],
                                'storage_location' => 'RKWIP',
                                'stock' => $goods_receipt[$i]['quantity'] * 1,
                                'created_by' => Auth::id(),
                                'created_at' => $now,
                                'updated_at' => $now,
                            ]);
                    }

                }

            } catch (\Exception $e) {
                DB::rollback();
                $response = array(
                    'status' => false,
                    'message' => $e->getMessage(),
                );
                return Response::json($response);
            }

        }

        DB::commit();
        $response = array(
            'status' => true,
            'message' => 'Data berhasil disimpan',
        );
        return Response::json($response);

    }

    public function inputPlanDeliveryData(Request $request)
    {

        $now = date('Y-m-d H:i:s');
        $upload = $request->get('data');
        $error_count = array();
        $ok_count = array();

        $uploadRows = preg_split("/\r?\n/", $upload);

        DB::beginTransaction();

        $delete = db::table('vendor_plan_deliveries')
            ->where(db::raw('DATE_FORMAT(vendor_plan_deliveries.due_date, "%Y-%m")'), '=', $request->get('month'))
            ->where('vendor_nickname', $request->get('vendor_nickname'))
            ->delete();

        foreach ($uploadRows as $uploadRow) {
            $uploadColumn = preg_split("/\t/", $uploadRow);
            $material_number = $uploadColumn[0];
            $date = $uploadColumn[1];
            $plan = $uploadColumn[2];

            $material = db::table('vendor_materials')
                ->where('vendor_nickname', $request->get('vendor_nickname'))
                ->where('material_number', $material_number)
                ->first();

            if (!$material) {
                DB::rollback();
                $response = array(
                    'status' => false,
                    'message' => 'Material ' . $material_number . ' tidak ditemukan',
                );
                return Response::json($response);
            }

            try {
                $insert_plan = db::table('vendor_plan_deliveries')
                    ->insert([
                        'vendor_code' => $material->vendor_code,
                        'vendor_nickname' => $material->vendor_nickname,
                        'vendor_name' => $material->vendor_name,
                        'material_number' => $material_number,
                        'material_description' => $material->material_description,
                        'due_date' => $date,
                        'plan' => $plan,
                        'actual' => 0,
                        'created_by' => Auth::id(),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

            } catch (\Exception $e) {
                DB::rollback();
                $response = array(
                    'status' => false,
                    'message' => $e->getMessage(),
                );
                return Response::json($response);

            }

        }

        DB::commit();
        $response = array(
            'status' => true,
            'message' => 'Plan delivery berhasil disimpan',
        );
        return Response::json($response);

    }

    public function sendDeliveryOrder(Request $request)
    {

        try {

            $delivery_order = db::table('vendor_delivery_orders')
                ->where('delivery_order_no', strtoupper($request->get('delivery_order_no')))
                ->first();

            $delivery_order_details = db::table('vendor_delivery_order_details')
                ->where('delivery_order_no', strtoupper($request->get('delivery_order_no')))
                ->get();

            $update_delivery_order = db::table('vendor_delivery_orders')
                ->where('delivery_order_no', strtoupper($request->get('delivery_order_no')))
                ->update([
                    'delivery_order_sent_at' => date('Y-m-d H:i:s'),
                ]);

            $data = [
                'delivery_order' => $delivery_order,
                'delivery_order_details' => $delivery_order_details,
            ];

            Mail::to($this->logistic)
                ->cc($this->pch)
                ->bcc($this->mis)
                ->send(new SendEmail($data, 'send_delivery_order'));

            $response = array(
                'status' => true,
                'message' => 'Surat jalan berhasil dikirim',
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

    public function downloadDeliveryOrder(Request $request)
    {
        $filename = $request->get('filename');
        $file_exist = file_exists(public_path() . '/files/delivery_order/' . $filename . '.pdf');

        if ($file_exist) {
            $path = '/files/delivery_order/' . $filename . '.pdf';
            $file_path = asset($path);

            $response = array(
                'status' => true,
                'file_path' => $file_path,
            );
            return Response::json($response);

        } else {
            $response = array(
                'status' => false,
            );
            return Response::json($response);

        }

    }

    public function downloadDocumentOrder(Request $request)
    {

        $filename = $request->get('filename');
        $file_exist = file_exists(public_path() . '/files/po/' . $filename . '.pdf');

        if ($file_exist) {
            $path = '/files/po/' . $filename . '.pdf';
            $file_path = asset($path);

            $response = array(
                'status' => true,
                'file_path' => $file_path,
            );
            return Response::json($response);

        } else {
            $response = array(
                'status' => false,
            );
            return Response::json($response);

        }

    }

    public function downloadBcDoc(Request $request)
    {

        $filename = $request->get('filename');
        $file_exist = file_exists(public_path() . '/files/document_bc/' . $filename . '.pdf');

        if ($file_exist) {
            $path = '/files/document_bc/' . $filename . '.pdf';
            $file_path = asset($path);

            $response = array(
                'status' => true,
                'file_path' => $file_path,
            );
            return Response::json($response);

        } else {
            $response = array(
                'status' => false,
            );
            return Response::json($response);

        }

    }

}
