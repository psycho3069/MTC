@extends('admin.master')


@section('content')
    <div class="col-md-8">
        <samp>
            <form method="POST" action="{{ route('update.ledger') }}" >
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header text-left">
                        <b>Ledger Head Configuration</b>
                    </div>
                    <code>
                        <div class="card-body text-left">
                            <ul>
                                @foreach( $data['mis_head'] as $key => $mis_head )
                                    <li style="margin-top: 20px;">
                                <span>
                                    {{ $mis_head->name }}

                                    <select class="ufat col-md-2" name="input[kate][{{ $mis_head->id }}][credit_head_id]">
                                        @foreach( $data['theads'] as $thead )
                                            <option value="{{ $thead->id }}" >{{ $thead->name }} [ {{ $thead->code }} ]</option>
                                        @endforeach
                                    </select>
                                    <select class="ufat col-md-2" name="input[kate][{{ $mis_head->id }}][debit_head_id]">
                                        @foreach( $data['theads'] as $thead )
                                            <option value="{{ $thead->id }}" >{{ $thead->name }} [ {{ $thead->code }} ]</option>
                                        @endforeach
                                    </select>

                                </span>

                                        <ul>
                                            @foreach( $mis_head->child as $mis_cat )
                                                @if( $mis_cat->ledger->isNotEmpty() )
                                                    <li style="margin-top: 10px;">
                                                    <span>
                                                        {{ $mis_cat->name }}
                                                    </span>
                                                        <ul>
                                                            <li style="margin-top: 10px;">
                                                                Credit Account
                                                                <div class="col-md-4">
                                                                    <select class="form-control ufat" name="input[mis_head][{{ $mis_cat->id }}][credit_head_id]">
                                                                        @foreach( $data['theads'] as $thead )
                                                                            <option value="{{ $thead->id }}" {{ $mis_cat->ledger->first()->credit_head_id == $thead->id ? 'selected' : '' }}>{{ $thead->name }} [ {{ $thead->code }} ]</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </li>
                                                            <li style="margin-top: 10px;">
                                                                Debit Account
                                                                <div class="col-md-4">
                                                                    <select class="form-control ufat" name="input[mis_head][{{ $mis_cat->id }}][debit_head_id]">
                                                                        @foreach( $data['theads'] as $thead )
                                                                            <option value="{{ $thead->id }}" {{ $mis_cat->ledger->first()->debit_head_id == $thead->id ? 'selected' : '' }}>{{ $thead->name }} [ {{ $thead->code }} ]</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>

                                    </li>
                                    <br><br><br><br>
                                @endforeach
                            </ul>
                        </div>
                    </code>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn-primary">Update</button>
                    </div>
                </div>
            </form>
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

    <script>
        $(document).ready(function() {
            $('.ufat').select2({
                placeholder: 'Select an option'
            });
        });
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

@endsection
