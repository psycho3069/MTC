

@extends('admin.master')


@section('content')
    @if( isset($status))
        <div class="offset-md-5">
            <h4>Nothing found</h4>
        </div>
    @else
        <div class="col-md-10">
            <samp>
                <div class="card text-left">
                    <div class="card-header">
                        <form action="{{ route('report.show.daily') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="date" name="start_date" class="form-control" value="{{ isset($input) ? $input['start_date'] : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="date" name="end_date" value="{{ isset($input) ? $input['end_date'] : date('Y-m-d') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select name="category" class="form-control" id="category">
                                            <option value="0">All</option>
                                            <option value="1">Auto</option>
                                            <option value="2">Manual</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="type_id" class="form-control" id="type">
                                            <option value="0">All</option>
                                            @foreach( $data['types'] as $item )
                                                <option value="{{ $item->id }}" class={!! $item->id >4 ? 'auto' : 'manual' !!} >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2" style="margin-top: 4%">
                                    <button class="btn btn-dark btn-sm">Show</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <table class="table table-bordered table-hover table-primary table-fixed">
                            <thead>
                            <tr>
                                <th></th>
                                <th class="">Date</th>
                                <th class="">Code</th>
                                <th class="">Account head</th>
                                <th class="">Narration/Cheque Details</th>
                                <th class="">Type</th>
                                <th class="">Debit Amount</th>
                                <th class="">Credit Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php( $i =0)
                            @foreach( $record as $x => $v_group )
                                @foreach( $v_group as $key => $item )
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ date('d-m-Y', strtotime( $info[$x]['date'])) }}</td>
                                        <td>{{ $info[$x]['code'] }}</td>
                                        <td>{{ $record[$x][$key]['thead'] }}</td>
                                        <td>{{ $info[$x]['note'] }}</td>
                                        <td>{{ $info[$x]['type'] }}</td>
                                        <td>{{ $record[$x][$key]['debit'] }}</td>
                                        <td>{{ $record[$x][$key]['credit'] }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </samp>
        </div>

    @endif

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
            } else {
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
