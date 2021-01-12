@extends('layouts.app')
@section('title','All Jobs')
@section('css')
    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
@endsection
@section('content')

<div class="row">
    <div class="d-block">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb rounded-pill">
                <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="bx bx-home"></i></a></li>
                <li class="breadcrumb-item active"><a href="{{route('job.index')}}">Job</a></li>
            </ol>
        </nav>
    </div>
    <h2 class="w-100">Jobs Details</h2>

    <div class="d-block w-100">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has($msg))
                <div id="toast-container" class="toast-container toast-top-right">
                    <div class="toast toast-success" aria-live="polite" style="display: block;">
                        <div class="toast-title">Success </div>
                        <div class="toast-message"> {{ Session::get($msg) }}</div>
                    </div>
                </div>
                @endif
        @endforeach
    </div>
</div>

    <div class="float-right">
        <a href="{{route('job.create')}}" class="btn btn-primary btn-rounded">Add Job &nbsp;<i class="bx bx-user-plus"></i></a>
    </div>
    <div class="clearfix"></div>

<div class="row">
    <div class="col-12">

            <form method="POST" action="{{route('job.search')}}" class="mb-2">
                {{ csrf_field() }}
                @component('layouts.search', ['title' => 'Search'])
                    @component('jobs.jobsearchnow',
                     [
                         'items' => ['title','Technology'],
                        'oldVals' => [isset($searchingVals) ? $searchingVals['title'] : '',isset($searchingVals) ? $searchingVals['technology'] : ''],
                        'technology'=> $technology
                    ])
                    @endcomponent
                @endcomponent
             </form><div class="table-responsive">
        <table class="table datatable zero-configuration">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Technology</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jobs as $job)
                <tr>
                    <td>{{$job->title}}</td>
                    <td>{{$job->description}}</td>
                    <td>
                        @forelse ($job->getTechnology as $tech)
                        <div class="badge badge-pill badge-primary mr-1 mb-1">{{$tech->tech}}</div>
                        @empty
                            No Found
                        @endforelse
                    </td>
                    <td>{{$job->created_at}}</td>
                    <td>
                        <div class="dropdown">
                            <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                            <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{route('job.edit',$job->id)}}" class="dropdown-item"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                            <form action="{{route('job.destroy',$job->id)}}" method="post" onsubmit="return confirm('Are You sure ?')">
                                @csrf
                                @method('delete')
                                <button class="dropdown-item" type="submit"><i class="bx bx-trash mr-1" ></i> delete</button>
                            </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <h3>No Found</h3>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="row justify-content-between mx-2">
            <div>
              <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($jobs)}} of {{count($jobs)}} entries</div>
            </div>
            <div>
              <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                {{ $jobs->links() }}
              </div>
            </div>
          </div>
    </div>
</div>

</div>
</div>

@endsection

@section('js')

<script src="{{asset('js/select2.full.min.js')}}"></script>
<script src="{{asset('js/form-select2.min.js')}}"></script>
<script>setTimeout(() => { $('.toast').hide(); }, 2000);</script>



@endsection

