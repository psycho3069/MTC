@extends('admin.master')


@section('content')
    <div class="col-md-6 offset-md-3">


        <div class="tree ">
            <ul>
                @foreach( $heads as $head)
                    <li>
                        <span>
                            {!! count( $head->child )>0 ? '<i class="fa fa-minus-square"></i> '.$head->name : $head->name !!}
                        </span>
                        <ul>
                            @foreach( $head->child as $child_i )
                                <li>
                                    <span>
                                            {!! count( $child_i->child )>0 ? '<i class="fa fa-minus-square"></i> '.$child_i->name : $child_i->name !!}
                                    </span>
                                    <ul>
                                        @foreach( $child_i->child as $child_ii )
                                            <li>
                                                <span>
                                                    {!! count( $child_ii->child )>0 ? '<i class="fa fa-minus-square"></i> '.$child_ii->name : $child_ii->name !!}
                                                </span>

                                                <ul>
                                                    @foreach( $child_ii->child as $child_iii )
                                                        <li>
                                                            <span>
                                                                {!! count( $child_iii->child )>0 ? '<i class="fa fa-minus-square"></i> '.$child_iii->name : $child_iii->name !!}
                                                            </span>


                                                            <ul>
                                                                @foreach( $child_iii->child as $child_iv )
                                                                    <li>
                                                                       <span>
                                                                           {{ $child_iv->name }}
                                                                       </span>
                                                                        {{--                                                                       <a class="btn btn-sm btn-light add-new" href="{{ route('accounts.create', ['head' => $head->id, 'child_i' => $child_i->id, 'child_ii' => $child_ii->id, 'child_iii' => $child_iii->id, 'child_iv' => $child_iv->id] ) }}"> add new</a>--}}
                                                                    </li>
                                                                @endforeach

                                                                @foreach( $child_iii->transaction as $transaction )
                                                                    <li>
                                                                        <span>
                                                                            <i class="fa fa-tag" aria-hidden="true"></i>
                                                                            {{ $transaction->name }} [ {{ $transaction->code }} ]
                                                                        </span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach

                                                    @foreach( $child_ii->transaction as $transaction )
                                                        <li>
                                                            <span>
                                                                <i class="fa fa-tag" aria-hidden="true"></i>
                                                                {{ $transaction->name }} [ {{ $transaction->code }} ]
                                                            </span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach

                                        @foreach( $child_i->transaction as $transaction )
                                            <li>
                                                <span>
                                                    <i class="fa fa-tag" aria-hidden="true"></i>
                                                    {{ $transaction->name }} [ {{ $transaction->code }} ]
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>

                                </li>
                            @endforeach
                            @foreach( $head->transaction as $transaction )
                                <li>
                                    <span>
                                        <i class="fa fa-tag" aria-hidden="true"></i>
                                        {{ $transaction->name }} [ {{ $transaction->code }} ]
                                    </span>

                                </li>
                            @endforeach
                        </ul>
                    </li>

                @endforeach

            </ul>
        </div>
        <table data-toggle="table">
            <thead>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Item Price</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>Item 1</td>
                <td>$1</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Item 2</td>
                <td>$2</td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection


@section('header_styles')
    {{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css">
@endsection

@section('script')
    <script>
        $(function () {
            $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
            $('.tree li.parent_li > span').on('click', function (e) {
                var children = $(this).parent('li.parent_li').find(' > ul > li');
                if (children.is(":visible")) {
                    children.hide('fast');
                    $(this).attr('title', 'Expand this branch').find(' > i').addClass('fa-plus-square').removeClass('fa-minus-square');
                } else {
                    children.show('fast');
                    $(this).attr('title', 'Collapse this branch').find(' > i').addClass('fa-minus-square').removeClass('fa-plus-square');
                }
                e.stopPropagation();
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>
@endsection
