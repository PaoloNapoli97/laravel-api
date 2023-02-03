<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('type', 'technologies')->get();

        return $projects;
    }

    public function show($slug)
    {
        try{
        $project = Project::where('slug', $slug)->with('type', 'technologies')->first();

        return $project;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response([
                'error' => '404 Page not Found'
            ], 404);
        }

        return $project;
    }
}
