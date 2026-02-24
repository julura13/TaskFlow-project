<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PagesController extends Controller
{
    /**
     * Dashboard listing only projects the user owns or is a member of.
     */
    public function dashboard(Request $request): View
    {
        $user = $request->user();

        $projectIds = $user->projects()->pluck('id')
            ->merge($user->memberOfProjects()->pluck('projects.id'))
            ->unique()
            ->values();

        $projects = Project::with(['tasks', 'owner'])
            ->whereIn('id', $projectIds)
            ->get();

        return view('dashboard', ['projects' => $projects]);
    }
}
