@extends ('layouts.backend')

@section('page.title')
{{ __('acl.design_menu_page_title') }}
@endsection

@section('page.top_title')
{{ __('acl.design_menu_page_title') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="portlet box default">
            <div class="portlet-title">
                <div class="caption">
                    <i class="livicon" data-name="pen" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> {{ __('acl.design_menu_table_title') }}
                </div>
            </div>
            <div class="portlet-body">
                {!! Form::open(array('route' => array('acl.store_designed_menu'), 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) !!}

                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="nestable-lists">
                            @if (!empty($menus))
                            <div class="dd">
                                <ol class="dd-list">
                                    @foreach ($menus as $menu)
                                    <li class="dd-item" data-id="{{ $menu['id'] }}">
                                        <div class="dd-handle">{{ $menu['name'] }}</div>
                                        @if (!empty($menu['childs']))
                                        <ol class="dd-list">
                                            @foreach ($menu['childs'] as $child)
                                            <li class="dd-item" data-id="{{ $child['id'] }}"><div class="dd-handle">{{ $child['name'] }}</div></li>
                                            @endforeach
                                        </ol>
                                        @endif
                                    </li>
                                    @endforeach
                                </ol>
                            </div>
                            @endif
                            <input type="hidden" class="nestable-output" value="" name="nestable-output" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        {!! Form::submit(__('global.save'), array('class' => 'btn btn-responsive btn-default')) !!}
                        <a href="{{ route('acl.index') }}" class="btn btn-responsive btn-default">{{ __('global.return_to_list') }}</a>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{!! asset('js/jquery.nestable.min.js') !!}" type="text/javascript"></script>
@endsection