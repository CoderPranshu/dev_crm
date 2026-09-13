<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseManager;
use App\Models\User;
use Illuminate\Http\Request;

class ExpenseManagerController extends Controller
{
    public function exp_manager_list()
    {
        $expense_managers = ExpenseManager::orderBy('id', 'desc')->get();
        $page_data['expense_managers'] = $expense_managers;

        return view('admin.expense_manager.index', $page_data);
    }

    public function exp_manager_store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|max:255'
        ]);

        $data['title'] = $request->title;
        $data['expense_category'] = $request->expense_category;
        $data['amount'] = $request->amount;
        $data['user_id'] = $request->user_id;
        $data['note'] = $request->note;
        $data['date'] = $request->date;

        ExpenseManager::insert($data);
        return redirect(route('admin.exp.manager.list'))->with('success_message', get_phrase('New expense has been added'));
    }

    public function exp_manager_update(Request $request, $id)
    {
        $this->validate($request,[
            'title'=>'required|max:255'
        ]);

        $data['title'] = $request->title;
        $data['expense_category'] = $request->expense_category;
        $data['amount'] = $request->amount;
        $data['user_id'] = $request->user_id;
        $data['note'] = $request->note;
        $data['date'] = $request->date;

        ExpenseManager::find($id)->update($data);
        return redirect(route('admin.exp.manager.list'))->with('success_message', get_phrase('Expense has been updated'));
    }
    public function exp_manager_delete($id)
    {
        $manager = ExpenseManager::find($id)->delete();
        return redirect(route('admin.exp.manager.list'))->with('success_message', get_phrase('Expense has been deleted'));
    }

}
