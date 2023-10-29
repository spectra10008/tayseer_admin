<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\BeneficiaryProject;
use App\Models\Sector;
use App\Models\Beneficiary;
use App\Http\Requests\StoreProjectFileRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;
use Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderby('id','desc')->get();
        return view('projects.index')
        ->with('projects',$projects)
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sectors = Sector::orderby('id','desc')->get();
        return view('projects.create')
        ->with('sectors',$sectors)
        ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $project = new Project();
        $project->project_name = $request->project_name;
        $project->address = $request->address;
        $project->sector_id =  $request->sector_id;
        $project->status =  $request->status;
        $project->start_date =  $request->start_date;
        $project->fund_amount_need_sdg =  $request->fund_amount_need_sdg;
        $project->need =  $request->need;
        $project->notes =  $request->notes;
        $project->location =  $request->latitude.','.$request->longitude;
        $project->desc =  $request->desc;
        // store files
        $image = $request->file('image')->store('public/projects');
        $project->image = $image;
        // end
        $project->save();
        toastr()->success('تم حفظ بيانات المشروع بنجاح !!');
        return redirect('/panel-admin/projects');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $check_beneficiary_projects = BeneficiaryProject::where('project_id',$project->id)->get();
        $beneficiary_ids = [];

        foreach($check_beneficiary_projects as $check_beneficiary_project)
        {
            $beneficiary_ids[] = $check_beneficiary_project->beneficiary_id;
        }
        $beneficiaries = Beneficiary::whereNotIn('id',$beneficiary_ids)->get();

        return view('projects.show')
        ->with('project',$project)
        ->with('beneficiaries',$beneficiaries)
        ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $sectors = Sector::orderby('id','desc')->get();
        return view('projects.edit')
        ->with('sectors',$sectors)
        ->with('project',$project)
        ;
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
        $project->project_name = $request->project_name;
        $project->address = $request->address;
        $project->sector_id =  $request->sector_id;
        $project->status =  $request->status;
        $project->start_date =  $request->start_date;
        $project->fund_amount_need_sdg =  $request->fund_amount_need_sdg;
        $project->need =  $request->need;
        $project->notes =  $request->notes;
        $project->location =  $request->latitude.','.$request->longitude;
        $project->desc =  $request->desc;
        // store files
        if(isset($request->image) && $request->image != null)
        {
            $image = $request->file('image')->store('public/projects');
            $project->image = $image;
        }
        // end
        $project->update();

        toastr()->success('تم تعديل بيانات المشروع بنجاح !!');
        return redirect('/panel-admin/projects');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $check_beneficiary_project = BeneficiaryProject::where('project_id',$project->id)->first();
        if($check_beneficiary_project)
        {
            toastr()->error(' لا يمكنك حذف المشروع   ,المشروع مرتبط ببيانات اخرى !!');
            return back();
        }
        $project->delete();

        toastr()->success('تم حذف المشروع بنجاح !!');
        return redirect('/panel-admin/projects');
    }

    public function add_beneficiaries_project(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|unique:beneficiary_projects,email',
            'phone' => 'required|numeric|unique:beneficiary_projects,email',
            'age' => 'required|numeric',
            'address' => 'required|string|max:255',
        ]);

            $beneficiary_project = new BeneficiaryProject();
            $beneficiary_project->project_id = $request->project_id;
            $beneficiary_project->name = $request->name;
            $beneficiary_project->email = $request->email;
            $beneficiary_project->phone = $request->phone;
            $beneficiary_project->age = $request->age;
            $beneficiary_project->address = $request->address;
            $beneficiary_project->save();

        toastr()->success('تم الإضافة بنجاح !!');
        return back();
    }

    public function delete_beneficiaries_project($id)
    {
        $check_beneficiary_project = BeneficiaryProject::find($id);
        $check_beneficiary_project->delete();

        toastr()->success('تم حذف العضو بنجاح !!');
        return back();
    }

    public function add_project_file(StoreProjectFileRequest $request)
    {
        $project_file = new ProjectFile();
        $project_file->project_id = $request->project_id;
        $project_file->file_name = $request->file_name;
        if (isset($request->file) && $request->file != null) {
            $file_path = $request->file('file')->store('public/project_files');
            $project_file->file = $file_path;
        }
        $project_file->save();

        toastr()->success('تم الحفظ بنجاح !!');
        return back();
    }

    public function delete_project_file($id)
    {
        $project_file = ProjectFile::find($id);
        if (Storage::exists($project_file->file)) {
            Storage::delete($project_file->file);
        }
        $project_file->delete();
        toastr()->success('تم الحذف بنجاح !!');
        return back();
    }
}
