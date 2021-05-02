@extends('admin.master')

@section('content')
    <div class="col-md-10">
        {{ csrf_field() }}
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <strong>{{ $misHeadId != 4 ? 'Inventory' : 'Grocery' }} List</strong>
                    <a href="{{ route('stock.create', ['mis_head_id' => $misHeadId]) }}" class="btn btn-iii float-right">Add Category </a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Show Entries</label>
                                <select id="per-page" class="form-control">
                                    <option value="1" {{request('per_page')==1?'selected':''}}>1</option>
                                    <option value="2" {{request('per_page')==2?'selected':''}}>2</option>
                                    <option value="3" {{request('per_page')==3?'selected':''}}>3</option>
                                    <option value="4" {{request('per_page')==4?'selected':''}}>4</option>
                                    <option value="5" {{request('per_page')==5?'selected':''}}>5</option>
                                    <option value="10" {{request('per_page')==10?'selected':''}}>10</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-7"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Search</label>
                                <input type="search" id="search"
                                       class="form-control search-input"
                                       placeholder="Search..."
                                       data-route="{{route('table.stock.index', $misHeadId)}}"
                                       value="{{request('name')}}">
                            </div>
                        </div>
                    </div>
                    <div id="table-content">

                    </div>
                </div>
            </div>
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
            const name = search.val();
            const page = "{{request('page')}}";
            const data_route = search.data('route');
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




    <script>
        var _token = $('input[name="_token"]').val()
        function destroy( id, type) {
            var check = confirm('Are you sure want Delete this?')
            // console.log( id+' ->'+ type)
            if( check){
                $.ajax({
                    type: 'DELETE',
                    url: "stock/"+id,
                    data: {_token: _token, id: id, type: type},
                    success:function (data) {
                        window.location.reload();
                    }

                })

            }

        }

    </script>
@endsection


