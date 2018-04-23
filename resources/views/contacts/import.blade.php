@extends ('layouts.backend')

@section('page.title')
{{ __('contact.import_page_title') }}
@endsection

@section('page.top_title')
{{ __('contact.import_page_title') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="portlet box default">
            <div class="portlet-title">
                <div class="caption">
                    <i class="livicon" data-name="pen" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> {{ __('contact.import_table_title') }}
                </div>
            </div>
            <div class="portlet-body">
                {!! Form::open(array('route' => array('contacts.import'), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal', 'files' => true)) !!}

                <fieldset>
                    <div class="form-group">
                        {!! Form::label('file_import', __('contact.choose_file_import'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::file('file_import', array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            {!! Form::submit(__('contact.import'), array('class' => 'btn btn-responsive btn-default')) !!}
                            <a href="{{ route('contacts.index') }}" class="btn btn-responsive btn-default">{{ __('global.return_to_list') }}</a>
                        </div>
                    </div>
                </fieldset>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection