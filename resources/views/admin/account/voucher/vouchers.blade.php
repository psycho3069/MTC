@extends('admin.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><big> <strong>VOUCHERS LIST</strong> </big></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>

                <p class="alert-success" style="font-size: 20px; color: white; background:#149278; padding: 0 30px 0 30px;">
                    @php
                      $message=Session::get('message');
                        if($message) {
                          echo $message;
                          Session::put('message',null);
                        }
                    @endphp
                </p>

                <table id="room_reservation" class="table table-bordered table-primary table-hover">
                    <thead>
                        <tr>
                            <th class="">#</th>
                            <th class="">Code</th>
                            <th class="">Type</th>
                            <th class="w-25">Date</th>
                            <th class="">Amount</th>           
                            <th class="">Details</th>
                            <th class="">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($voucher_info as $voucher)
                        <tr>
                            <td width="5%">{{$voucher->id}}</td>
                            <td>{{$voucher->code}}</td>
                            <td>
                                @foreach($voucher_type_info as $voucher_type)
                                    @if($voucher_type->id == $voucher->type_id)
                                        {{$voucher_type->name}}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{date("d-m-Y", strtotime($voucher->date))}}</td>
                            <td>{{$voucher->amount}}</td>
                            <td>{{$voucher->details}}</td>
                            <td width="15%" align="right">
                              <a href="{{URL::to('view_voucher/'.$voucher->id)}}" class="" title="View"><img src="{{asset('img')}}/view.png" alt="view" height="20px" width="20px"></a>
                              <a href="{{URL::to('edit_voucher/'.$voucher->id)}}" class="" title="Edit"><img src="{{asset('img')}}/edit.png" alt="edit" height="20px" width="20px"></a>
                              <a href="{{URL::to('delete_voucher/'.$voucher->id)}}" class="" title="Delete" id="delete"><img src="{{asset('img')}}/delete.png" alt="delete" height="20px" width="20px"></a>
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>

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
        $('#room_reservation').DataTable({
            "paging": true,
            "ordering":  true,
            "pagingType": "full_numbers"
          });
    } );
</script>

@endsection