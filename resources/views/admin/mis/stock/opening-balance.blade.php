@extends('admin.master')

@section('content')
    <div class="col-md-8">
        <samp>
            @if($total)
                <div class="card text-left">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <strong>{{ $misHeadId == 5 ? 'Inventories' : 'Groceries' }}
                                    Opening Balance
                                </strong>
                            </div>

                            <div class="offset-md-4 float-right mb-2">
                                <input type="search" id="search"
                                       class="form-control search-input"
                                       placeholder="Search..."
                                       data-route="{{route('table.stock.balance', $misHeadId)}}"
                                       value="{{request('name')}}">
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="text-danger">{{ $errors->has('input.*.amount') ? $errors->first('input.*.amount') : '' }}</p>

                        <form action="{{ route('stock.balance') }}" method="POST">
                            {{ csrf_field()}}

                            <div id="stock-table">

                            </div>

                            <button type="submit" class="btn btn-success mt-3">Save</button>
                        </form>
                    </div>
                </div>

            @else
                <H4>Please add some Item first</H4>
            @endif
        </samp>
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function () {

            getStocks();

            $('#search').keyup(function () {
                getStocks();
            });
        });

        function getStocks() {
            const search = $('#search');
            const data_route = search.data('route');
            const name = search.val();
            const page = "{{request('page')}}";

            axios.post(data_route, {
                name: name,
                page: page,
            }).then((response) => {
                console.log(response.data);
                $('#stock-table').html(response.data);
            }, (error) => {
                console.log(error);
            });

        }

    </script>

@endsection

