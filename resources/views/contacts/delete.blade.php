@extends ('layouts.backend')

@section('page.title')
{{ __('contact.delete_page_title') }}
@endsection

@section('page.top_title')
{{ __('contact.delete_page_title') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="portlet box default">
            <div class="portlet-title">
                <div class="caption">
                    <i class="livicon" data-name="pen" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> {{ __('contact.delete_table_title') }}
                </div>
            </div>
            <div class="portlet-body">
                {!! Form::open(array('route' => array('contacts.destroy', $contact), 'method' => 'delete', 'role' => 'form', 'class' => 'form-horizontal')) !!}

                <fieldset>
                    <div class="form-group">
                        <div class="col-md-12">{!! __('contact.delete_confirmation', array('contact' => '<b>' . $contact->name . '</b>')) !!}</div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            {!! Form::submit(__('global.delete'), array('class' => 'btn btn-responsive btn-default')) !!}
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