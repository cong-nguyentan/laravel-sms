@extends ('layouts.backend')

@section('page.title')
{{ __('acl.add_page_title') }}
@endsection

@section('page.top_title')
{{ __('acl.add_page_title') }}
@endsection

@section('styles')
<link href="{!! asset('themes/josh/backend/vendors/iCheck/css/all.css') !!}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="portlet box default">
            <div class="portlet-title">
                <div class="caption">
                    <i class="livicon" data-name="pen" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> {{ __('acl.add_table_title') }}
                </div>
            </div>
            <div class="portlet-body">
                {!! Form::open(array('route' => array('acl.store'), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) !!}

                <fieldset>
                    <div class="form-group">
                        {!! Form::label('permission_id', __('permission.permission_name'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::select('permission_id', $permissions, old('permission_id', ""), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('controller', __('acl.controller_class'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('controller', old('controller', ""), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('action', __('acl.action_name'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('action', old('action', ""), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('show_in_menu', __('acl.show_in_menu'), ['class' => 'col-md-3 control-label', 'style' => 'padding-top: 0px;']) !!}
                        <div class="col-md-9">
                            <input type="hidden" name="show_in_menu" value="0" />
                            <input type="checkbox" id="show_in_menu" name="show_in_menu" class="custom-checkbox" value="1" @if(old('show_in_menu', 0)) checked='checked' @endif />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            {!! Form::submit(__('global.add'), array('class' => 'btn btn-responsive btn-default')) !!}
                            <a href="{{ route('acl.index') }}" class="btn btn-responsive btn-default">{{ __('global.return_to_list') }}</a>
                        </div>
                    </div>
                </fieldset>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{!! asset('themes/josh/backend/vendors/iCheck/js/icheck.js') !!}" type="text/javascript"></script>
@endsection