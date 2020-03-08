@extends('admin.master')


@section('content')

    <div class="col-md-6 offset-md-3">
        <h1> Account Data</h1>

        @foreach( $heads as $head)
            <div class="row">
                {{ $head->name }} <a class="btn btn-sm btn-light" href="{{ route('accounts.create', ['head' => $head->id] ) }}"> add new</a>
            </div>
        @endforeach

        <div class="btn-group">
            <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Action
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Add New</a>
                <a class="dropdown-item" href="#">Edit</a>
            </div>
        </div>



        <div class="tree ">
            <ul>
                @foreach( $heads as $head)

                    <li>
                        <span>
                            {!! count( $head->child )>0 ? '<i class="fa fa-minus-square"></i> '.$head->name : $head->name !!}
                        </span>
                        <a class="btn btn-sm btn-light add-new" href="{{ route('accounts.create', ['head' => $head->id] ) }}"> add new</a>



                        <ul>
                            <li>
                                @foreach( $head->transaction as $transaction )
                                    <span>
                                        {!! $transaction ? '<i class="fa fa-minus-square"></i> '.$transaction->name : $transaction->name !!}
                                    </span>
                                @endforeach
                            </li>
                        </ul>

                        <ul>
                            @foreach( $head->child as $child_i )
                                <li>
                                    <span>
                                            {!! count( $child_i->child )>0 ? '<i class="fa fa-minus-square"></i> '.$child_i->name : $child_i->name !!}
                                    </span>
                                    <a class="btn btn-sm btn-light add-new" href="{{ route('accounts.create', ['head' => $head->id, 'child_i' => $child_i->id ] ) }}"> add new</a>

                                    <ul>
                                        @foreach( $child_i->child as $child_ii )
                                            <li>
                                                <span>
                                                    {!! count( $child_ii->child )>0 ? '<i class="fa fa-minus-square"></i> '.$child_ii->name : $child_ii->name !!}
                                                </span>
                                                <a class="btn btn-sm btn-light add-new" href="{{ route('accounts.create', ['head' => $head->id, 'child_i' => $child_i->id, 'child_ii' => $child_ii->id] ) }}"> add new</a>

                                                <ul>
                                                    @foreach( $child_ii->child as $child_iii )
                                                        <li>
                                                            <span>
                                                                {!! count( $child_iii->child )>0 ? '<i class="fa fa-minus-square"></i> '.$child_iii->name : $child_iii->name !!}
                                                            </span>
                                                            <a class="btn btn-sm btn-light add-new" href="{{ route('accounts.create', ['head' => $head->id, 'child_i' => $child_i->id, 'child_ii' => $child_ii->id, 'child_iii' => $child_iii->id] ) }}"> add new</a>

                                                            <ul>
                                                                @foreach( $child_iii->child as $child_iv )
                                                                    <li>
                                                                       <span>
                                                                           {{ $child_iv->name }}
                                                                       </span>
                                                                        {{--                                                                       <a class="btn btn-sm btn-light add-new" href="{{ route('accounts.create', ['head' => $head->id, 'child_i' => $child_i->id, 'child_ii' => $child_ii->id, 'child_iii' => $child_iii->id, 'child_iv' => $child_iv->id] ) }}"> add new</a>--}}
                                                                    </li>
                                                                @endforeach
                                                            </ul>

                                                        </li>
                                                    @endforeach
                                                </ul>

                                            </li>
                                        @endforeach
                                    </ul>


                                </li>
                            @endforeach
                        </ul>
                    </li>

                @endforeach


            </ul>
        </div>
    </div>





@endsection


@section('style')
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
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
@endsection







