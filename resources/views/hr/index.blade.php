@extends('layouts.app')
@section('title','Hr Details')
@section('css')

    <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">

@endsection

@section('content')

<div class="row">
    <div class="d-block">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb rounded-pill">
                <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="bx bx-home"></i></a></li>
                <li class="breadcrumb-item active">Hrs</li>
            </ol>
        </nav>
    </div>
</div>
<h2 class="w-100">Hr Details</h2>
<div class="d-block w-100">
    <div id="success-message"></div>
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
    <div class="float-right">
        <a href="{{route('hr.create')}}" class="btn btn-primary mb-1" >
            <i class='bx bx-add-to-queue mr-50'></i> Add HR
        </a>
    </div>
    <div class="clearfix"></div>


<div class="row">
    <div class="col-12">

        <form method="POST" action="{{route('hr.search')}}">
            {{ csrf_field() }}
            @component('layouts.search', ['title' => 'Search'])
                @component('layouts.searchnow', ['items' => ['Name'],
                'oldVals' => [isset($searchingVals) ? $searchingVals['name'] : '']])
                @endcomponent
            @endcomponent
        </form>
        <div class="table-responsive">
            <table class="table datatable zero-configuration">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hrs as $hr)
                    <tr>
                        <td>{{$hr->name}}</td>
                        <td>{{$hr->email}}</td>
                        <td>
                            <div class="dropdown">
                                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                                <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{route('hr.edit',$hr->id)}}" class="dropdown-item" ><i class="bx bx-edit-alt mr-1"></i> edit</a>
                                <form action="{{route('hr.destroy',$hr->id)}}" method="POST" onsubmit="return confirm('Are you sure')">
                                    @method('DELETE')
                                    @csrf
                                <button type="submit" class="dropdown-item"><i class="bx bx-trash mr-1" ></i> delete</button>
                                </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
            </table>
            <div class="row justify-content-between mx-2">
                <div>
                    <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($hrs)}} of {{count($hrs)}} entries</div>
                </div>
                <div>
                    <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                    {{ $hrs->links() }}
                    </div>
                </div>
                </div>
        </div>


    </div>
</div>
@endsection

@section('js')

    <script src="{{asset('js/datatables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
    <script>setTimeout(() => { $('.toast').hide(); }, 2000);</script>
@endsection
