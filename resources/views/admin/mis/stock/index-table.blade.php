<table class="table table-bordered">
    <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @php( $i = 0)
        @foreach( $misHeadI as $category )
        <tr>
            <td>{{ ++$i }}</td>
            <td class="tree">
                <ul>
                    <li>
                        <span>
                            <i class="fa fa-plus-circle"></i>
                            <b><code>{{ $category->name }}</code></b>
                        </span>

                        <ul>
                            @foreach( $category->ledger as $ledgerHead )
                            <li class="collapse-i">
                                <span>
                                    {{ $ledgerHead->name }} (
                                    {{ $ledgerHead->currentStock ? $ledgerHead->currentStock->sum('quantity_dr') -
                                        $ledgerHead->currentStock->sum('quantity_cr')
                                        .' '.$ledgerHead->unitType->name: 0
                                    }})
                                    <a href="" class="delete" id="{{ $ledgerHead->id }}"
                                       onclick="destroy(this.id, 1); return false;">
                                        <i title="Delete"
                                           class="fa fa-trash-o delete" aria-hidden="true"></i>
                                    </a>
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </td>
            <td>{{ $category->description ? $category->description : 'Not Found'}}</td>

            <td align="right">
                <a href="{{ route('stock.create', ['cat_id' => $category->id, 'mis_head_id' => $category->mis_head_id] ) }}"
                   class="btn btn-sm btn-i" title="Add Item">
                    <i class="fa fa-plus-square" aria-hidden="true"></i>
                </a>
                <a href="{{ route('stock.edit', $category->id) }}" class="btn btn-sm btn-primary" title="Edit">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </a>
                <a href="" class="btn btn-sm btn-danger" data_id="{{ $category->id }}"
                   title="Delete" onclick="destroy( $(this).attr('data_id'), 0); return false;">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>

    {{$misHeadI->links()}}

</table>


<script>
    setTimeout(function () {
        $('.collapse-i').show(2500)
    }, 450)

    $(function () {
        $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');

        $('.tree li.parent_li > span').on('click', function (e) {
            var children = $(this).parent('li.parent_li').find(' > ul > li');
            if (children.is(":visible")) {
                children.hide(500);
                $(this).attr('title', 'Expand this branch').find(' > i').addClass('fa-plus-circle').removeClass('fa-minus-circle');
            } else {
                children.show(500);
                $(this).attr('title', 'Collapse this branch').find(' > i').addClass('fa-minus-circle').removeClass('fa-plus-circle');
            }
            e.stopPropagation();
        });
    });
</script>
