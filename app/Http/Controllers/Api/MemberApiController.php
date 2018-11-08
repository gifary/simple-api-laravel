<?php
/**
 * Created by PhpStorm.
 * User: gifary
 * Date: 11/6/18
 * Time: 1:05 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $member = Member::with('package')->orderBy('created_at','desc')->paginate(20);
        return $this->sendResponse($member,'success',200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->sendResponse(['create'],'success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'package_id'  => 'required|exists:packages,name',
            'full_name'   => 'required|max:255',
            'phone_number'=> 'required|max:16',
            'address'     => 'required',
            'age'         => 'required|integer',
            'identify_number'=> 'required|string|max:255',
            'is_member_another_vcd_rental'=>'required',
            'info_vcd_rental' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendResponse($validator->errors(),'error','401');
        }

        $member = Member::create($request->except('contacts'));

        $contacts = $request->contacts;
        $total = 0;
        foreach ($contacts as $contact)
        {
            if(!empty($contact['name']) && !empty($contact['phone_number']))
            {
                $new_contact = Contact::firstOrCreate(['name'=>$contact['name'],'phone_number'=>$contact['phone_number']]);
                $member->addContact($new_contact->id);
                $total++;
            }
        }

        if($total>=2)
        {
            $member->is_active = true;
            $member->save();
        }

        return $this->sendResponse($member,'success',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = Member::with(['package','contacts'])->where('id',$id)->first();
        return $this->sendResponse($member,'success');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'package_id'  => 'required|exists:packages,name',
            'full_name'   => 'required|max:255',
            'phone_number'=> 'required|max:16',
            'address'     => 'required',
            'age'         => 'required|integer',
            'identify_number'=> 'required|string|max:255',
            'is_member_another_vcd_rental'=>'required',
            'info_vcd_rental' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendResponse($validator->errors(),'error','401');
        }

        $member = Member::findOrFail($id);

        $member->update($request->except('contacts'));

        $member->contacts()->detach();

        $contacts = $request->contacts;
        $total = 0;
        foreach ($contacts as $contact)
        {
            if(!empty($contact['name']) && !empty($contact['phone_number']))
            {
                $new_contact = Contact::firstOrCreate(['name'=>$contact['name'],'phone_number'=>$contact['phone_number']]);
                $member->addContact($new_contact->id);
                $total++;
            }
        }

        if($total>=2)
        {
            $member->is_active = true;
            $member->save();
        }

        return $this->sendResponse($member,'success',200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->contacts()->detach();
        $member->delete();
        $this->sendResponse($member,'success',200);
    }
}
