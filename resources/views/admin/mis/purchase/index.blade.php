@extends('admin.master')

@section('content')
    <div class="col-md-8">
        {{ csrf_field() }}
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    {{ $type_id != 5 ? 'Grocerie\'s' : 'Inventorie\'s' }} Purchase List
                    <code>
                        <button type="button" class="btn btn-sm btn-i float-right" onclick='window.location="{{ route('purchase.create', ['mis_head_id' => $type_id]) }}"'>New Purchase</button>
                    </code>
                </div>
{{--                <div class="card-header">--}}
{{--                    <form>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-4">--}}
{{--                                <label>Start Date</label>--}}
{{--                                <input type="date" class="form-control date" name="start_date" value="{{ date('Y-m-d', strtotime(\App\Date::find(1)->date)) }}" >--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4">--}}
{{--                                <label>End Date</label>--}}
{{--                                <input type="date" class="form-control date" name="end_date"  value="{{ date('Y-m-d', strtotime(\App\Configuration::find(1)->software_start_date)) }}">--}}
{{--                            </div>--}}
{{--                            <input type="hidden" name="type_id" value="{{ $type_id }}">--}}
{{--                            <div class="col-md-3">--}}
{{--                                <label>Category</label>--}}
{{--                                <select name="category_id" class="form-control" id="type">--}}
{{--                                    <option value="0">All</option>--}}
{{--                                    @foreach( $mis_ledger_heads as $item )--}}
{{--                                        <option value="{{ $item->id }}" class="" >{{ $item->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}

{{--                            <div class="col-md-1" style="margin-top: 1.5%;">--}}
{{--                                <button class="btn btn-dark btn-sm show-button">Show</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}

                <div class="card-body">
                    <table class="table table-hover table-bordered blue">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th width="30%">Items</th>
                            <th>Total cost</th>
                            <th>Note</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $p_groups as $item )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d-m-Y', strtotime( $item->date->date)) }}</td>
                                <td>
                                    @foreach( $item->purchases as $purchase )
                                        {{ $purchase->ledger->name }},
                                    @endforeach
                                </td>
                                <td>{{ $item->purchases->sum('amount') }} tk.</td>
                                <td>{{ $item->note ? $item->note : 'No notes' }}</td>

                                <td width="18%" align="right">
                                    <a href="{{ route('purchase.show', $item->id) }}" class="btn btn-sm btn-i" title="Add Item">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('purchase.edit', $item->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    <a href="" class="btn btn-sm btn-danger" title="Delete" onclick="destroy({{$item->id}}); return false;">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
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
        var _token = $('input[name="_token"]').val()

        function destroy(id){
            var check = confirm('Are you sure want Delete this?')
            if( check)
                $.ajax({
                    type: 'DELETE',
                    url: '/purchase/'+id,
                    data: {_token: _token},
                    success: function (data) {
                        console.log(data)
                        window.location.reload();
                    }
                })
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

