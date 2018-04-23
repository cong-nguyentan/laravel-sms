@extends ('layouts.backend')

@section('page.title')
{{ __('user.profile_page_title') }}
@endsection

@section('page.top_title')
{{ __('user.profile_page_title') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="portlet box default">
            <div class="portlet-title">
                <div class="caption">
                    <i class="livicon" data-name="pen" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> {{ __('user.profile_table_title') }}
                </div>
            </div>
            <div class="portlet-body">
                {!! Form::open(array('route' => array('users.profile'), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) !!}

                <fieldset>
                    <div class="form-group">
                        {!! Form::label('name', __('user.user_name'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('name', old('name', $user->name), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('', __('user.user_email'), ['class' => 'col-md-3 control-label', 'style' => 'padding-top: 0px;']) !!}
                        <div class="col-md-9">{{ $user->email }}</div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', __('user.user_password'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::password('password', array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('password_confirmation', __('user.user_password_again'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            {!! Form::submit(__('global.edit'), array('class' => 'btn btn-responsive btn-default')) !!}
                        </div>
                    </div>
                </fieldset>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection