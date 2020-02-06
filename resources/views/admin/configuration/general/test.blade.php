@extends('admin.master')


@section('content')
    <div class="col-md-6">
        <samp>
            <form method="POST" action="{{ route('update.ledger') }}" >
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header text-left">
                        <b>Ledger Head Configuration</b>
                    </div>


                    <div class="card-body text-left">
                        <code>
                            <div class="tree">

                                <ul>
                                    <li>

                                        <input type="checkbox" id="override" title="Override" >

                                        <span>
                                            <i class="fa fa-minus-square"></i>
                                            {{ $mis_head->id != 5 ? 'Grocery' : 'Inventory' }}
                                        </span>

                                        <select class="ufat col-md-4" name="input[kate][{{ $mis_head->id }}][credit_head_id]">
                                            @foreach( $data['theads'] as $thead )
                                                <option value="{{ $thead->id }}" {{ $mis_head->credit_head_id == $thead->id ? 'selected' : '' }}>{{ $thead->name }} [ {{ $thead->code }} ]</option>
                                            @endforeach
                                        </select>
                                        <select class="ufat col-md-4" name="input[kate][{{ $mis_head->id }}][debit_head_id]">
                                            @foreach( $data['theads'] as $thead )
                                                <option value="{{ $thead->id }}" {{ $mis_head->debit_head_id == $thead->id ? 'selected' : '' }}>{{ $thead->name }} [ {{ $thead->code }} ]</option>
                                            @endforeach
                                        </select>


                                        <ul>
                                            @foreach( $mis_head->child as $mis_cat )
                                                <li class="kate" style="margin-top: 10px;">
                                                    <input type="hidden" name="input[mis_head][{{ $mis_cat->id }}][checked]" value="{{ 0 }}">
                                                    <input type="checkbox" class="checked" name="input[mis_head][{{ $mis_cat->id }}][checked]" value="{{ 1 }}" {{ $mis_cat->checked ? 'checked' : '' }}>
                                                    <span>
                                                        <i class="fa fa-plus-square"></i>
                                                        {{ $mis_cat->name }}
                                                    </span>

                                                    <ul>
                                                        <li class="account" style="margin-top: 15px;">
                                                            <span>
                                                                <i class="fa fa-tag" aria-hidden="true"></i>
                                                                Credit Account
                                                            </span>
                                                            <div class="col-md-6">
                                                                <select class="form-control ufat" name="input[mis_head][{{ $mis_cat->id }}][credit_head_id]">
                                                                    @foreach( $data['theads'] as $thead )
                                                                        <option value="{{ $thead->id }}" {{ $mis_cat->credit_head_id == $thead->id ? 'selected' : '' }}>{{ $thead->name }} [ {{ $thead->code }} ]</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </li>


                                                        <li class="account" style="margin-top: 10px;">
                                                            <span>
                                                                <i class="fa fa-tag" aria-hidden="true"></i>
                                                                Debit Account
                                                            </span>

                                                            <div class="col-md-6">
                                                                <select class="form-control ufat" name="input[mis_head][{{ $mis_cat->id }}][debit_head_id]">
                                                                    @foreach( $data['theads'] as $thead )
                                                                        <option value="{{ $thead->id }}" {{ $mis_cat->debit_head_id == $thead->id ? 'selected' : '' }}>{{ $thead->name }} [ {{ $thead->code }} ]</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>

                                    </li>
                                </ul>
                            </div>
                        </code>

                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </samp>
    </div>
@endsection




@section('script')



    <script>

       $('#override').click(function () {
           $('.checked').not(this).prop('checked', this.checked)

       })


        $(function () {
            $('.account').hide()

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
