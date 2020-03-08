@extends('admin.master')


@section('content')
    <div class="col-md-8">
        <samp>
            <div class="card text-left">
                <div class="card-header">
                    Receipt Payment Statement
                </div>
                <div class="card-body">
                    <div class="tree">
                        <ul>
                            @foreach( $heads as $head )
                                <li>
                                    <span>{{ $head->name }}</span>

                                    <ul>
                                        @foreach( $head->child as $child_i )
                                            @if( $local['head_i'][$child_i->id]['debit'] || $local['head_i'][$child_i->id]['credit'])
                                                <li>
                                                    <span class="parent">{{ $child_i->name }}</span>

                                                    <ul>
                                                        @foreach( $child_i->child as $child_ii )
                                                            <li>
                                                                <span class="parent">{{ $child_ii->name }}</span>
                                                            </li>
                                                        @endforeach

                                                        @foreach( $child_i->transaction as $thead )
                                                            <li>
                                                                <i class="fa fa-tag" aria-hidden="true"></i>
                                                                {{ $thead->name }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endif
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
