@extends('admin.master')

@section('content')

    <div class="col-md-6">
        <h1> Account Data</h1>

        <div class="offset-md-11">
            <a class="btn btn-light" href="{{ route('balance.index') }}">Opening Balance</a>
        </div>

        <div class="tree">
            <ul>
                @foreach( $heads as $head)
                    <li class="text-left">
                        <span>
                            {!! count( $head->child )>0 ? '<i class="fa fa-minus-square"></i> '.$head->name : $head->name !!}
                        </span>

                        <div class="btn-group">
                            <div class="custom_side_nav">
                                <nav class="custom navbar navbar-expand-sm navbar-dark" style=" width: 65px; padding: 0; margin-bottom: 0px; background: #fff0; min-height: 0px;">
                                    <div class="custom navbar-collapse collapse" id="navbar4">
                                        <ul class="custom navbar-nav nav-fill w-100" style="width: 150px;">
                                            <li class="custom nav-item dropdown dmenu" style="width: 150px;">
                                                <a class="custom nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" style="padding: 4px; width: 65px; border-radius: 5px;">
                                                    Action
                                                </a>
                                                <div class="custom dropdown-menu sm-menu">
                                                    @if( $head->transaction->isEmpty() )
                                                        <a class="dropdown-item" href="{{ route('accounts.create', [ 'head' => $head->id, 'type' => 1 ] ) }}">Add Account Head</a>
                                                    @endif
                                                    @if( $head->child->isEmpty() )
                                                        <a class="dropdown-item" href="{{ route('accounts.create', [ 'head' => $head->id , 'type' => 2 ] ) }}">New Transaction</a>
                                                    @endif
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#">Edit</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
{{--                        <a class="btn btn-sm btn-light add-new" href="{{ route('accounts.create', ['head' => $head->id] ) }}"> add new</a>--}}


                        <ul>
                            @foreach( $head->child as $child_i )
                                <li>
                                    <span>
                                            {!! count( $child_i->child )>0 ? '<i class="fa fa-minus-square"></i> '.$child_i->name : $child_i->name !!}
                                    </span>

                                    <div class="btn-group">
                                        <div class="custom_side_nav">
                                            <nav class="custom navbar navbar-expand-sm navbar-dark" style=" width: 65px; padding: 0; margin-bottom: 0px; background: #fff0; min-height: 0px;">
                                                <div class="custom navbar-collapse collapse" id="navbar4">
                                                    <ul class="custom navbar-nav nav-fill w-100" style="width: 150px;">
                                                        <li class="custom nav-item dropdown dmenu" style="width: 150px;">
                                                            <a class="custom nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" style="padding: 4px; width: 65px; border-radius: 5px;">
                                                                Action
                                                            </a>
                                                            <div class="custom dropdown-menu sm-menu">
                                                                @if( $child_i->transaction->isEmpty() )
                                                                    <a class="dropdown-item" href="{{ route('accounts.create', [ 'head' => $head->id, 'child_i' => $child_i->id, 'type' => 1 ] ) }}">Add Account Head</a>
                                                                @endif
                                                                @if( $child_i->child->isEmpty() )
                                                                    <a class="dropdown-item" href="{{ route('accounts.create', [ 'head' => $head->id, 'child_i' => $child_i->id , 'type' => 2 ] ) }}">New Transaction</a>
                                                                @endif
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="#">Edit</a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </nav>
                                        </div>
                                    </div>
{{--                                    <a class="btn btn-sm btn-light add-new" href="{{ route('accounts.create', ['head' => $head->id, 'child_i' => $child_i->id ] ) }}"> add new</a>--}}

                                    <ul>
                                        @foreach( $child_i->child as $child_ii )
                                            <li>
                                                <span>
                                                    {!! count( $child_ii->child )>0 ? '<i class="fa fa-minus-square"></i> '.$child_ii->name : $child_ii->name !!}
                                                </span>

                                                <div class="btn-group">
                                                    <div class="custom_side_nav">
                                                        <nav class="custom navbar navbar-expand-sm navbar-dark" style=" width: 65px; padding: 0; margin-bottom: 0px; background: #fff0; min-height: 0px;">
                                                            <div class="custom navbar-collapse collapse" id="navbar4">
                                                                <ul class="custom navbar-nav nav-fill w-100" style="width: 150px;">
                                                                    <li class="custom nav-item dropdown dmenu" style="width: 150px;">
                                                                        <a class="custom nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" style="padding: 4px; width: 65px; border-radius: 5px;">
                                                                            Action
                                                                        </a>
                                                                        <div class="custom dropdown-menu sm-menu">
                                                                            @if( $child_ii->transaction->isEmpty() )
                                                                                <a class="dropdown-item" href="{{ route('accounts.create', [ 'head' => $head->id, 'child_i' => $child_i->id, 'child_ii' => $child_ii->id, 'type' => 1 ] ) }}">Add Account Head</a>
                                                                            @endif
                                                                            @if( $child_ii->child->isEmpty() )
                                                                                <a class="dropdown-item" href="{{ route('accounts.create', [ 'head' => $head->id, 'child_i' => $child_i->id, 'child_ii' => $child_ii->id, 'type' => 2 ] ) }}">New Transaction</a>
                                                                            @endif
                                                                            <div class="dropdown-divider"></div>
                                                                            <a class="dropdown-item" href="#">Edit</a>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </nav>
                                                    </div>
                                                </div>
{{--                                                <a class="btn btn-sm btn-light add-new" href="{{ route('accounts.create', ['head' => $head->id, 'child_i' => $child_i->id, 'child_ii' => $child_ii->id] ) }}"> add new</a>--}}

                                                <ul>
                                                    @foreach( $child_ii->child as $child_iii )
                                                        <li>
                                                            <span>
                                                                {!! count( $child_iii->child )>0 ? '<i class="fa fa-minus-square"></i> '.$child_iii->name : $child_iii->name !!}
                                                            </span>

                                                            <div class="btn-group">
                                                                <div class="custom_side_nav">
                                                                    <nav class="custom navbar navbar-expand-sm navbar-dark" style=" width: 65px; padding: 0; margin-bottom: 0px; background: #fff0; min-height: 0px;">
                                                                        <div class="custom navbar-collapse collapse" id="navbar4">
                                                                            <ul class="custom navbar-nav nav-fill w-100" style="width: 150px;">
                                                                                <li class="custom nav-item dropdown dmenu" style="width: 150px;">
                                                                                    <a class="custom nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" style="padding: 4px; width: 65px; border-radius: 5px;">
                                                                                        Action
                                                                                    </a>
                                                                                    <div class="custom dropdown-menu sm-menu">
                                                                                        <a class="dropdown-item" href="{{ route('accounts.create', [ 'head' => $head->id, 'child_i' => $child_i->id, 'child_ii' => $child_ii->id, 'child_iii' => $child_iii->id, 'type' => 2 ] ) }}">New Transaction</a>
                                                                                        <div class="dropdown-divider"></div>
                                                                                        <a class="dropdown-item" href="#">Edit</a>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </nav>
                                                                </div>
                                                            </div>
{{--                                                            <a class="btn btn-sm btn-light add-new" href="{{ route('accounts.create', ['head' => $head->id, 'child_i' => $child_i->id, 'child_ii' => $child_ii->id, 'child_iii' => $child_iii->id] ) }}"> add new</a>--}}

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
                                                                        <span class="row">
                                                                            <i class="fa fa-tag" aria-hidden="true"></i>
                                                                            {{ $transaction->name }} [ {{ $transaction->code }} ]

                                                                             <form method="POST" action="{{ route('accounts.destroy', $transaction->id) }}" style="margin-left: 12px">
                                                                                {{ csrf_field() }}
                                                                                 @method('DELETE')
                                                                                <button type="submit" class="btn btn-sm btn-light">Delete</button>
                                                                            </form>
                                                                        </span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach

                                                    @foreach( $child_ii->transaction as $transaction )
                                                        <li>
                                                            <span class="row">
                                                                <i class="fa fa-tag" aria-hidden="true"></i>
                                                                {{ $transaction->name }} [ {{ $transaction->code }} ]
                                                                <form method="POST" action="{{ route('accounts.destroy', $transaction->id) }}" style="margin-left: 12px">
                                                                    {{ csrf_field() }}
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-light">Delete</button>
                                                                 </form>
                                                            </span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach

                                        @foreach( $child_i->transaction as $transaction )
                                            <li>
                                                <span class="row">
                                                    <i class="fa fa-tag" aria-hidden="true"></i>
                                                    {{ $transaction->name }} [ {{ $transaction->code }} ]
                                                    <form method="POST" action="{{ route('accounts.destroy', $transaction->id) }}" style="margin-left: 12px">
                                                        {{ csrf_field() }}
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-light">Delete</button>
                                                    </form>
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
                                    <form method="POST" action="{{ route('accounts.destroy', $transaction->id) }}">
                                        {{ csrf_field() }}
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light">Delete</button>
                                    </form>
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







