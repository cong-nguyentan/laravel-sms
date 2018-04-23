@if (session()->has('success_messages'))
    @foreach (session('success_messages') as $message)
        <div class="alert alert-success alert-dismissable notify-block">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ $message }}
        </div>
    @endforeach
@endif

@if (session()->has('warning_messages'))
    @foreach (session('warning_messages') as $message)
        <div class="alert alert-warning alert-dismissable notify-block">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ $message }}
        </div>
    @endforeach
@endif

@if (session()->has('error_messages'))
    @foreach (session('error_messages') as $message)
        <div class="alert alert-danger alert-dismissable notify-block">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ $message }}
        </div>
    @endforeach
@endif

@if (!empty($errors) && $errors->any())
    <div class="alert alert-danger alert-dismissable notify-block">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif