<?php

namespace App\Http\Controllers;

use App\Note;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotesController extends Controller
{
    private $favorite_limit=3;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes=Note::where('user_id',Auth::id())->orderBy('updated_at','desc')->paginate(10);
        return view('notes.index',compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notes.create');
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
            $favourite=0;
            if(isset($request->favouritenote))
            {
                if($this->availableFavorite())
                {
                    return response()->json(['messages'=>'Only 3 Notes is available in favourite']);
                }
                else
                {
                    $favourite=1;
                }
            }
            else
            {
                $favourite=0;
            }
            $validator=Validator::make($request->all(),[
                'notetitle'=>"required|max:20|min:3",
                'description'=>"required|max:35"
            ]);
            if ($validator->fails())
            {
                return response()->json(['errors'=>$validator->errors()->all()]);
            }
            else
            {

                $note=new Note();
                $note->title=$request->notetitle;
                $note->description=$request->description;
                $note->favourite=$favourite;
                $note->user_id=Auth::id();
                $note->save();
                return response()->json(['success'=>'Note successfully added']);
            }
        }
        else
        {
            $this->validate($request,[
                'notetitle'=>"required|min:2|max:20",
                'notedescription'=>"required|min:2|max:35",
            ]);
            try
            {
                if(isset($request->favourite)){
                    if($this->availableFavorite())
                    {
                        return redirect()->route('notes.create')->with(['danger'=>'Only 3 Notes is available in favourite']);
                    }
                    else
                    {
                        $favourite=1;
                        $note=new Note();
                        $note->title=$request->notetitle;
                        $note->description=$request->notedescription;
                        $note->favourite=$favourite;
                        $note->user_id=Auth::id();
                        $note->save();
                        return redirect()->route('notes.create')->with(['success'=>'Note successfully saved']);
                    }
                }
                else
                {
                    $favourite=0;
                    $note=new Note();
                    $note->title=$request->notetitle;
                    $note->description=$request->notedescription;
                    $note->favourite=$favourite;
                    $note->user_id=Auth::id();
                    $note->save();
                    return redirect()->route('notes.create')->with(['success'=>'Note successfully saved']);
                }
            }
            catch(Exception $ex)
            {
                return redirect()->route('notes.create')->with(['danger'=>'Note not saved']);
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $notes=Note::where('user_id',Auth::id())->findorfail($id);
        } catch (Exception $ex) {
            return redirect()->route('notes.index')->with('danger','Note could not edit.');
        }
        return view('notes.edit',compact('notes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
            $this->validate($request,
            [
                'title'=>"required|min:2|max:10",
                'description'=>"required|min:2|max:25",
            ]);

                $note=Note::find($id);
                $note->title=$request->title;
                $note->description=$request->description;
                $note->save();
                return redirect()->route('notes.index')->with(['success'=>'note is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            Note::where(['id'=>$id,'user_id'=>Auth::id()])->delete($id);
            return redirect()->route('notes.index')->with(['success' => 'Notes deleted successfully!']);
        }
        catch(Exception $ex)
        {
            return redirect()->route('notes.index')->with('danger','Note could not delete.');
        }
    }

    /**
     * Add or Remove favourite Note
     */
    public function notefavourite(Request $request)
    {
        $limit=3;
        try
        {
            if($request->current=="check"){
                $countFavourite=Note::where(['user_id'=>Auth::id(),'favourite'=>1])->count();
                if($countFavourite==$limit)
                {
                    return response()->json([
                        'danger' => 'Only 3 Notes is available in favourite'
                    ]);
                }
                else
                {
                    Note::find($request->noteid)->update(['favourite'=>1]);

                }
            }
            if($request->current=="uncheck"){
                Note::find($request->noteid)->update(['favourite'=>0]);
            }
            return response()->json([
                'success' => 'Notes added favourite successfully!'
            ]);
        }
        catch(Exception $ex)
        {
            return response()->json([
                'danger' => 'Something Wrong!'
            ]);
        }
    }


    // Check favourite is available
    public function availableFavorite()
    {
        $countFavourite=Note::where(['user_id'=>Auth::id(),'favourite'=>1])->count();
        return $countFavourite==$this->favorite_limit ? true : false;
    }

     /**
     * Search Note
     */
    public function searchnote(Request $request)
    {
        $constraints = [
            'title' => $request['title']
            ];
        $employees = $this->doSearchingQuery($constraints);
        $constraints['title'] = $request['title'];
        return view('notes.index', ['notes' => $employees, 'searchingVals' => $constraints]);

    }

    private function doSearchingQuery($constraints) {
        $query = Note::select("*");
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
