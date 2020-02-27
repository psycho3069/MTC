

@extends('admin.master')


@section('content')
    <div class="col-md-10">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <form action="{{ route('vouchers.list') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3">
                                <label>Start Date</label>
                                <input type="date" class="form-control date" name="start_date" value="{{ date('Y-m-d', strtotime(\App\Configuration::find(1)->software_start_date)) }}" >
                            </div>
                            <div class="col-md-3">
                                <label>End Date</label>
                                <input type="date" class="form-control date" name="end_date"  value="{{ date('Y-m-d', strtotime(\App\Configuration::find(1)->software_start_date)) }}">
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
                                        <option value="{{ $item->id }}" class={{ $item->id >4 ? 'auto' : 'manual' }} >{{ $item->name }}</option>
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
                    <table class="table table-bordered table-hover table-fixed">
                        <thead>
                        <tr>
                            <th width="6%"></th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Narration</th>
                            <th>Entry By</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $data['v_group'] as $item )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->type->name }} voucher</td>
                                <td>{{ $item->vouchers->sum('amount') }}</td>
                                <td>{{ str_limit($item->note, 18) }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ date('d-m-Y', strtotime($item->date->date)) }}</td>

                                <td width="18%" align="">
                                    <a href="{{ route('vouchers.show', $item->id) }}" class="btn btn-sm btn-i" title="View">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('vouchers.edit', $item->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    @if( $item->type_id != 10 && $item->type_id != 11)
                                        <a href="" class="btn btn-sm btn-danger" data_id="{{ $item->id }}" title="Delete" onclick="destroy( $(this).attr('data_id')); return false;">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    @endif
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




    <script>
        var _token = $('input[name="_token"]').val()

        function destroy(id) {
            var check = confirm('Are you sure want Delete this?')


            if( check){
                $.ajax({
                    type: 'DELETE',
                    url: '/vouchers/'+id,
                    data:{ _token: _token },
                    success:function (data) {
                        // console.log( data)
                        window.location.href = "{{ route('vouchers.index') }}";
                    }
                })
            }


        }
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
