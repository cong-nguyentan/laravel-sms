@extends ('layouts.backend')

@section('page.title')
{{ __('acl.delete_page_title') }}
@endsection

@section('page.top_title')
{{ __('acl.delete_page_title') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="portlet box default">
            <div class="portlet-title">
                <div class="caption">
                    <i class="livicon" data-name="pen" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> {{ __('acl.delete_table_title') }}
                </div>
            </div>
            <div class="portlet-body">
                {!! Form::open(array('route' => array('acl.destroy', $acl), 'method' => 'delete', 'role' => 'form', 'class' => 'form-horizontal delete-confirm-form')) !!}

                <fieldset>
                    <div class="form-group">
                        <div class="col-md-12">{{ __('acl.delete_confirmation') }}</div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('', __('permission.permission_name'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">{{ $acl->permission->name }}</div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('', __('acl.controller_class'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">{{ $acl->controller }}</div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('', __('acl.action_name'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">{{ $acl->action }}</div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            {!! Form::submit(__('global.delete'), array('class' => 'btn btn-responsive btn-default')) !!}
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