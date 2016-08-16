<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Your feedback</title>
    <meta name="description" content="Feedback for your exam">

    <link href='{{ asset('inc/images/favicon.ico') }}' rel='icon' type='image/x-icon'/>

    @include('layouts.css.css_bootstrap')
    <style type="text/css"></style>
</head>
<body>

<div id="feedbackLoginPage" class="container-fluid mainBodyLocator">
    @include('flash::message')
    @include('errors.list')

    <div class="row">
        <div class="col-xs-1"></div>
        <div class="col-xs-10">
            <h3>Log in to view your feedback</h3>
        </div>
        <div class="col-xs-1"></div>
    </div>

    <form id="feedbackLogin"
          method="post"
          action="{{ url('feedback/login') }}"
          accept-charset="UTF-8">
        <div class="row">
            <div class="col-xs-1"></div>
            <div class="col-xs-10">
                <div class="form-group">
                    <label for="accessKey" class="control-label">Please enter the access key that was emailed to
                        you</label>
                    <input type="text"
                           class="form-control"
                           id="accessKey"
                           name="accessKey"
                           placeholder="This looks something like: b8bc6e4e50c5a8dcdeae6fb644c34696069ce3d1cd88eb68cea51f84b6b8d50a">
                    <input type="hidden" name="_token" id="nonce" value="{{ csrf_token() }}">
                </div>
            </div>
            <div class="col-xs-1"></div>
        </div>
        <div class="row">
            <div class="col-xs-1"></div>
            <div class="form-group">
                <div class="col-sm-10">
                    <button type="submit"
                            id="submit"
                            name="submit"
                            class="btn btn-primary">View Feedback
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="jsArea">
    <script type="javascript/text" src="{{ asset('js/feedback-login-package.js') }}"></script>
</div>
</body>
</html>