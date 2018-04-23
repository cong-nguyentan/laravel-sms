@extends ('layouts.backend')

@section('page.title')
{{ __('global.maintenance_mode') }}
@endsection

@section('page.top_title')
{{ __('global.maintenance_mode') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        {{ __('global.maintenance_mode') }}
    </div>
</div>
@endsection