

@extends('admin.master')


@section('content')
    <div class="col-md-9">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <form action="{{ route('vouchers.list') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3">
                                <label>Start Date</label>
                                <input type="date" class="form-control date" name="start_date" value="{{ date('Y-m-d') }}" >
                            </div>
                            <div class="col-md-3">
                                <label>End Date</label>
                                <input type="date" class="form-control date" name="end_date"  value="{{ date('Y-m-d') }}">
                            </div>

                            <div class="col-md-2">
                                <label>Type</label>
                                <select name="category" class="form-control" id="category">
                                    <option value="0">All</option>
                                    <option value="1">Auto</option>
                                    <option value="2">Manual</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Category</label>
                                <select name="type_id" class="form-control" id="type">
                                    <option value="0">All</option>
                                    @foreach( $data['types'] as $item )
                                        <option value="{{ $item->id }}" class={!! $item->id >4 ? 'auto' : 'manual' !!} >{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-1" style="margin-top: 2%;">
                                <button class="btn btn-dark btn-sm show-button">Show</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <table class="table table-bordered table-hover table-primary table-fixed">
                        <thead>
                        <tr>
                            <th width="6%"></th>
                            <th>Code</th>
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
                                <td>{{ date('d-m-Y', strtotime($item->date->date)) }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-i" for="btnControl">
                                            Vouchers
                                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                                        </button>
                                        <div class="dropdown-content">
                                            <a href="{{ route('vouchers.show', $item->id) }}">View</a>
                                            <a href="{{ route('vouchers.edit', $item->id) }}">Edit</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
        </samp>


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
            if ( Date.parse(start_date) >  Date.parse(end_date)){
                e.preventDefault()
                alert('Please select a valid date range')
            }
        })
    </script>


@endsection



@section('datatable')
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                "paging": true,
                "ordering":  true,
            });
        } );
    </script>
@endsection
