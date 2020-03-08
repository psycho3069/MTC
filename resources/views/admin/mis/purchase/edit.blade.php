@extends('admin.master')

@section('content')
    <div class="col-md-8">
        <samp>
            <div class="card text-left">
                <div class="card-header"> <strong>Edit purchase</strong></div>
                <div class="card-body">

                    <p class="text-danger">{{ $errors->has('input.*.*') ? $errors->first('input.*.*') : '' }}</p>
                    <p class="text-danger">{{ $errors->has('input.*.amount') ? $errors->first('input.*.amount') : '' }}</p>
                    <p class="text-danger">{{ $errors->has('input.*.quantity_dr') ? $errors->first('input.*.quantity_dr') : '' }}</p>


                    <form action="{{ route('purchase.update', $p_group->id) }}" method="POST">
                        {{ csrf_field()}}
                        <input type="hidden" name="_method" value="PATCH">

                        <table class="table table-hover table-info">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Supplier</th>
                                <th>Receiver</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach( $p_group->purchases as $item )
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->ledger->name }}</td>
                                        <td class="col-md-2">
                                            <input type="text" class="form-control text-right" name="input[{{$item->id}}][amount]" value="{{ $item->amount }}" min="0">
                                        </td>
                                        <td class="col-md-2">
                                            <input type="text" class="form-control text-right" name="input[{{$item->id}}][quantity_dr]" value="{{ $item->currentStock->quantity_dr * $item->unit->multiply_by }}" min="0">
                                        </td>

                                        <td class="col-md-2">
                                            <select class="form-control text-center" name="input[{{$item->id}}][unit_id]">
                                                @foreach( $item->ledger->unitType->units as $unit )
                                                    <option value="{{ $unit->id }}" {{ $item->unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td class="col-md-2">
                                            <select class="form-control" name="input[{{$item->id}}][supplier_id]">
                                                @foreach( $data['supplier'] as $supplier )
                                                    <option value="{{ $supplier->id }}" {{ $item->supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="col-md-2">
                                            <select class="form-control" name="input[{{$item->id}}][receiver_id]">
                                                @foreach( $data['receiver'] as $receiver )
                                                    <option value="{{ $receiver->id }}" {{ $item->receiver_id == $receiver->id ? 'selected' : '' }}>{{ $receiver->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="form-group">
                            <label>Note</label>
                            <textarea name="note" class="form-control" cols="3" rows="2">{{ $p_group->note }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Update</button>
                    </form>
                </div>
            </div>
        </samp>
    </div>
@endsection

