<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $projects = Project::all();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();


        
        if ( isset($data['cover_image']) ) { 
            $data['cover_image'] = Storage::disk('public')->put('uploads', $data['cover_image']);
            // $new_project->cover_image = $img_path;
            //or
            //$new_project->cover_image = Storage::disk('public')->put('uploads', $data['cover_image']);
        }
        

        $new_project = new Project();
        $new_project->fill($data);
        $new_project->slug = Str::slug($new_project->title);
        $new_project->save();

        if ( isset($data['technologies'])) {
            $new_project->technologies()->sync($data['technologies']);
        }

        return redirect()->route('admin.projects.index')->with('message', 'Progetto aggiunto');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //aggiunta nome url tramite slug
        // $project = Project::where('slug', $slug)->first();

        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.edit', compact('project', 'types', 'technologies' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {

        $data = $request->validated();

        $old_title = $project->title;

        $project->slug = Str::slug($data['title']);

        
        // if ( $data['cover_image'] ) { 
        //     // $img_path = Storage::disk('public')->put('uploads', $data['cover_image']);
        //     // $new_project->cover_image = $img_path;
        //     //or
        //     $project->cover_image = Storage::disk('public')->put('uploads', $data['cover_image']);
        // }
        if ( isset($data['cover_image']) ) {
            if( $project->cover_image ) {
                Storage::delete($project->cover_image);
            }
            $data['cover_image'] = Storage::put('uploads', $data['cover_image']);
        }

        if( isset($data['no_image']) && $project->cover_image  ) {
            Storage::delete($project->cover_image);
            $project->cover_image = null;
        }


        $project->update($data);
        $technologies = isset($data['technologies']) ? $data['technologies'] : [];
        $project->technologies()->sync($technologies);

        return redirect()->route('admin.projects.index')->with('message', 'Il progetto è stato aggiornato');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        
        return redirect()->route('admin.projects.index')->with('message', 'Il progetto è stato cancellato');
    }
}
