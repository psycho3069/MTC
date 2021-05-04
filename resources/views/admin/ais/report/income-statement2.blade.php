@extends('admin.master')


@section('reports')
    <section>
        <h2 class="section-heading font-smoothen">Custom Icons</h2>
        <p class="description">Custom Expand / Collapse Icons</p>

        <ul id="iconTree" class="treeview">

            <li>Item 1
                <ul>
                    <li>Sub Item 1</li>
                    <li>Sub Item 2</li>
                    <li>Sub Item 3
                        <ul>
                            <li>Sub Item 1</li>
                            <li>Sub Item 2</li>
                            <li>Sub Item 3
                                <ul>
                                    <li>Sub Item 1</li>
                                    <li>Sub Item 2</li>
                                    <li>Sub Item 3</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul></li>
            <li>Item 3 <ul>
                    <li>Sub Item 1</li>
                    <li>Sub Item 2</li>
                </ul></li>
            <li>Item 4</li>
            <li>Item 5</li>
        </ul>
    </section>

    <div class="page">
    </div>

@endsection


@section('style')
{{--    <link rel="stylesheet" href="{{asset('treeview/css/styles.css')}}">--}}
    <link rel="stylesheet" href="{{asset('treeview/css/jquery.treeView.css')}}">
    <link rel="stylesheet" href="{{asset('treeview/css/prism.css')}}">
    <link rel="stylesheet" href="{{asset('treeview/css/jquery.treeView.custom.css')}}">

    <style>
        #iconTree li.contains-items {
            background-image: url('{{asset("treeview/css/icons/expand.png")}}');
        }

        #iconTree li.items-expanded {
            background-image: url('{{asset("treeview/css/icons/collapse.png")}}');
        }
    </style>
@endsection


@section('script')
    <script src="{{asset('treeview/js/jquery.treeView.js')}}"></script>
    <script src="{{asset('treeview/js/prism.js')}}"></script>
    <script src="{{asset('treeview/js/script.js')}}"></script>
@endsection
