@extends('admin.master')

@section('content')
    <div class="col-md-8">
        <samp>
            <div class="card text-left">
                <div class="card-header"> <strong>Edit purchase</strong></div>
                <div class="card-body">

                    <form action="{{ route('deliver.update', $delivery->id) }}" method="POST">
                        {{ csrf_field()}}
                        <input type="hidden" name="_method" value="PATCH">

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Stock</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="130">{{ $delivery->ledger->name }}</td>
                                    <td width="100" align="right">
                                        {{$delivery->ledger->stockAvailable().' '.$delivery->ledger->unitType->short_name}}
                                    </td>
                                    <td width="70">
                                        <input type="text" class="form-control text-right"
                                               name="quantity"
                                               value="{{ $delivery->currentStock->quantity_cr * $delivery->unit->multiply_by }}" min="0">
                                    </td>

                                    <td width="100">
                                        <select class="form-control text-center" name="unit_id">
                                            @foreach( $delivery->ledger->unitType->units as $unit )
                                                <option value="{{$unit->id}}"
                                                    {{$delivery->unit_id==$unit->id?'selected':''}}>
                                                    {{$unit->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-success btn-block">Update</button>
                    </form>
                </div>
            </div>
        </samp>
    </div>
@endsection

