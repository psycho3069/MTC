@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><h3>Role Wise Permissions</h3></div>

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
                    <div class="col-md-12">
                        
                            <table id="tree1" class="table table-dark table-hover">
                                {{-- <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>

                                <tbody>
                                      
                                      @foreach($roles as $role)
                                        <tr>
                                            <td>
                                                {{ $role->id }}
                                            </td>
                                            <td>
                                                <img src="{{asset('img')}}/admin.png" alt="--->" height="20px" width="20px">
                                                <b><big>{{ $role->name }}</big></b>
                                                
                                            </td>
                                        </tr>
                                        @if(count($role->childs))
                                            @include('admin.admin.role_wise_permission.manageChild',['childs' => $role->childs])
                                        @endif
                                      @endforeach
                                </tbody> --}}

                                    {{-- previous  --}}
                                    @foreach($roles as $role)
                                        <tr>
                                            <td>
                                                {{ $role->id }}
                                            </td>
                                            <td>
                                                <img src="{{asset('img')}}/admin.png" alt="--->" height="20px" width="20px">
                                                <b><big>{{ $role->name }}</big></b>
                                                
                                            </td>
                                        </tr>
                                        @if(count($role->childs))
                                            @include('admin.admin.role_wise_permission.manageChild',['childs' => $role->childs])
                                        @endif
                                    @endforeach
                                    {{-- previous --}}
                                
                            </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('datatable')
    
<!-- datatable -->
{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#tree1').DataTable();
    } );
</script>

@endsection