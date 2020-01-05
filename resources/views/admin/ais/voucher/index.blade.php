

@extends('admin.master')


@section('content')
<style>
    a.dropdown-item {
        color: #fff;
    }
</style>
    <div class="col-md-7">

        <form action="{{ route('vouchers.list') }}" method="POST">
            {{ csrf_field() }}
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Start Date</label>
                            <div>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>End Date</label>
                            <div>
                                <input type="date" name="end_date" value="{{ date('Y-m-d') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Type</label>
                            <select name="category" class="form-control" id="category">
                                <option value="0">All</option>
                                <option value="1">Auto</option>
                                <option value="2">Manual</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Category</label>
                            <select name="type_id" class="form-control" id="type">
                                <option value="0">All</option>
                                @foreach( $data['types'] as $item )
                                    <option value="{{ $item->id }}" class={!! $item->id >4 ? 'auto' : 'manual' !!} >{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-md-2" style="margin-top: 15px;">
                    <button class="btn btn-dark btn-sm show-button">Show</button>
                </div>
                </div>
            </div>

        </form>
        <br><br><br>
        <table class="table table-bordered table-hover table-info">
            <thead>
            <tr>
                <th></th>
                <th class="">Code</th>
                <th class="">Type</th>
                <th class="">Amount</th>
                <th class="">Narration/Cheque Details</th>
                <th class="">Entry By</th>
                <th class="">Date</th>
                <th class="">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $data['v_group'] as $item )
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->type_id == 8 || $item->type_id == 9 ? 'Auto Payment Voucher' : ( $item->type_id >= 5 ? 'Auto Receipt Voucher' : $item->type->name) }}</td>
                    <td>{{ $item->vouchers->sum('amount') }}</td>
                    <td>{{ str_limit($item->note, 18) }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->date->date }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('vouchers.show', $item->id) }}">View</a>
                                <a class="dropdown-item" href="{{ route('vouchers.edit', $item->id) }}">Edit</a>
                                <div class="dropdown-divider"></div>
{{--                                <a class="dropdown-item" href="#">Delete</a>--}}
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

@endsection

@section('script')
    <script>
        $('#category').on('change',function () {
            var x = $(this).val()
            if (x == 1) {
                $('.auto').show()
                $('#type').val(0)
                $('.manual').hide()
            } else if ( x == 2){
                $('.manual').show()
                $('#type').val(0)
                $('.auto').hide()
            }else{
                $('#type').val(0)
                $('.auto').hide()
                $('.manual').hide()
            }

        })
        $('.show-button').click(function (e) {
            var end_date = $('input[name="end_date"]').val()
            var start_date = $('input[name="start_date"]').val()
            // alert(start_date)
            if (  !Date.parse(start_date)){
                e.preventDefault()
                alert('Please select a date')
            }
            if ( Date.parse(start_date) > Date.parse(end_date)){
                e.preventDefault()
                alert('Please select a valid date range')
            }
        })
    </script>
@endsection



@section('datatable')

    <!-- datatable -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                "paging": true,
                "ordering":  true,
            });
        } );
    </script>

@endsection
