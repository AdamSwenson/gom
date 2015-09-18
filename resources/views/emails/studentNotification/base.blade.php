<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/13/15
 * Time: 2:20 PM
 */?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<p>
    Dear {{ $studentName }},
</p>

@yield('notificationText')

<p>To view your feedback please use the following link <br />
    <a href="{{ $feedbackLink }}">{{ $feedbackLink }}</a>
</p>
<p>If you have trouble with the link, please go to <a href="{{ $siteLink }}">{{ $siteLink }}</a> <br />
    and enter the access key: <br />
    {{  $accessKey }}
</p>
@yield('additionalMessage')


</html>
