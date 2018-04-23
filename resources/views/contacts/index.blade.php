@extends ('layouts.backend')

@section('page.title')
{{ __('contact.manage_page_title') }}
@endsection

@section('page.top_title')
{{ __('contact.manage_page_title') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="portlet box default">
            <div class="portlet-title">
                <div class="caption">
                    <i class="livicon" data-name="pen" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> {{ __('contact.manage_table_title') }}
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <td colspan="7">
                                    {!! Form::open(array('route' => 'contacts.index', 'method' => 'get', 'role' => 'form')) !!}

                                    <div class="form-group">
                                        <div class="col-md-5">
                                            {!! Form::text('search', old('search', ''), array('placeholder' => trans('global.search_suggestion'), 'class' => 'form-control')) !!}
                                        </div>
                                        <div class="col-md-5">
                                            {!! Form::select('group', $listFilterGroupContacts, old('group', ""), array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="col-md-2">
                                            {!! Form::submit(__('global.search'), array('class' => 'btn btn-responsive btn-default')) !!}
                                            {!! Form::button(__('global.reset'), array('class' => 'btn btn-responsive btn-default btn-reset', 'data-reset-link' => route('contacts.index'))) !!}
                                        </div>
                                    </div>

                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('global.order_number') }}</th>
                                <th>{{ __('contact.contact_name') }}</th>
                                <th>{{ __('contact.contact_phone') }}</th>
                                <th>{{ __('contact.contact_creator') }}</th>
                                <th>{{ __('group_contact.group_contact_name') }}</th>
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
                                <td class="cell-button">{{ $item->phone }}</td>
                                <td>{{ $item->creator->email }}</td>
                                @php
                                $groupContacts = $item->groups()->orderby('name')->get()->toArray();
                                $groupContacts = !empty($groupContacts) ? array_map(function($item) {
                                    return $item['name'];
                                }, $groupContacts) : array();
                                $groupContacts = implode(", ", $groupContacts);
                                @endphp
                                <td>{{ $groupContacts }}</td>
                                <td class="cell-button">
                                    @if ($currentUser->checkHasPermission('edit contact'))
                                    <a href="{{ route('contacts.edit', ['contact' => $item]) }}" class="btn default btn-xs purple">
                                        <i class="livicon" data-name="pen" data-loop="true" data-color="#000" data-hovercolor="black" data-size="14"></i>
                                        {{ __('global.edit') }}
                                    </a>
                                    @endif
                                </td>
                                <td class="cell-button">
                                    @if ($currentUser->checkHasPermission('delete contact'))
                                    <a href="{{ route('contacts.delete', ['contact' => $item]) }}" class="btn default btn-xs black">
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
                                <td colspan="7">{{ $links }}</td>
                            </tr>
                            @endif
                            @if ($currentUser->checkHasPermission('add contact'))
                            <tr>
                                <td colspan="7" class="cell-button">
                                    <a href="{{ route('contacts.create') }}" class="btn btn-responsive btn-default">{{ __('global.add') }}</a>
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