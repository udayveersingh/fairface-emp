@extends('layouts.backend')

@section('styles')
@endsection

@section('page-header')
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Email Inbox</h3>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <a href="" class="btn btn-danger compose">Inbox</a>
                <div class="card-body">
                    <div id="email-sidebar-menu" class="email-sidebar-menu">
                        <ul>
                            <li class="">
                                <a href=""><span>Inbox</span></a>
                            </li>
                            <li class="">
                                <a href=""><span>Sent Mail</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
