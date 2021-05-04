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
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Show Entries</label>
                                    <select id="per-page" class="form-control">
                                        <option value="5" {{request('per_page')==5?'selected':''}}>5</option>
                                        <option value="10" {{request('per_page')==10?'selected':''}}>10</option>
                                        <option value="25" {{request('per_page', 25)==25?'selected':''}}>25</option>
                                        <option value="50" {{request('per_page')==50?'selected':''}}>50</option>
                                        <option value="100" {{request('per_page')==100?'selected':''}}>100</option>
                                        <option value="150" {{request('per_page')==150?'selected':''}}>150</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4"></div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Search</label>
                                    <input type="search" id="search"
                                           class="form-control search-input"
                                           placeholder="Search..."
                                           data-route="{{route('table.stock.balance', $misHeadId)}}"
                                           value="{{request('name')}}">
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('stock.balance') }}" method="POST">
                            @csrf

                            <p class="text-danger">{{ $errors->has('input.*.amount') ? $errors->first('input.*.amount') : '' }}</p>
                            <div id="table-content">

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

            getTable();

            $('#search').keyup(function () {
                getTable();
            });

            $('#per-page').on('change', function () {
                getTable();
            });
        });

        function getTable() {
            const search = $('#search');
            const data_route = search.data('route');
            const name = search.val();
            const page = "{{request('page')}}";
            const per_page = $('#per-page').val();


            axios.post(data_route, {
                name: name,
                page: page,
                per_page: per_page,
            }).then((response) => {
                console.log(response.data);
                $('#table-content').html(response.data);
            }, (error) => {
                console.log(error);
            });

        }

    </script>

@endsection

