@extends('admin.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"> <big> <strong>ADD NEW INVENTORY </strong> </big> </div>

                    <div class="card-body">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">BACK</a>
                    </div>

                <!--form-->
                    <form class="" action="{{ route('mis.inventory.store') }}" method="POST" enctype="multipart/form-data" style="padding: 0 30px 0 30px;">
                        {{ csrf_field() }}
                        @if( isset($stock_head_id))
                            <input type="hidden" name="stock_head_id" value="{{ $stock_head_id }}">
                        @endif

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-left">Name:</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-left">Description:</label>
                            <div class="col-md-6">
                                <textarea type="text" class="form-control" id="description" name="description"></textarea>
                            </div>
                        </div>


                        <!-- Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" >ADD</button>
                            <button type="reset" class="btn btn-danger" >RESET</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
