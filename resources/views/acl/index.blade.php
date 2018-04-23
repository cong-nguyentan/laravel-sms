@extends ('layouts.backend')

@section('page.title')
{{ __('acl.manage_page_title') }}
@endsection

@section('page.top_title')
{{ __('acl.manage_page_title') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="portlet box default">
            <div class="portlet-title">
                <div class="caption">
                    <i class="livicon" data-name="pen" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> {{ __('acl.manage_table_title') }}
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <td colspan="7">
                                    {!! Form::open(array('route' => 'acl.index', 'method' => 'get', 'role' => 'form')) !!}

                                    <div class="form-group">
                                        <div class="col-md-5">
                                            {!! Form::text('search', old('search', ''), array('placeholder' => trans('global.search_suggestion'), 'class' => 'form-control')) !!}
                                        </div>
                                        <div class="col-md-5">
                                            {!! Form::select('show_in_menu', $listFilterShowInMenu, old('show_in_menu', ""), array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="col-md-2">
                                            {!! Form::submit(__('global.search'), array('class' => 'btn btn-responsive btn-default')) !!}
                                            {!! Form::button(__('global.reset'), array('class' => 'btn btn-responsive btn-default btn-reset', 'data-reset-link' => route('acl.index'))) !!}
                                        </div>
                                    </div>

                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('global.order_number') }}</th>
                                <th>{{ __('permission.permission_name') }}</th>
                                <th>{{ __('acl.controller_class') }}</th>
                                <th>{{ __('acl.action_name') }}</th>
                                <th>{{ __('acl.show_in_menu') }}</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        @if (!empty($list))
                        <tbody>
                            @foreach ($list as $item)
                            <tr>
                                <td class="cell-button">{{ $loop->index + 1 + $begin }}</td>
                                <td>{{ $item->permission->name }}</td>
                                <td>{{ $item->controller }}</td>
                                <td>{{ $item->action }}</td>
                                <td class="cell-button">@if($item->show_in_menu == 1) {{ __('global.yes') }} @else {{ __('global.no') }} @endif</td>
                                <td class="cell-button">
                                    <a href="{{ route('acl.edit', ['acl' => $item]) }}" class="btn default btn-xs purple">
                                        <i class="livicon" data-name="pen" data-loop="true" data-color="#000" data-hovercolor="black" data-size="14"></i>
                                        {{ __('global.edit') }}
                                    </a>
                                </td>
                                <td class="cell-button">
                                    <a href="{{ route('acl.delete', ['acl' => $item]) }}" class="btn default btn-xs black">
                                        <i class="livicon" data-name="trash" data-loop="true" data-color="#000" data-hovercolor="black" data-size="14"></i>
                                        {{ __('global.delete') }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            @if(!empty($links))
                            <tr>
                                <td colspan="7">{{ $links }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="7" class="cell-button">
                                    <a href="{{ route('acl.create') }}" class="btn btn-responsive btn-default">{{ __('global.add') }}</a>
                                </td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection