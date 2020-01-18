@if( session('create'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {!! session('create') !!}
    </div>
@endif

@if( session('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {!! session('success') !!}
    </div>
@endif




@if( session('update'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {!! session('update') !!}
    </div>
@endif

@if( session('delete'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {!! session('delete') !!}
    </div>
@endif
