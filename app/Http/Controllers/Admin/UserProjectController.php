<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Project;

class UserProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with([

            'department',

            'assignedTo',

            'attachments',

            'modules'

        ])
        ->where('email', auth()->user()->email)
        ->latest()
        ->paginate(12);

        return view('admin.projects.user.index', compact('projects'));
    }

    // public function show(Project $project)
    // {
    //     abort_unless(
    //         $project->email == auth()->user()->email,
    //         403
    //     );

    //     $project->load([

    //         'department',

    //         'assignedTo',

    //         'attachments',

    //         'modules.subModules',

    //     ]);

    //     return view('admin.projects.user.show', compact('project'));
    // }

    public function show(Project $project)
{
    abort_unless(
        $project->email == auth()->user()->email,
        403
    );

    $project->load([

        'department',

        'assignedTo',

        'attachments',

        'modules' => function ($query) {

            $query->ordered();

        },

        'modules.subModules'

    ]);

    $overallProgress = (int) round(
        $project->modules->avg('progress') ?? 0
    );

    return view('admin.projects.user.show', compact(

        'project',

        'overallProgress'

    ));
}
}
