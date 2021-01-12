<?php

namespace App\Http\Controllers;

use App\Job;
use Exception;
use App\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs=Job::with('getTechnology')->orderBy('updated_at','desc')->paginate(10);
        $technology=Technology::all();
        return view('jobs.index',compact('jobs','technology'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $technology=Technology::all();
        return view('jobs.create',compact('technology'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax())
        {
            $validator=Validator::make($request->all(),[
                'title'=>"required|min:2|max:50",
                'jobdescription'=>"required|min:2|max:200",
                'technology'=>"required"
            ]);
            if ($validator->fails())
            {
                return response()->json(['errors'=>$validator->errors()->all()]);
            }
            else
            {
                $job=new Job();
                $job->title=$request->title;
                $job->description=$request->jobdescription;
                $job->save();
                $job->getTechnology()->attach($request->technology);
                return response()->json(['success'=>'Job successfully added']);
            }
        }
        else
        {
            $this->validate($request,[
                'jobtitle'=>"required|min:2|max:50",
                'jobdescription'=>"required|min:2|max:200",
                'jobtechnology'=>"required",
            ]);
            $job=new Job();
            $job->title=$request->jobtitle;
            $job->description=$request->jobdescription;
            $job->save();
            $job->getTechnology()->attach($request->jobtechnology);
            return redirect()->route('job.create')->with('success','Job added successfully.');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $technology=Technology::all();
            $job=Job::with('getTechnology')->findorfail($id);
            $a=collect($job->getTechnology);
        } catch (Exception $ex) {
            return redirect()->route('job.index')->with('danger','Job could not edit.');
        }
        return view('jobs.edit',compact('job','technology'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Job $job)
    {
        $this->validate($request,[
            'jobtitle'=>"required|min:2|max:50",
            'jobdescription'=>"required|min:2|max:200"
        ]);
        $job=Job::updateOrCreate(['id'=>$job->id],$request->all());
        $job->getTechnology()->sync($request->jobtechnology);
        return redirect()->route('job.index')->with(['success'=>'Job is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            Job::findOrFail($id)->delete();
            return redirect()->route('job.index')->with('success','Job deleted successfully.');
        }
        catch(Exception $ex)
        {
            return redirect()->route('job.index')->with('danger','Job could not delete.');
        }
    }

     /**
     * Search HR
     */
    public function searchjob(Request $request)
    {
        $constraints = [
            'title' => $request['title'],
            'technology'=>$request['technology']
            ];
        $employees = $this->doSearchingQuery($constraints);
        $constraints['title'] = $request['title'];
        $technology=Technology::all();
        return view('jobs.index', ['jobs' => $employees, 'searchingVals' => $constraints,'technology'=>$technology]);

    }

    private function doSearchingQuery($constraints) {
        $query = Job::with('getTechnology');
        $fields = array_keys($constraints);
        $result=$constraints['technology'];
        if(!empty($result))
        {
            $query->whereHas('getTechnology',function($q) use($result){
                $q->whereIn('id',$result);
            });
        }
        $query = $query->where($fields[0], 'like', '%'.$constraints['title'].'%');
        return $query->paginate(5);
    }
}
