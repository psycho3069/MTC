@extends('admin.master')


@section('content')
    <div class="col-md-8">
        <div class="card text-left">
            <div class="card-header">{{ $v_group->type->name }}</div>
            <div class="card-body">
                <p class="text-danger">{{ $errors->has('voucher.*.amount') ? $errors->first('voucher.*.amount') : '' }}</p>
                <form action="{{ route('vouchers.update', $v_group->id) }}" method="POST">
                    <table class="table table-bordered voucher">
                        <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">
                        <tbody>
                        @foreach( $v_group->vouchers as $voucher )
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td colspan="2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="credit_head_id">Credit Account</label>
                                                <input type="text" class="form-control" name="credit_head_id" value="{{ $voucher->creditAccount->name }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="debit_head_id">Debit Account</label>
                                                <input type="text" class="form-control" name="debit_head_id" value="{{ $voucher->debitAccount->name }}" disabled>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="text" class="form-control" name="voucher[{{ $voucher->id }}][amount]" value="{{ $voucher->amount }}" >
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label for="note">Note</label>
                                        <input type="text" class="form-control" name="voucher[{{ $voucher->id }}][note]" value="{{ $voucher->note }}">
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="form-group">
                        <label for="global_note">Global Note</label>
                        <input type="text" class="form-control" name="global_note" value="{{ $v_group->note }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection


