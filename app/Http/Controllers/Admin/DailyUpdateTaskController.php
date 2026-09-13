<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyUpdateTask;
use Carbon\Carbon;



class DailyUpdateTaskController extends Controller
{
    // public function index()
    // {
    //     $tasks = DailyUpdateTask::orderBy('task_date')
    //                 ->orderBy('task_time')
    //                 ->get();

    //     // $events = [];

    //     $events[] = [
    //         'id'    => $task->id,
    //         'title' => $task->title,
    //         'start' => $task->task_date.' '.$task->task_time,
    //         'end'   => $task->task_date.' '.$task->task_time,
    //         'color' => $color,
    //     ];

    //     foreach ($tasks as $task) {

    //         if ($task->priority == 'High') {
    //             $color = '#dc3545';
    //         } elseif ($task->priority == 'Medium') {
    //             $color = '#ffc107';
    //         } else {
    //             $color = '#198754';
    //         }

    //         $events[] = [
    //             'id'    => $task->id,
    //             'title' => $task->title,
    //             'start' => $task->task_date.'T'.$task->task_time,
    //             'color' => $color,
    //         ];
    //     }

    //     return view('admin.daily_update_task.index', compact('tasks','events'));
    // }

    // public function index()
    // {

    //     $tasks = DailyUpdateTask::where('user_id', auth()->id())
    //         ->orderBy('task_date')
    //         ->orderBy('task_time')
    //         ->get();            

    //     $events = [];

    //     foreach ($tasks as $task) {

    //         if ($task->priority == 'High') {
    //             $color = '#dc3545';
    //         } elseif ($task->priority == 'Medium') {
    //             $color = '#ffc107';
    //         } else {
    //             $color = '#198754';
    //         }

    //         $start = Carbon::parse($task->task_date->format('Y-m-d') . ' ' . $task->task_time)
    //                     ->format('Y-m-d\TH:i:s');

    //         $end = Carbon::parse($task->task_date->format('Y-m-d') . ' ' . $task->task_time)
    //                     ->addHour()
    //                     ->format('Y-m-d\TH:i:s');

    //         $events[] = [
    //             'id'    => $task->id,
    //             'title' => $task->title,
    //             'start' => $start,
    //             'end'   => $end,
    //             'color' => $color,
    //         ];
    //     }

    //     return view('admin.daily_update_task.index', compact('tasks', 'events'));
    // }

    // public function store(Request $request)
    // {
    //     $task = DailyUpdateTask::create([
    //         'user_id'     => auth()->id(),
    //         'title'       => $request->title,
    //         'task_date'   => $request->task_date,
    //         'task_time'   => $request->task_time,
    //         'priority'    => $request->priority,
    //         'description' => $request->description,
    //         'status'      => 'Pending',
    //     ]);

    //     return response()->json([
    //         'id'    => $task->id,
    //         'title' => $task->title,
    //         'start' => $task->task_date.'T'.$task->task_time,
    //         'color' => '#0d6efd'
    //     ]);
    // }

    public function today()
    {
        $tasks = DailyUpdateTask::whereDate('task_date', today())->get();

        return view(
            'admin.daily_update_task.today_task',
            compact('tasks')
        );
    }

    // public function destroy(DailyUpdateTask $dailyUpdateTask)
    // {
    //     $dailyUpdateTask->delete();

    //     return response()->json([
    //         'success' => true
    //     ]);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'task_date' => 'required|date',
            'task_time' => 'required',
        ]);

        $task = DailyUpdateTask::create([
            'user_id'     => auth()->id(),
            'title'       => $request->title,
            'task_date'   => $request->task_date,
            'task_time'   => $request->task_time,
            'priority'    => $request->priority,
            'status'      => 'Pending',
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'task' => $task
        ]);
    }

    public function index()
    {
        $tasks = DailyUpdateTask::where('user_id', auth()->id())
                    ->orderBy('task_date')
                    ->orderBy('task_time')
                    ->get();

        $events = [];

       foreach ($tasks as $task) {

            $color = match($task->priority) {
                'High' => '#dc3545',
                'Medium' => '#ffc107',
                default => '#198754',
            };

            $start = $task->task_date->format('Y-m-d') . 'T' . $task->task_time;

            $end = \Carbon\Carbon::createFromFormat(
                        'Y-m-d H:i:s',
                        $task->task_date->format('Y-m-d') . ' ' . $task->task_time
                    )
                    ->addHour()
                    ->format('Y-m-d\TH:i:s');

            $events[] = [
                'id'    => $task->id,
                'title' => $task->title,
                'start' => $start,
                'end'   => $end,
                'color' => $color,
            ];
        }

        return view('admin.daily_update_task.index', compact('tasks', 'events'));
    }

    public function edit($id)
    {
        $task = DailyUpdateTask::where('user_id', auth()->id())
                    ->findOrFail($id);

        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = DailyUpdateTask::where('user_id', auth()->id())
                    ->findOrFail($id);

        $task->delete();

        return response()->json([
            'success' => true
        ]);
    }

    // 

    public function events()
    {
        $tasks = DailyUpdateTask::where('user_id', auth()->id())
            ->orderBy('task_date')
            ->orderBy('task_time')
            ->get();

        $events = [];

        foreach ($tasks as $task) {

            $color = match ($task->priority) {
                'High' => '#dc3545',
                'Medium' => '#ffc107',
                default => '#198754',
            };

            $events[] = [
                'id'    => $task->id,
                'title' => $task->title,
                'start' => $task->task_date->format('Y-m-d') . 'T' . $task->task_time,
                'color' => $color,
            ];
        }

        return response()->json($events);
    }

}
