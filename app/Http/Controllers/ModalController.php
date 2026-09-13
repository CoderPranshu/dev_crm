<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModalController extends Controller
{

	function right_modal($view_path = "", Request $request)
	{
		$page_data = array();
		foreach ($request->all() as $key => $value) :
			$page_data[$key] = $value;
		endforeach;

		return view($view_path, $page_data);
	}

public function center_modal($view_path = "", Request $request)
{
    if (!view()->exists($view_path)) {
        abort(404, 'View not found: ' . $view_path);
    }

    return view($view_path, $request->all());
}

}
