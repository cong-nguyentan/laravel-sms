@extends ('layouts.backend')

@section('page.title')
{{ __('role.add_page_title') }}
@endsection

@section('page.top_title')
{{ __('role.add_page_title') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="portlet box default">
            <div class="portlet-title">
                <div class="caption">
                    <i class="livicon" data-name="pen" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> {{ __('role.add_table_title') }}
                </div>
            </div>
            <div class="portlet-body">
                {!! Form::open(array('route' => array('roles.store'), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) !!}

                <fieldset>
                    <div class="form-group">
                        {!! Form::label('name', __('role.role_name'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('name', old('name', ""), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('weight', __('role.role_weight'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('weight', old('weight', ""), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('', __('permission.manage_page_title'), ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            <div class="nestable-lists">
                                @if (!empty($permissions))
                                @php
                                $oldDataPermissions = old('permissions', array());
                                @endphp
                                <div class="dd disable-nestable-lists">
                                    <ol class="dd-list">
                                        @foreach ($permissions as $group)
                                        <li class="dd-item checkbox-group-wrap" data-id="{{ $group['id'] }}">
                                            <div class="dd-handle">
                                                {!! Form::label('permission-' . $group['id'], $group['name'], ['class' => '']) !!}
                                                <input type="hidden" name="permissions[{{ $group['id'] }}]" value="0" />
                                                <input type="checkbox" class="master-checkbox" id="permission-{{ $group['id'] }}" name="permissions[{{ $group['id'] }}]" value="1" @if(!empty($oldDataPermissions[$group['id']])) checked='checked' @endif />
                                            </div>
                                            @if (!empty($group['childs']))
                                            <ol class="dd-list">
                                                @foreach ($group['childs'] as $child)
                                                <li class="dd-item" data-id="{{ $child['id'] }}">
                                                    <div class="dd-handle">
                                                        {!! Form::label('permission-' . $child['id'], $child['name'], ['class' => '']) !!}
                                                        <input type="hidden" name="permissions[{{ $child['id'] }}]" value="0" />
                                                        <input type="checkbox" class="child-checkbox" id="permission-{{ $child['id'] }}" name="permissions[{{ $child['id'] }}]" value="1" @if(!empty($oldDataPermissions[$child['id']])) checked='checked' @endif />
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ol>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ol>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            {!! Form::submit(__('global.add'), array('class' => 'btn btn-responsive btn-default')) !!}
                            <a href="{{ route('roles.index') }}" class="btn btn-responsive btn-default">{{ __('global.return_to_list') }}</a>
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
<script src="{!! asset('js/jquery.nestable.min.js') !!}" type="text/javascript"></script>
@endsection