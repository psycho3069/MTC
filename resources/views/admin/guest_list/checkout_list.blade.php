@extends('admin.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"> <big> <strong>Entry Register</strong> </big> </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
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

                    <table id="userrole" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>SL No</th>
                            <th>Guest/Organization Name</th>
                            <th>Contact No</th>
                            <th>Total Bill</th>
                            <th>Discount</th>
                            <th>Grand Total</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($checkoutList as $key => $checkout)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $checkout->name }}</td>
                                    <td>{{ $checkout->contact }}</td>
                                    <td>{{ $checkout->all_total }}/-</td>
                                    <td>{{ $checkout->discount }}/-</td>
                                    <td>{{ $checkout->grand_total }}/-</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" title="view details" href="{{ route('bill_datails',$checkout->id) }}"><i class="fa fa-eye"></i></a>
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
            $('#userrole').DataTable();
        } );
    </script>
@endsection