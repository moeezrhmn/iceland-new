@if (session()->has('custom_flash_notification') || isset($errors) && count($errors) > 0)
    <div class="mainAlertContainer">
        @if (session()->has('custom_flash_notification'))
            @foreach(get_custom_flash('custom_flash_notification') as $flash)
                <div class="alert alert-{{ $flash['level'] }}">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    {!! $flash['message'] !!}
                </div>
            @endforeach
        @endif
        @if (Session::has('success_msg'))
            <div class="alert alert-success">
                <button type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-hidden="true">&times;
                </button>
                {{Session::get('success_msg')}}
            </div>

        @endif

        {{--<div class="alert alert-danger">--}}
        {{--<div class="container">--}}
        {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>--}}
        {{--<div class="container">--}}
        {{--<ul class="errors-list">--}}
        {{--@foreach($errors->all() as $error)--}}
        {{--<li>{!! $error !!}</li>--}}
        {{--@endforeach--}}
        {{--</ul>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        @if(isset($errors) && count($errors) > 0)
            <div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-danger alert-dismissible fade show"
                 role="alert" style="width: 100%">

                <div class="m-alert__text">
                    <strong>
                        Oops!
                    </strong>
                    <div class="container">
                        <ul class="errors-list">
                            @foreach($errors->all() as $error)
                                <li>{!! $error !!}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="m-alert__close" style="padding: 0 0.75rem 0.45rem 0.25rem;vertical-align: middle;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>
@endif

