<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBeneficiaryFileRequest;
use App\Http\Requests\StoreBeneficiaryRequest;
use App\Http\Requests\UpdateBeneficiaryRequest;
use App\Models\Bank;
use App\Models\Beneficiary;
use App\Models\BeneficiaryFile;
use App\Models\Group;
use App\Models\Project;
use App\Models\SocialSituation;
use Storage;
use Illuminate\Support\Str;

class BeneficiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $beneficiaries = Beneficiary::orderby('id', 'desc')->get();

        return view('beneficiaries.index')
            ->with('beneficiaries', $beneficiaries)
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = SocialSituation::all();
        $banks = Bank::all();
        return view('beneficiaries.create')
            ->with('statuses', $statuses)
            ->with('banks', $banks)
        ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBeneficiaryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBeneficiaryRequest $request)
    {

        $beneficiaries = new Beneficiary();
        $beneficiaries->name = $request->name;
        $beneficiaries->gender = $request->gender;
        $beneficiaries->email = $request->email;
        $beneficiaries->phone = $request->phone;
        $beneficiaries->age = $request->age;
        $beneficiaries->id_number = $request->id_number;
        $beneficiaries->social_situation_id = $request->social_situation_id;
        $beneficiaries->children_no = $request->children_no;
        $beneficiaries->address = $request->address;
        $beneficiaries->is_bank_account = $request->is_bank_account;
        $beneficiaries->location_on_map = $request->latitude . ',' . $request->longitude;
        if ($request->is_bank_account == 1) {
            $beneficiaries->bank_id = $request->bank_id;
            $beneficiaries->branch_name = $request->branch_name;
            $beneficiaries->account_no = $request->account_no;
        }
        // store files
        $image_path = $request->file('image')->store('public/beneficiaries');
        $id_image_path = $request->file('id_image')->store('public/beneficiaries_ids');

        $beneficiaries->image = $image_path;
        $beneficiaries->id_image = $id_image_path;
        $beneficiaries->is_active = 1;
        // end
        $beneficiaries->save();

        toastr()->success('تم حفظ بيانات المستخدم بنجاح !!');
        return redirect('/panel-admin/beneficiaries');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $beneficiary = Beneficiary::whereId($id)->with('beneficiary_requests')->first();
         return view('beneficiaries.show')
            ->with('beneficiary', $beneficiary)
        ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function edit(Beneficiary $beneficiary)
    {
        $statuses = SocialSituation::all();
        $banks = Bank::all();
        return view('beneficiaries.edit')
            ->with('beneficiary', $beneficiary)
            ->with('statuses', $statuses)
            ->with('banks', $banks)
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBeneficiaryRequest  $request
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBeneficiaryRequest $request, Beneficiary $beneficiary)
    {
        $beneficiary->name = $request->name;
        $beneficiary->gender = $request->gender;
        $beneficiary->email = $request->email;
        $beneficiary->phone = $request->phone;
        $beneficiary->age = $request->age;
        $beneficiary->id_number = $request->id_number;
        $beneficiary->social_situation_id = $request->social_situation_id;
        $beneficiary->children_no = $request->children_no;
        $beneficiary->address = $request->address;
        $beneficiary->is_bank_account = $request->is_bank_account;
        $beneficiary->location_on_map = $request->latitude . ',' . $request->longitude;
        if ($request->is_bank_account == 1) {
            $beneficiary->bank_id = $request->bank_id;
            $beneficiary->branch_name = $request->branch_name;
            $beneficiary->account_no = $request->account_no;
        }
        // store files
        if (isset($request->image) && $request->image != null) {
            $image_path = $request->file('image')->store('public/beneficiaries');
            $beneficiary->image = $image_path;
        }

        if (isset($request->id_image) && $request->id_image != null) {
            $id_image_path = $request->file('id_image')->store('public/beneficiaries_ids');
            $beneficiary->id_image = $id_image_path;
        }
        // end
        $beneficiary->save();

        toastr()->success('تم تعديل بيانات المستخدم بنجاح !!');
        return redirect('/panel-admin/beneficiaries');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beneficiary $beneficiary)
    {
        $project = Project::where('beneficiary_id', $beneficiary->id)->first();
        $group = Group::where('group_leader_id', $beneficiary->id)->first();

        if ($project || $group) {
            toastr()->error(' لا يمكنك حذف المستفيد  ,المستفيد مرتبط ببيانات اخرى !!');
            return back();
        }
        $beneficiary->delete();

        toastr()->success('تم الحذف بنجاح !!');
        return redirect('/panel-admin/beneficiaries');
    }

    public function add_beneficiaries_file(StoreBeneficiaryFileRequest $request)
    {
        $beneficiary_file = new BeneficiaryFile();
        $beneficiary_file->beneficiary_id = $request->beneficiary_id;
        $beneficiary_file->file_name = $request->file_name;
        if (isset($request->file) && $request->file != null) {
            $file_path = $request->file('file')->store('public/beneficiaries_files');
            $beneficiary_file->file = $file_path;
        }
        $beneficiary_file->save();

        toastr()->success('تم الحفظ بنجاح !!');
        return back();
    }

    public function delete_beneficiaries_file($id)
    {
        $beneficiary_file = BeneficiaryFile::find($id);
        if (Storage::exists($beneficiary_file->file)) {
            Storage::delete($beneficiary_file->file);
        }
        $beneficiary_file->delete();
        toastr()->success('تم الحذف بنجاح !!');
        return back();
    }
}
