@extends('layouts.app')
@section('title','Dashboard')
@section('css')
<link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">
<link rel="stylesheet" href="{{asset('css/pickadate.css')}}">
<link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('css/vendors.min.css')}}">
<style type="text/css">
input[type=number] {
  -moz-appearance: textfield;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

    @media (max-width:768px){
        #notes {
            flex-direction: column;
        }
    }
</style>



@endsection
@section('content')
    <div class="row">
        <div class="d-flex justify-content-between w-100 my-2" id="notes">
            <div><h2>Filters</h2></div>

            <div class="d-flex" id="notes">
                @foreach ($notes as $note)
                     <div class="badge  text-white mr-1 mb-1 bg-info text-white">
                        <p>{{$note->title}}</p>
                        {{$note->description}}
                    </div>
                @endforeach
            </div>

            <div>
                <button type="button" class="btn btn-primary" data-toggle="dropdown" aria-haspopup="true"><i class="bx bx-plus"></i></button>
                <div class="dropdown-menu" x-placement="left-start" >
                    <button class="dropdown-item" data-toggle="modal" data-target="#addjob"><i class="bx bx-briefcase-alt mr-50"></i>  Add Job</button>
                    <button class="dropdown-item" data-toggle="modal" data-target="#studentmodal"><i class="bx bx-user-plus mr-50"></i> Add Recruting</button>
                    <button class="dropdown-item" data-toggle="modal" data-target="#addnote"><i class="bx bx-notepad mr-50"></i> Add Note</button>
                </div>

                {{-- Job Modal Start --}}
                <div class="modal fade text-left" id="addjob" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="myModalLabel1">Add Job</h3>
                                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                                    <i class="bx bx-x"></i>
                                </button>
                            </div>
                            <form id="jobform">
                                <div class="container">
                                    <div id="joberrors" class="text-center"></div>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" id="title" placeholder="Job Title">
                                    </div>
                                <div class="form-group">
                                    <label>Description </label>
                                    <textarea placeholder="Type Here..." class="form-control" id="jobdescription" name="jobdescription"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Technology</label>
                                    <select class="select2 form-control" name="technology[]" multiple="multiple">
                                        <option value="">Select Technology</option>
                                        @forelse ($technology as $item)
                                            <option value="{{$item->id}}">{{$item->tech}}</option>
                                        @empty
                                            <option value="">No Technology Found</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="submit" class="btn btn-primary ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Save</span>
                                </button>
                            </div>
                        </form>

                        </div>
                    </div>
                </div>

                {{-- Note Modal Start --}}
                <div class="modal fade text-left" id="addnote" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="myModalLabel1">Add Note</h3>
                                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                                    <i class="bx bx-x"></i>
                                </button>
                            </div>
                            <form id="noteform">
                                <div class="container">
                                    <div id="noteerrors" class="text-center"></div>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" name="notetitle" id="notetitle" placeholder="Title" class="form-control">
                                    </div>
                                <div class="form-group">
                                    <label>Description: </label>
                                    <textarea placeholder="Type Here..." class="form-control" id="description" name="description"></textarea>
                                </div>
                                 <div class="checkbox">
                                    <input type="checkbox" name="favouritenote" class="checkbox-input" id="checkbox1">
                                    <label for="checkbox1">Favourite</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="submit" class="btn btn-primary ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Save</span>
                                </button>
                            </div>
                        </form>

                        </div>
                    </div>
                </div>

                  {{-- Student Modal --}}

                <div class="modal fade text-left" id="studentmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                    <div class="modal-dialog " role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="myModalLabel1">Add Candidate</h3>
                                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                                    <i class="bx bx-x"></i>
                                </button>
                            </div>
                            <form enctype="multipart/form-data" method="post" id="studentform">
                                <div class="container">
                                    <div id="recruterrors" class="text-center"></div>
                                </div>
                            <div class="modal-body">
                                <div class="row my-2">
                                    <div class="col-md-6">
                                        <label>Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Email</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="number" name="phone" id="phone" class="form-control" placeholder="Phone Number">
                                </div>
                                <div class="form-group">
                                    <label>Technology</label>
                                    <select class="select2 form-control" name="technology[]" placeholder="Select Technology" multiple="multiple">
                                        <option value="">Select Technology</option>
                                        @forelse ($technology as $item)
                                            <option value="{{$item->id}}">{{$item->tech}}</option>
                                        @empty
                                            <option value="">No Technology Found</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group">
                                <label>Attachment</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="attachment" name="attachment">
                                    <label class="custom-file-label" for="attachment">Choose Attachment</label>
                                </div>
                                </div>
                                <div class="form-group">
                                    <label>State</label>
                                    <select name="state" class="custom-select">
                                        <option value="">Select Any One</option>
                                        @forelse ($states as $state)
                                            <option value="{{$state->id}}">{{ ucfirst(trans($state->status)) }}</option>
                                        @empty
                                        <option value="">No Found</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="submit" class="btn btn-primary ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Save</span>
                                </button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>


                    {{-- Policy modal start --}}
                    <div class="modal fade text-left show" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-modal="true" >
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="myModalLabel1">Policy</h3>
                                    <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                                        <i class="bx bx-x"></i>
                                    </button>
                                </div>

                          @if($count==1)
                                {{-- @foreach($policy as $poli) --}}

                            <form action="{{route('update.policy',$policy->id)}}" method="post" id="policyform" enctype="multipart/form-data">
                                <div class="modal-body">
                                    @csrf
                                   <div class="form-group">
                                       <label for="policy title">Title</label>
                                        <input type="text" name="title" value="{{$policy->title}}" class="form-control" id="title">
                                   </div>
                                   @error('title')
                                    <div class="error">{{ $message }}</div>
                                    @enderror

                                    <div class="form-group">
                                        <label for="policydescription">Policy Description</label>
                                        <textarea name="policy_description" id="policydescription" cols="30" rows="10" class="form-control">{{$policy->description}}</textarea>
                                    </div>
                                    @error('policydescription')
                                    <div class="error">{{ $message }}</div>
                                    @enderror

                                    <div class="form-group">

                                        <a target="blank" href="uploads/{{$policy->document}}" class="btn btn-primary form-control"> <i class="bx bx-file font-medium-5">     Document</i></a>
                                    </div>
                                    <div class="custom-file">
                                <input type="file" name="document" class="form-control">

                               </div>

                           <br>
                                    <div align="center">
                                        <br>
                                    <input type="submit" class="btn btn-primary ml-1"  value="Update">
                                      </div>
                                    </form>
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block"></span>

                                    </button>
                                </div>
                            </form>

                       @else
                            <form action="{{route('save.policy')}}" method="post" id="policyform" enctype="multipart/form-data">
                                <div class="modal-body">
                                    @csrf
                                   <div class="form-group">
                                       <label for="policy title">Title</label>
                                        <input type="text" name="title" value=""class="form-control" id="title"></div>
                                        @error('title')
                                    <div class="error">{{ $message }}</div>
                                    @enderror

                                    <div class="form-group">
                                        <label for="policydescription">Policy Description</label>
                                        <textarea name="policy_description" id="policydescription" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                     @error('policy_description')
                                    <div class="error">{{ $message }}</div>
                                    @enderror

                                    <div class="custom-file"><input type="file" name="document" class="form-control"></div>
                                    @error('document')
                                    <div class="error">{{ $message }}</div>
                                    @enderror

                           <br>
                                        <div align="center">
                                    <input type="submit" class="btn btn-primary ml-1"  value="Save">
                                        </div>
                                    </form>
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block"></span>

                                    </button>
                                </div>
                            </form>

                    @endif

                            </div>
                        </div>
                    </div>
                    {{-- Policy modal End --}}


            </div>
        </div>
    </div>
    <div id="success-message"></div>



    <div class="row">
        <div class="col-md-8">
                <form action="{{route('student.search')}}" method="post">
                    <div class="row d-flex align-items-end mt-2">
                    @csrf
                    @component('layouts.studentsearch',
                    [
                        'items' => ['Date','Technology','Status'],
                       'oldVals' => [
                           isset($searchingVals) ? $searchingVals['date'] : '',
                           isset($searchingVals) ? $searchingVals['technology'] : '',
                       isset($searchingVals) ? $searchingVals['status'] : ''],
                       'technology'=> $technology,
                       'status'=>$states
                   ])
                   @endcomponent

                <div class="col-md-3">
                    <input type="submit" name="submit" class="btn btn-outline-secondary round mr-1 mb-1" value="search">
                </div>
            </div>
        </form>

            <div class="table-responsive">
                <table class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:1%">Name</th>
                            <th style="width:1%">Email</th>
                            <th style="width:1%">Phone</th>
                            <th style="width:1%">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->phone}}</td>
                            <td>{{$item->created_at}}</td>
                        </tr>
                        @empty
                        <tr>
                            <td><h2>No Found</h2></td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
<div class="row justify-content-between mx-2">
                <div>
                  <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($students)}} of {{count($students)}} entries</div>
                </div>
                <div>
                  <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                    {{ $students->links() }}
                  </div>
                </div>
              </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-6">
                    <div class="card text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto my-1">
                                    <i class="bx bxs-group font-medium-5"></i>
                                </div>
                                <p class="text-muted mb-0 line-ellipsis">Total</p>
                                <h2 class="mb-0">{{$total_student}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
               
             <div class="col-xl-6 col-md-6 col-sm-6">
              
                    <div class="card text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto my-1">
                                    <i class="bx bx-briefcase font-medium-5"></i>
                                </div>
                                <p class="text-muted mb-0 line-ellipsis">Job Description</p>
                                <h2 class="mb-0">{{$total_job}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                     </div>
                  <div class="row"> 
                <div class="col-xl-6 col-md-6 col-sm-6">

                    <div class="card text-center" data-toggle="modal" data-target="#default" id="policy-card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto my-1">
                                    <i class="bx bx-file font-medium-5"></i>
                                </div>
                                <p class="text-muted mb-0 line-ellipsis">Policy</p>
                                
                            </div>
                        </div>
                    </div>
                </div>
                    

                </div>

            </div>
       
    </div>
    
@endsection
@section('js')

<script src="{{asset('js/picker.js')}}"></script>
<script src="{{asset('js/picker.date.js')}}"></script>
<script src="{{asset('js/daterangepicker.js')}}"></script>

<script src="{{asset('js/select2.full.min.js')}}"></script>
<script src="{{asset('js/form-select2.min.js')}}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Add New Job
    $('#jobform').on('submit',function(e){
        $('#joberrors').html('');
        $('#success-message').html('');
        e.preventDefault();

        $.ajax({
            url: "{{ route('job.store')}}",
            method: 'post',
            data: $('#jobform').serialize(),
            success: function(data){
                $.each(data.errors, function(key, value){
                    $('#joberrors').show();
                    $('#joberrors').append('<div class="bg-danger text-white py-1 mb-1">'+value+'</div>');
                    });
                if(data.success){
                    $('#success-message').append();
                $('#addjob').modal('hide');
                    $('#jobform')[0].reset();
                     toastr.success(data.success, 'Success Message');
                    
                }
                if(data.danger){
                    $('#success-message').append("");
                    toastr.success(data.danger, 'Warnning Message');
                }
                    
            }
        });
    });



    // Add New Note
    $('#noteform').on('submit',function(e){
        $('#noteerrors').html('');
        $('#success-message').html('');
        e.preventDefault();

        $.ajax({
            url: "{{ route('notes.store')}}",
            method: 'post',
            data: $('#noteform').serialize(),
            success: function(data){
                  if(data.messages)
                {
                    $('#noteerrors').append('<div class="bg-danger text-white py-1 mb-1">'+data.messages+'</div>');
                }
                $.each(data.errors, function(key, value){
                    $('#noteerrors').show();
                    $('#noteerrors').append('<div class="bg-danger text-white py-1 mb-1">'+value+'</div>');
                    });
                if(data.success){
                    $('#success-message').append("");
                    $('#addnote').modal('hide');
                    $('#noteform')[0].reset();
                    toastr.success(data.success, 'Success Message');
                   
                }
                if(data.danger){
                    $('#success-message').append("");
                    toastr.success(data.danger, 'Warnning Message');
                }
                        
            }
        });
    });

    // Add New Student
    $('#studentform').on('submit',function(e){
        $('#recruterrors').html('');
        $('#success-message').html('');
        e.preventDefault();

        $.ajax({
            url: "{{route('recrut.store')}}",
            method: 'post',
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            data: new FormData(this),
            success: function(data){
                $.each(data.errors, function(key, value){
                    $('#recruterrors').show();
                    $('#recruterrors').append('<div class="bg-danger text-white py-1 mb-1">'+value+'</div>');
                    });
                if(data.success){
                    $('#success-message').append("");
                    $('#studentmodal').modal('hide');
                    $('#studentform')[0].reset();
                    toastr.success(data.success, 'Success Message');
                    
                }
                if(data.danger){
                    $('#success-message').append("");
                    toastr.success(data.danger, 'danger Message');
                }
                

            }
        });
    });


</script>
 
@endsection

