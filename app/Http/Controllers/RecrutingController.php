<?php

namespace App\Http\Controllers;

use App\Student;
use Carbon\Carbon;
use App\Technology;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecrutingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            
             $data=Student::with('getTechnology')->latest()->get();
            return response()->json(['success'=>$data]);
        }
        else
        {
            return view('recruting.index');
        }
    }

    /**
     * Update Order Student
     */

    public function updateOrder(Request $request){

        $state_id=$request->state;
        $student=Student::find($request->ids);
        $student->state_id=$state_id;
        $student->save();
        return ['success'=>true,'message'=>'Updated'];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
    {
        if($request->ajax()){
            if($request->studentid)
            {
                $validator=Validator::make($request->all(),[
                    'editname'=>"required|string|min:2",
                    'editemail'=>"required",
                    'editphone'=>"required|numeric|digits:10",
                    'edittechnology'=>"required"
                ]);
                if ($validator->fails())
                {
                    return response()->json(['errors'=>$validator->errors()->all()]);
                }
                else
                {
                    $attachment_name='';
                    $student=Student::find($request->studentid);
                    $student->name=$request->editname;
                    $student->email=$request->editemail;
                    $student->phone=$request->editphone;
                    if ($request->hasFile('attachment')) {
                        $image = $request->file('attachment');
                        $attachment_name = time().'.'.$image->getClientOriginalExtension();
                        $destinationPath = public_path('/attachment');
                        $image->move($destinationPath, $attachment_name);
                    }
                    $student->attachment=$attachment_name;
                    $student->getTechnology()->sync($request->edittechnology);
                    $student->save();

                    return response()->json(['success'=>'Student Profile updated successfully..']);
                }
            }
            else
            {
                $validator=Validator::make($request->all(),[
                    'name'=>"required|string|min:2",
                    'email'=>"required|unique:student,email",
                    'phone'=>"required|numeric|digits:10",
                    'attachment'=>"required",
                    'technology'=>"required",
                    'state'=>"required"
                ]);
                if ($validator->fails())
                {
                    return response()->json(['errors'=>$validator->errors()->all()]);
                }
                else
                {
                    if ($request->hasFile('attachment')) {
                    $image = $request->file('attachment');
                    $name = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/attachment');
                    $image->move($destinationPath, $name);
                    }
                    $student=new Student();
                    $student->name=$request->name;
                    $student->email=$request->email;
                    $student->phone=$request->phone;
                    $student->attachment=$name;
                    $date=Carbon::now()->format('d-m-y');
                    $student->date=$date;
                    $student->state_id=$request->state;
                    $student->save();
                    $student->getTechnology()->attach($request->technology);
                    return response()->json(['success'=>'Student is successfully added']);
                }
            }

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            $technology=Technology::select('id','tech')->get(); 

            $single_student=Student::with('getTechnology')->findorfail($id);
            return response()->json(['success'=>$single_student,'technology'=>$technology]);
        }
        catch(Exception $ex)
        {
            return response()->json(['danger'=>'Not found']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            Student::findOrFail($id)->delete();

            return response()->json(['success'=>'Student Delete successfully']);
        }
        catch(Exception $ex)
        {
            return response()->json(['danger'=>'Student could not delete']);
        }
    }

}
