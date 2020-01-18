@extends('admin.master')

@section('content')

    <div class="col-md-8">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    <b>Account Data</b>
                </div>
                <div class="card-body">
                    <a class="btn btn-light pull-right" href="{{ route('balance.index') }}">Opening Balance</a>

                    <div class="tree">
                        <ul>
                            @foreach( $heads as $head)
                                <li class="text-left">
                                    <span>
                                        {!! count( $head->child )>0 ? '<i class="fa fa-minus-square"></i> '.$head->name : $head->name !!}
                                    </span>

                                    <div class="dropdown">
                                        <button class="btn btn-i" for="btnControl">
                                            More
                                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                                        </button>
                                        <div class="dropdown-content no-wrap">
                                            @if( $head->transaction->isEmpty() )
                                                <a href="{{ route('accounts.create', [ 'head' => $head->id, 'type' => 1 ] ) }}">Add Account Head</a>
                                            @endif
                                            @if( $head->child->isEmpty() )
                                                <a href="{{ route('accounts.create', [ 'head' => $head->id , 'type' => 2 ] ) }}">New Transaction</a>
                                            @endif
                                            <a href="">Edit</a>
                                        </div>
                                    </div>

                                    <ul>
                                        @foreach( $head->child as $child_i )
                                            <li>
                                                <span>
                                                    {!! count( $child_i->child )>0 ? '<i class="fa fa-minus-square"></i> '.$child_i->name : $child_i->name !!}
                                                </span>

                                                <div class="dropdown">
                                                    <button class="btn btn-i" for="btnControl">
                                                        More
                                                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                                                    </button>

                                                    <div class="dropdown-content no-wrap">
                                                        @if( $child_i->transaction->isEmpty() )
                                                            <a href="{{ route('accounts.create', [ 'head' => $head->id, 'child_i' => $child_i->id, 'type' => 1 ] ) }}">Add Account Head</a>
                                                        @endif
                                                        @if( $child_i->child->isEmpty() )
                                                            <a href="{{ route('accounts.create', [ 'head' => $head->id, 'child_i' => $child_i->id , 'type' => 2 ] ) }}">New Transaction</a>
                                                        @endif
                                                        <a href="">Edit</a>
                                                    </div>
                                                </div>

                                                <ul>
                                                    @foreach( $child_i->child as $child_ii )
                                                        <li>
                                                            <span>
                                                                {!! count( $child_ii->child )>0 ? '<i class="fa fa-minus-square"></i> '.$child_ii->name : $child_ii->name !!}
                                                            </span>

                                                            <div class="dropdown">
                                                                <button class="btn btn-i" for="btnControl">
                                                                    More
                                                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                                                </button>
                                                                <div class="dropdown-content no-wrap">
                                                                    @if( $child_ii->transaction->isEmpty() )
                                                                        <a href="{{ route('accounts.create', [ 'head' => $head->id, 'child_i' => $child_i->id, 'child_ii' => $child_ii->id, 'type' => 1 ] ) }}">Add Account Head</a>
                                                                    @endif
                                                                    @if( $child_ii->child->isEmpty() )
                                                                        <a href="{{ route('accounts.create', [ 'head' => $head->id, 'child_i' => $child_i->id, 'child_ii' => $child_ii->id, 'type' => 2 ] ) }}">New Transaction</a>
                                                                    @endif
                                                                    <a href="">Edit</a>
                                                                </div>
                                                            </div>

                                                            <ul>
                                                                @foreach( $child_ii->child as $child_iii )
                                                                    <li>
                                                                        <span>
                                                                            {!! count( $child_iii->child )>0 ? '<i class="fa fa-minus-square"></i> '.$child_iii->name : $child_iii->name !!}
                                                                        </span>

                                                                        <div class="dropdown">
                                                                            <button class="btn btn-i" for="btnControl">
                                                                                More
                                                                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                                                                            </button>
                                                                            <div class="dropdown-content no-wrap">
                                                                                <a href="{{ route('accounts.create', [ 'head' => $head->id, 'child_i' => $child_i->id, 'child_ii' => $child_ii->id, 'child_iii' => $child_iii->id, 'type' => 2 ] ) }}">New Transaction</a>
                                                                                <a href="">Edit</a>
                                                                            </div>
                                                                        </div>

                                                                        <ul>
                                                                            @foreach( $child_iii->child as $child_iv )
                                                                                <li>
                                                                                   <span>
                                                                                       {{ $child_iv->name }}
                                                                                   </span>
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
            </div>
        </samp>
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







