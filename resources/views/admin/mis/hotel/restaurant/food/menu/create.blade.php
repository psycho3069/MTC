@extends('admin.master')


@section('content')
    <div class="col-md-8">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <b><code>Add New Menu</code></b>
                    <b class="pull-right total">Total: <span id="total"></span></b>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Menu Type</label>
                                <select class="form-control" id="menu_type">

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Item</label>
                                <select class="form-control" id="item">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" class="form-control" id="quantity" min="1" max="100" value="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" id="add-button" class="btn btn-i btn-block">Add</button>
                </div>
            </div>
        </samp>
        <br><br>



        <samp>
            <div class="card text-left">
                <div class="card-body">
                    <form method="POST" action="{{ route('sales.store') }}">
                        {{ csrf_field() }}

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Menu</th>
                                <th scope="col">Menu Type</th>
                                <th scope="col">Item</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody id="list">

                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-dark">Submit</button>
                    </form>

                </div>
            </div>
        </samp>



    </div>


@endsection
