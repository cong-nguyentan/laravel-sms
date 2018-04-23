@extends ('layouts.backend')

@section('page.title')
{{ __('global.authorized_fail') }}
@endsection

@section('page.top_title')
{{ __('global.authorized_fail') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        {{ __('global.authorized_fail') }}
    </div>
</div>
@endsection