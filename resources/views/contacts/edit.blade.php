@extends ('layouts.backend')

@section('page.title')
{{ __('contact.edit_page_title') }}
@endsection

@section('page.top_title')
{{ __('contact.edit_page_title') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="portlet box default">
            <div class="portlet-title">
                <div class="caption">
                    <i class="livicon" data-name="pen" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> {{ __('contact.edit_table_title') }}
                </div>
            </div>
            <div class="portlet-body">
                {!! Form::open(array('route' => array('contacts.update', $contact), 'method' => 'put', 'role' => 'form', 'class' => 'form-horizontal')) !!}

                <fieldset>
                    <div class="form-group">
                        {!! Form::label('name', __('contact.contact_name'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('name', old('name', $contact->name), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('phone', __('contact.contact_phone'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('phone', old('phone', $contact->phone), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('groups', __('group_contact.group_contact_name'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            @php
                            unset($listFilterGroupContacts['']);
                            $contactGroups = $contact->groups()->get()->toArray();
                            $contactGroups = !empty($contactGroups) ? array_map(function($item) {
                                    return $item['id'];
                                }, $contactGroups) : array();
                            @endphp
                            {!! Form::select('groups[]', $listFilterGroupContacts, old('groups', $contactGroups), array('class' => 'form-control', 'multiple' => true, 'id' => 'groups')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            {!! Form::submit(__('global.update'), array('class' => 'btn btn-responsive btn-default')) !!}
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