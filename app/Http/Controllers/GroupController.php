<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\BeneficiaryGroup;
use App\Models\Beneficiary;
use App\Models\GroupRegisterType;
use App\Models\Bank;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::with('beneficiary','beneficiary_group.beneficiary')->orderby('id','desc')->get();
        return view('groups.index')
        ->with('groups',$groups)
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $beneficiaries = Beneficiary::orderby('id','desc')->get();
        $types = GroupRegisterType::orderby('id','desc')->get();
        $banks = Bank::orderby('id','desc')->get();

        return view('groups.create')
        ->with('beneficiaries',$beneficiaries)
        ->with('types',$types)
        ->with('banks',$banks)
        ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRequest $request)
    {

        $groups = new Group();
        $groups->group_name = $request->group_name;
        $groups->group_address = $request->group_address;
        $groups->group_contact =  $request->group_contact;
        $groups->is_registered =  $request->is_registered;
        $groups->group_leader_id =  $request->group_leader_id;
        $groups->register_type_id =  $request->register_type_id;
        $groups->is_bank_account =  $request->is_bank_account;
        if($request->is_bank_account == 1)
        {
            $groups->bank_id =  $request->bank_id;
            $groups->branch_name =  $request->branch_name;
            $groups->account_no =  $request->account_no;
        }
        // store files
        $foundation_certificate = $request->file('foundation_certificate')->store('public/foundation_certificates');

        $groups->foundation_certificate = $foundation_certificate;
        // end
        $groups->save();

        $beneficiary_group = new BeneficiaryGroup();
        $beneficiary_group->beneficiary_id = $request->group_leader_id;
        $beneficiary_group->group_id = $groups->id;
        $beneficiary_group->save();

        toastr()->success('تم حفظ بيانات المجموعة بنجاح !!');
        return redirect('/panel-admin/groups');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $check_beneficiary_groups = BeneficiaryGroup::where('group_id',$group->id)->get();
        $beneficiary_ids = [];

        foreach($check_beneficiary_groups as $check_beneficiary_group)
        {
            $beneficiary_ids[] = $check_beneficiary_group->beneficiary_id;
        }
        $beneficiaries = Beneficiary::whereNotIn('id',$beneficiary_ids)->get();

        return view('groups.show')
        ->with('group',$group)
        ->with('beneficiaries',$beneficiaries)

        ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        $types = GroupRegisterType::orderby('id','desc')->get();
        $banks = Bank::orderby('id','desc')->get();
        $beneficiaries = Beneficiary::orderby('id','desc')->get();

        return view('groups.edit')
        ->with('group',$group)
        ->with('types',$types)
        ->with('banks',$banks)
        ->with('beneficiaries',$beneficiaries)
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGroupRequest  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        $group->group_name = $request->group_name;
        $group->group_address = $request->group_address;
        $group->group_contact =  $request->group_contact;
        $group->is_registered =  $request->is_registered;
        $group->group_leader_id =  $request->group_leader_id;
        $group->register_type_id =  $request->register_type_id;
        $group->is_bank_account =  $request->is_bank_account;
        if($request->is_bank_account == 1)
        {
            $group->bank_id =  $request->bank_id;
            $group->branch_name =  $request->branch_name;
            $group->account_no =  $request->account_no;
        }
        // store files
        if(isset($request->foundation_certificate) && $request->foundation_certificate != null)
        {
            $foundation_certificate = $request->file('foundation_certificate')->store('public/foundation_certificates');
        }
        // end
        $group->update();
        $update_is_leader = BeneficiaryGroup::where('group_id',$group->id)->update(['is_leader'=>0]);
        $check_beneficiary_group = BeneficiaryGroup::where('beneficiary_id',$request->group_leader_id)->where('group_id',$group->id)->first();
        if($check_beneficiary_group == null)
        {
            $beneficiary_group = new BeneficiaryGroup();
            $beneficiary_group->beneficiary_id = $request->group_leader_id;
            $beneficiary_group->group_id = $group->id;
            $beneficiary_group->is_leader = 1;
            $beneficiary_group->save();
        }else
        {
            $check_beneficiary_group->is_leader = 1;
            $check_beneficiary_group->update();
        }

        toastr()->success('تم تعديل بيانات المجموعة بنجاح !!');
        return redirect('/panel-admin/groups');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $check_beneficiary_group = BeneficiaryGroup::where('group_id',$group->id)->first();
        if($check_beneficiary_group)
        {
            toastr()->error(' لا يمكنك حذف المجموعة   ,المجموعة مرتبطة ببيانات اخرى !!');
            return back();
        }
        $group->delete();

        toastr()->success('تم الحذف بنجاح !!');
        return redirect('/panel-admin/groups');
    }

    public function add_beneficiaries_group(Request $request)
    {
        $beneficiary_ids = $request->beneficiary_id;
        foreach($beneficiary_ids as $beneficiary_id)
        {
            $beneficiary_group = new BeneficiaryGroup();
            $beneficiary_group->beneficiary_id = $beneficiary_id;
            $beneficiary_group->group_id = $request->group_id;
            $beneficiary_group->is_leader = 0;
            $beneficiary_group->save();
        }

        toastr()->success('تم الإضافة بنجاح !!');
        return back();
    }

    public function delete_beneficiaries_group($id)
    {
        $check_beneficiary_group = BeneficiaryGroup::find($id);
        $get_all = BeneficiaryGroup::all();
        if($check_beneficiary_group->is_leader == 1 && count($get_all) == 1)
        {
            toastr()->error(' لا يمكنك حذف العضو ,العضو هو قائد المجموعة ولا يوجد عضو أخر  !!');
            return back();
        }else
        {
            $get_second = BeneficiaryGroup::where('group_id',$check_beneficiary_group->group_id)->where('beneficiary_id','!=',$check_beneficiary_group->beneficiary_id)->first();
            $get_second->is_leader = 1;
            $get_second->update();
            $check_beneficiary_group->delete();
        }

        toastr()->success('تم حذف العضو بنجاح !!');
        return back();
    }



}
