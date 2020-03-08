@extends('admin.master')

@section('content')
    <link href="{{ asset('tree/style.min.css') }}" rel="stylesheet" type="text/css" />
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3>Account Data</h3></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p class="alert-success" style="font-size: 20px; color: white; background:#149278; padding: 0 30px 0 30px;">
                        @php
                          $message=Session::get('message');
                            if($message) {
                              echo $message;
                              Session::put('message',null);
                            }
                        @endphp
                    </p>
                        <nav class="custom navbar navbar-expand-sm navbar-dark sticky-top" style="width: 85px; min-height: 30px;">
                            <div class="custom navbar-collapse collapse" id="navbar4">
                                <ul class="custom navbar-nav nav-fill w-100" style="width: 65px; padding: 0;">
                                    <li class="custom nav-item dropdown dmenu" style="width: 65px; padding: 0;">
                                        <a class="custom nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" style="width: 65px; padding: 0;">
                                            Action
                                        </a>
                                        <div class="custom dropdown-menu sm-menu">
                                            <a class="custom dropdown-item active" href="{{URL::to('/hotel_management/room/room_viewer')}}">Ground</a>
                                            <a class="custom dropdown-item" href="{{URL::to('/hotel_management/room/room_viewer/floor1')}}">Floor 1</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </nav>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="accounts_tree">
                                <div id="container1">
                                    <ul>
                                        <li>Root node 101
                                            <ul>
                                                <li>Child node 1
                                                    <ul>
                                                        <li>Grand Child 1
                                                            <ul>
                                                                <li>Grand Child 1
                                                                    <ul>
                                                                        <li>Grand Child 1</li>
                                                                    </ul>
                                                                </li>
                                                                <li>Grand Child 2</li>
                                                            </ul>
                                                        </li>
                                                        <li>Grand Child 2</li>
                                                    </ul>
                                                </li>
                                                <li>Child node 2</li>
                                            </ul>
                                        </li>
                                        <li>Root node 2
                                            <ul>
                                                <li>Child node 1
                                                    <ul>
                                                        <li>Grand Child 1</li>
                                                        <li>Grand Child 2</li>
                                                    </ul>
                                                </li>
                                                <li>Child node 2</li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <ul>
                                        <li>Root node 1
                                            <ul>
                                                <li>Child node 1
                                                    <ul>
                                                        <li>Grand Child 1</li>
                                                        <li>Grand Child 2</li>
                                                    </ul>
                                                </li>
                                                <li>Child node 2</li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('#container1').jstree();
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('datatable')
    <script src="{{ asset('tree/jstree.min.js') }}" type="text/javascript"></script>
@endsection