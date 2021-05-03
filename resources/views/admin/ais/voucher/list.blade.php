

@extends('admin.master')


@section('content')
    <div class="col-md-12">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <form action="{{ route('vouchers.list') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3">
                                <label>Start Date</label>
                                <input type="date" class="form-control date"
                                       name="start_date" value="{{ $input['start_date'] }}">
                            </div>
                            <div class="col-md-3">
                                <label>End Date</label>
                                <input type="date" class="form-control date"
                                       name="end_date" value="{{ $input['end_date'] }}">
                            </div>
                            <div class="col-md-2">
                                <label>Type</label>
                                <select name="category" class="form-control" id="category">
                                    <option value="0" {{ $input['category'] == 0 ? 'selected' : '' }}>All</option>
                                    <option value="1" {{ $input['category'] == 1 ? 'selected' : '' }}>Auto</option>
                                    <option value="2" {{ $input['category'] == 2 ? 'selected' : '' }}>Manual</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Category</label>
                                <select name="type_id" class="form-control" id="type">
                                    <option value="0">All</option>
                                    @foreach( $voucherTypes as $voucherType )
                                        <option value="{{ $voucherType->id }}"
                                            class={{$voucherType->id>4?'auto':'manual'}}
                                            {{$input['type_id']==$voucherType->id?'selected':''}}>
                                            {{ $voucherType->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-dark btn-sm show-button">Show</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <table class="table table-bordered">
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
                        @foreach( $voucherGroups as $voucherGroup )
                            <tr>
                                <td width="50">{{ $loop->iteration }}</td>
                                <td width="100">{{ $voucherGroup->code }}</td>
                                <td width="100">{{ $voucherGroup->type->name }} Voucher</td>
                                <td width="100">{{ $voucherGroup->vouchers->sum('amount') }}</td>
                                <td width="100">{{ $voucherGroup->note }}</td>
                                <td width="100">{{ $voucherGroup->user->name }}</td>
                                <td width="100">{{ date('d-m-Y', strtotime( $voucherGroup->date->date)) }}</td>

                                <td width="50">
                                    <a href="{{ route('vouchers.show', $voucherGroup->id) }}" class="btn btn-sm btn-i" title="View">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('vouchers.edit', $voucherGroup->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    @if( $voucherGroup->type_id != 10 && $voucherGroup->type_id != 11)
                                        <a href="" class="btn btn-sm btn-danger" data_id="{{ $voucherGroup->id }}" title="Delete" onclick="destroy( $(this).attr('data_id')); return false;">
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
        <br><br><br>


    </div>

@endsection





@section('script')
    <script>
        $(document).ready(function () {
            var y = $('#category').val()
            y == 1 ? $('.manual').hide() : ( y == 2 ? $('.auto').hide() : '')

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
                    $('.auto').show()
                    $('.manual').show()
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

    <!-- datatable -->
    {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
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
