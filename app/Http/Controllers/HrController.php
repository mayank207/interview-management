<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $hrs=User::where('role_id',2)->paginate(2);
        return view('hr.index',compact('hrs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hr.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,[
            'name'=>"required|max:20",
            'email'=>"required|unique:users",
            'password' => ['required','string','same:confirm-password','min:8','max:20','regex:/[a-z]/',
            'regex:/[A-Z]/',

            'regex:/[a-z]/',

             'regex:/[0-9]/',

            'regex:/[@$!%*#?&]/'],

            'confirm-password'=>"required"
            ]);


            $hr=new User();
            $hr->name=$request->name;
            $hr->email=$request->email;
            $hr->password=bcrypt($request->password);
            $hr->role_id=2;
            $hr->save();
            return redirect()->route('hr.create')->with('success','HR is successfully added');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $hr=User::findorfail($id);
        } catch (Exception $ex) {
            return redirect()->route('hr.index')->with('danger','HR could not edit.');
        }
        return view('hr.edit',compact('hr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

            $this->validate(
                $request,[
                'name'=>"required|max:20",
                'email'=>"required",

            ]);

            User::findOrFail($id)->update($request->all());
            return redirect()->route('hr.index')->with('success','Hr Updated Successfully');
            return redirect()->route('hr.index')->with('danger','Hr not Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            User::find($id)->delete($id);

            return redirect()->route('hr.index')->with('success','Hr deleted Successfully');

        }
        catch(Exception $ex){
            return redirect()->route('hr.index')->with('danger','Hr not deleted Successfully');

        }

    }

    /**
     * Search HR
     */
    public function searchhr(Request $request)
    {
        $constraints = [
            'name' => $request['name']
            ];
        $employees = $this->doSearchingQuery($constraints);
        $constraints['name'] = $request['name'];
        return view('hr.index', ['hrs' => $employees, 'searchingVals' => $constraints]);

    }

    private function doSearchingQuery($constraints) {
        $query = DB::table('users')->select("*");
        // dd($query);
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where($fields[$index], 'like', '%'.$constraint.'%');
            }
            $index++;
        }
        return $query->paginate(5);
    }
}
