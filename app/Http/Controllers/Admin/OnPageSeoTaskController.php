<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnPageSeoCategory;
use App\Models\OnPageSeoTask;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OnPageSeoTaskController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $tasks = OnPageSeoTask::with('category')

            ->when($request->search, function ($query) use ($request) {

                $query->where('task_name', 'like', '%' . $request->search . '%');

            })

            ->when($request->category, function ($query) use ($request) {

                $query->where('on_page_seo_category_id', $request->category);

            })

            ->orderBy('sort_order')

            ->paginate(15);

        $categories = OnPageSeoCategory::where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        return view(
            'admin.onpage_seo_task.index',
            compact('tasks', 'categories')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $categories = OnPageSeoCategory::where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        return view(
            'admin.onpage_seo_task.create',
            compact('categories')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'on_page_seo_category_id' => 'required|exists:on_page_seo_categories,id',

            'task_name' => 'required|string|max:255|unique:on_page_seo_tasks,task_name',

            'input_type' => 'required|in:text,textarea,number,url,email,select,checkbox,date,file',

            'placeholder' => 'nullable|string',

            'options' => 'nullable|string',

            'sort_order' => 'nullable|integer',

            'status' => 'required|in:active,inactive',

        ]);

        OnPageSeoTask::create([

            'on_page_seo_category_id' => $request->on_page_seo_category_id,

            'task_name' => $request->task_name,

            'slug' => Str::slug($request->task_name),

            'input_type' => $request->input_type,

            'placeholder' => $request->placeholder,

            'options' => $request->options,

            'is_required' => $request->has('is_required'),

            'sort_order' => $request->sort_order ?? 0,

            'status' => $request->status,

        ]);

        return redirect()
            ->route('admin.onpage-seo-task.index')
            ->with('success', 'Task created successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $task = OnPageSeoTask::with('category')->findOrFail($id);

        return view(
            'admin.onpage_seo_task.show',
            compact('task')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $task = OnPageSeoTask::findOrFail($id);

        $categories = OnPageSeoCategory::where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        return view(
            'admin.onpage_seo_task.edit',
            compact('task', 'categories')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $task = OnPageSeoTask::findOrFail($id);

        $request->validate([

            'on_page_seo_category_id' => 'required|exists:on_page_seo_categories,id',

            'task_name' => 'required|string|max:255|unique:on_page_seo_tasks,task_name,' . $task->id,

            'input_type' => 'required|in:text,textarea,number,url,email,select,checkbox,date,file',

            'placeholder' => 'nullable|string',

            'options' => 'nullable|string',

            'sort_order' => 'nullable|integer',

            'status' => 'required|in:active,inactive',

        ]);

        $task->update([

            'on_page_seo_category_id' => $request->on_page_seo_category_id,

            'task_name' => $request->task_name,

            'slug' => Str::slug($request->task_name),

            'input_type' => $request->input_type,

            'placeholder' => $request->placeholder,

            'options' => $request->options,

            'is_required' => $request->has('is_required'),

            'sort_order' => $request->sort_order ?? 0,

            'status' => $request->status,

        ]);

        return redirect()
            ->route('admin.onpage-seo-task.index')
            ->with('success', 'Task updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $task = OnPageSeoTask::findOrFail($id);

        $task->delete();

        return redirect()
            ->route('admin.onpage-seo-task.index')
            ->with('success', 'Task deleted successfully.');
    }
}