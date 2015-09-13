<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/2/15
 * Time: 3:21 PM
 */?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<p>
    {{--{{ $data['studentName'] }}--}}
Dear {{ $studentName }},
</p>
{{--{{ $data['examName'] }}--}}
<p>Your instructor's feedback for your {{ $examName }} is ready to be viewed  </p>

<p>To view your feedback please use the following link <br />
{{ $feedbackLink }}
    {{--{{ $data['feedbackLink'] }}--}}
</p>
{{--{{ $data['siteLink'] }}--}}
<p>If you have trouble with the link, please go to {{ $siteLink }} <br />
    and enter the access key: <br />
    {{--{{  $data['accessKey'] }}--}}
    {{  $accessKey }}

</p>


</html>