<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QaOutgoingVendor extends Model
{
    protected $fillable = [
    	'check_date',
		'serial_number',
		'material_number',
		'material_description',
		'vendor',
		'vendor_shortname',
		'hpl',
		'point_check_id',
		'inspector',
		'qty_check',
		'total_ok',
		'total_ng',
		'ng_ratio',
		'ng_name',
		'ng_qty',
		'ng_qty_side_a',
		'ng_qty_side_b',
		'qa_final_status',
		'qc_sampling_status',
		'product_index',
		'product_result',
		'lot_status',
		'recheck_status',
		'remark',
		'created_by',
	];
}
