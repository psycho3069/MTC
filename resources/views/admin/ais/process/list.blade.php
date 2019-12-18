@extends('admin.master')


@section('content')

<style >
    a.dropdown-item {
    color: #fff;
}
</style>
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header">
                <div class="col-md-3">
                    <b>Day End Process</b>
                </div>
                <div class="col-md-6">
                    <span>
                        <form action="{{ route('process.show.list') }}" method="POST">
                            {{ csrf_field() }}
{{--                            <input type="date" class="form-horizontal" name="date">--}}
                             <select name="date_id" class="form-horizontal">
                                 @foreach( $dates as $item )
                                     <option value="{{ $item->id }}" {!! $date->id == $item->id ? 'selected="selected"': '' !!}>{{ $item->date }}</option>
                                 @endforeach
                            </select>
                            <button class="btn btn-dark btn-sm">Show</button>
                        </form>
                    </span>
                </div>
                <form method="POST" action="{{ route('process.store') }}">
                    {{ csrf_field() }}
                    @if( $date->status != 1 )
                        <input type="hidden" name="date_id" value="{{ $date->id }}">
                        <button type="submit" class="btn btn-light float-right">Execute day end</button>
                    @endif
                </form>
            </div>
            <div class="card-body">
                @if( $date)
                    <table class="table table-bordered table-hover table-primary">
                        <thead>
                        <tr>
                            <th scope="col">Type</th>
                            <th scope="col">Code</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Note</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $date->vGroup as $v_group )
                            <tr>
                                <td>{{ $v_group->type->name }}</td>
                                <td>{{ $v_group->code }}</td>
                                <td>{{ $v_group->vouchers->sum('amount') }}</td>
                                <td>{{ str_limit( $v_group->note, 40)  }}</td>
                                <td>{{ $v_group->date->date }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('vouchers.show', $v_group->id) }}">View</a>
                                            <a class="dropdown-item" href="{{ route('vouchers.edit', $v_group->id) }}">Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Delete</a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {!! $v_group->date->status ? '<span class="badge badge-success">Success</span>' : '<span class="badge badge-warning">Pending</span>' !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h3 class="text-center">No Vouchers Found</h3>
                @endif
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
            $('.table').DataTable({
                "paging": true,
                "ordering":  true,
            });
        } );
    </script>

@endsection

