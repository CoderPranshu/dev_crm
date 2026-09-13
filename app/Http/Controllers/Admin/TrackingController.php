<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public static function logEvent($salesOrderId, $status, $title, $description = null)
    {
        return OrderTrackingEvent::create([
            'sales_order_id' => $salesOrderId,
            'status' => $status,
            'title' => $title,
            'description' => $description,
            'event_time' => now()
        ]);
    }

    public function show($id)
    {
        $order = SalesOrder::findOrFail($id);
        $events = OrderTrackingEvent::where('sales_order_id', $id)
                    ->orderBy('event_time', 'ASC')
                    ->get();

        return view('admin.tracking.timeline', compact('order', 'events'));
    }
}
