@extends('frontend.layouts.default')

@section('title')
Account Signin  :: Email required for completing registration
@stop

@section('content')

@unless(empty($twitter))
<div class="alert alert-info alert-block">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>Important !!</h4>
    We need your email address to fill complete the process
</div>
@endunless
<div class="page-header">
    <h3>Signin with twitter</h3>
</div>
<div class="row">
    <form method="post" action="{{ route('twitter-email') }}" class="form-horizontal" autocomplete="off">
        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        <!-- Email -->
        <div class="control-group{{ $errors->first('email', ' error') }}">
            <label class="control-label" for="email">Email</label>
            <div class="controls">
                <input type="text" name="email" id="email" value="{{ Input::old('email') }}" />
                {{ $errors->first('email', '<span class="help-block">:message</span>') }}
            </div>
        </div>

        <!-- Email Confirm -->
        <div class="control-group{{ $errors->first('email_confirm', ' error') }}">
            <label class="control-label" for="email_confirm">Confirm Email</label>
            <div class="controls">
                <input type="text" name="email_confirm" id="email_confirm" value="{{ Input::old('email_confirm') }}" />
                {{ $errors->first('email_confirm', '<span class="help-block">:message</span>') }}
            </div>
        </div>

        <hr>

        <!-- Form actions -->
        <div class="control-group">
            <div class="controls">
                <a class="btn" href="{{ route('home') }}">Cancel</a>

                <button type="submit" class="btn">Complete Process</button>
            </div>
        </div>
    </form>
</div>
@stop

