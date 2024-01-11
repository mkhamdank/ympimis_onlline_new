<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Response;

class SyncInventoryController extends Controller
{
    public function fetchPlanDelivery()
    {

        $delivery = db::table('vendor_plan_deliveries')
            ->where('due_date', 'LIKE', '%' . date('Y-m') . '%')
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
            ->where('week_date', 'LIKE', '%' . date('Y-m') . '%')
            ->select(
                'weekly_calendars.*',
                db::raw('date_format(week_date, "%d-%b") AS date')
            )
            ->orderBy('week_date')
            ->get();

        $response = array(
            'status' => true,
            'delivery' => $delivery,
            'calendar' => $calendar,
        );
        return Response::json($response);

    }
}
