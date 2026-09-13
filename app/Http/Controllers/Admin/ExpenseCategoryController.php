<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function exp_category_list()
    {
        $categories = ExpenseCategory::orderBy('id', 'desc')->get();

        $page_data['categories'] = $categories;
        return view('admin.expense_category.list', $page_data);
    }

    public function exp_category_store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|max:255'
        ]);

        $data['name'] = $request->name;
        ExpenseCategory::insert($data);
        return redirect(route('admin.exp.category.list'))->with('success_message', get_phrase('New category has been added'));
    }

    public function exp_category_update(Request $request, $id)
    {
        $category = ExpenseCategory::find($id)->update(['name' => $request->name]);
        return redirect(route('admin.exp.category.list'))->with('success_message', get_phrase('Category has been updated'));
    }

    public function exp_category_delete($id)
    {
        $category = ExpenseCategory::find($id)->delete();
        return redirect(route('admin.exp.category.list'))->with('success_message', get_phrase('Category has been deleted'));
    }
}
