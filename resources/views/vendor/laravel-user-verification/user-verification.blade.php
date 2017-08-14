@extends('layouts.email')

<!-- Main Content -->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! trans('laravel-user-verification::user-verification.verification_error_header') !!}
                </div>
                <div class="panel-body">
                    <span class="help-block">
                        <strong>
                            {!! trans('laravel-user-verification::user-verification.verification_error_message') !!}
                        </strong>
                    </span>
                    <div class="form-group">
                        <div class="col-md-12">
                            <a href="{{url('/')}}" class="btn btn-primary">
                                {!! trans('laravel-user-verification::user-verification.verification_error_back_button') !!}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{--@component('layouts.email')--}}

{{--@slot('title')--}}
{{--Email Activation--}}
{{--@endslot--}}

{{--@slot('content')--}}
{{--<p>Hi there, {{ $user->first_name }}</p>--}}
{{--<p>Please activate Your Account by clicking the button.</p>--}}
{{--<table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">--}}
    {{--<tbody>--}}
    {{--<tr>--}}
        {{--<td align="left">--}}
            {{--<table border="0" cellpadding="0" cellspacing="0">--}}
                {{--<tbody>--}}
                {{--<tr>--}}
                    {{--<td> <a href="{{ route('activate', ['email'=>$user->email, 'code'=>$code]) }}" target="_blank">Activate Your Email</a> </td>--}}
                {{--</tr>--}}
                {{--</tbody>--}}
            {{--</table>--}}
        {{--</td>--}}
    {{--</tr>--}}
    {{--</tbody>--}}
{{--</table>--}}
{{--<p>Please Ignore if you haven't register with IncrIdea or already activated your account!</p>--}}
{{--<p>Good luck!</p>--}}
{{--@endslot--}}

{{--@endcomponent--}}