@extends('layouts.app')
@section('title','Add HR')
@section('content')
<div class="row">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb rounded-pill">
            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="bx bx-home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{route('hr.index')}}">Hrs</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </nav>
    <div class="card w-100">
        <div class="card-header">
            <h2 class="card-title">Add HR</h2>
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
        <div class="card-content">
            <div class="card-body">
                <form class="form form-vertical" action="{{route('hr.store')}}" method="post">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <div class="position-relative has-icon-left">
                                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Name" value="{{old('name')}}">
                                        <div class="form-control-position">
                                            <i class="bx bx-user"></i>
                                        </div>
                                    </div>
                                    @error('name')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div class="position-relative has-icon-left">
                                    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{old('email')}}">
                                        <div class="form-control-position">
                                            <i class="bx bx-mail-send"></i>
                                        </div>
                                    </div>
                                    @error('email')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="position-relative has-icon-left">
                                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" >
                                        <div class="form-control-position">
                                            <i class="bx bx-radio-circle"></i>
                                        </div>
                                    </div>
                                    <small>At Least 8 Characters,Mixer Of Uper & Lower Case,Numberic,At Least One special character </small>
                                    @error('password')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="confirm-password">Confirm Password</label>
                                    <div class="position-relative has-icon-left">
                                    <input type="password" id="confirm-password" class="form-control @error('confirm-password') is-invalid @enderror" name="confirm-password" placeholder="Password" >
                                        <div class="form-control-position">
                                            <i class="bx bx-radio-circle-marked"></i>
                                        </div>
                                    </div>
                                    @error('confirm-password')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>setTimeout(() => { $('.toast').hide(); }, 2000);</script>
@endsection
