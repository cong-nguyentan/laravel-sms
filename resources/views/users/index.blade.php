@extends ('layouts.backend')

@section('page.title')
{{ __('user.manage_page_title') }}
@endsection

@section('page.top_title')
{{ __('user.manage_page_title') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="portlet box default">
            <div class="portlet-title">
                <div class="caption">
                    <i class="livicon" data-name="pen" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> {{ __('user.manage_table_title') }}
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <td colspan="6">
                                    {!! Form::open(array('route' => 'users.index', 'method' => 'get', 'role' => 'form')) !!}

                                    <div class="form-group">
                                        <div class="col-md-5">
                                            {!! Form::text('search', old('search', ''), array('placeholder' => trans('global.search_suggestion'), 'class' => 'form-control')) !!}
                                        </div>
                                        <div class="col-md-5">
                                            {!! Form::select('role', $listFilterRoles, old('role', ""), array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="col-md-2">
                                            {!! Form::submit(__('global.search'), array('class' => 'btn btn-responsive btn-default')) !!}
                                            {!! Form::button(__('global.reset'), array('class' => 'btn btn-responsive btn-default btn-reset', 'data-reset-link' => route('users.index'))) !!}
                                        </div>
                                    </div>

                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('global.order_number') }}</th>
                                <th>{{ __('user.user_name') }}</th>
                                <th>{{ __('user.user_email') }}</th>
                                <th>{{ __('role.role_name') }}</th>
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
                                <td>{{ $item->email }}</td>
                                <td>@if ($item->super_admin != 1) {{ $item->roles()->first()->name }} @else {{ __('user.super_admin') }} @endif</td>
                                <td class="cell-button">
                                    @if ($currentUser->checkHasPermission('edit user'))
                                    <a href="{{ route('users.edit', ['role' => $item]) }}" class="btn default btn-xs purple">
                                        <i class="livicon" data-name="pen" data-loop="true" data-color="#000" data-hovercolor="black" data-size="14"></i>
                                        {{ __('global.edit') }}
                                    </a>
                                    @endif
                                </td>
                                <td class="cell-button">
                                    @if ($currentUser->checkHasPermission('delete user'))
                                    <a href="{{ route('users.delete', ['role' => $item]) }}" class="btn default btn-xs black">
                                        <i class="livicon" data-name="trash" data-loop="true" data-color="#000" data-hovercolor="black" data-size="14"></i>
                                        {{ __('global.delete') }}
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            @if(!empty($links))
                            <tr>
                                <td colspan="6">{{ $links }}</td>
                            </tr>
                            @endif
                            @if ($currentUser->checkHasPermission('add user'))
                            <tr>
                                <td colspan="6" class="cell-button">
                                    <a href="{{ route('users.create') }}" class="btn btn-responsive btn-default">{{ __('global.add') }}</a>
                                </td>
                            </tr>
                            @endif
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection