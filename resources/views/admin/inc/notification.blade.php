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
    <div class="alert alert-primary alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <span style="color: darkblue;">{!! session('update') !!}</span>
    </div>
@endif

@if( session('delete'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {!! session('delete') !!}
    </div>
@endif

@if( session('failed'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {!! session('failed') !!}
    </div>
@endif

@if( session('danger'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {!! session('danger') !!}
    </div>
@endif


@if( session('warning'))
    <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {!! session('warning') !!}
    </div>
@endif

@if( session('errors'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {!! session('errors') !!}
    </div>
@endif

@if( session('error'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {!! session('error') !!}
    </div>
@endif
