<table class="table table-bordered">
    <thead>
    <tr>
        <th></th>
        <th>Name</th>
        <th>Category</th>
        <th>Quantity</th>
    </tr>
    </thead>
    <tbody>
    @foreach( $ledgerHeads as $ledgerHead )
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$ledgerHead->name}}</td>
            <td>{{$ledgerHead->ledgerable->name}}</td>
            <td>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control"
                               name="input[{{$ledgerHead->id}}][amount]"
                               value="{{$ledgerHead->amount}}"
                               min="0">
                    </div>

                    <div class="col-md-6">
                        <select class="form-control" name="input[{{$ledgerHead->id}}][unit_type_id]">
                            @foreach( $units as $unit )
                                <option value="{{$unit->id}}"
                                    {{$ledgerHead->unit_type_id==$unit->id?'selected':''}}>
                                    {{$unit->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{$ledgerHeads->links()}}
