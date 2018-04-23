@extends ('layouts.backend')

@section('page.title')
{{ __('permission.manage_page_title') }}
@endsection

@section('page.top_title')
{{ __('permission.manage_page_title') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="portlet box default">
            <div class="portlet-title">
                <div class="caption">
                    <i class="livicon" data-name="pen" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> {{ __('permission.manage_table_title') }}
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <td colspan="4">
                                    {!! Form::open(array('route' => 'permissions.index', 'method' => 'get', 'role' => 'form')) !!}

                                    <div class="form-group">
                                        <div class="col-md-10">
                                            {!! Form::text('search', old('search', ''), array('placeholder' => trans('global.search_suggestion'), 'class' => 'form-control')) !!}
                                        </div>
                                        <div class="col-md-2">
                                            {!! Form::submit(__('global.search'), array('class' => 'btn btn-responsive btn-default')) !!}
                                            {!! Form::button(__('global.reset'), array('class' => 'btn btn-responsive btn-default btn-reset', 'data-reset-link' => route('permissions.index'))) !!}
                                        </div>
                                    </div>

                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('global.order_number') }}</th>
                                <th>{{ __('permission.permission_name') }}</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        @if (!empty($list))
                        <tbody>
                            @foreach ($list as $item)
                            <tr>
                                <td class="cell-button">{{ $loop->index + 1 + $begin }}</td>
                                <td>{{ $item->name }}</td>
                                <td class="cell-button">
                                    <a href="{{ route('permissions.edit', ['permission' => $item]) }}" class="btn default btn-xs purple">
                                        <i class="livicon" data-name="pen" data-loop="true" data-color="#000" data-hovercolor="black" data-size="14"></i>
                                        {{ __('global.edit') }}
                                    </a>
                                </td>
                                <td class="cell-button">
                                    <a href="{{ route('permissions.delete', ['permission' => $item]) }}" class="btn default btn-xs black">
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
                                <td colspan="4">{{ $links }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="4" class="cell-button">
                                    <a href="{{ route('permissions.create') }}" class="btn btn-responsive btn-default">{{ __('global.add') }}</a>
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