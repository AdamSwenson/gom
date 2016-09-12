<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/2/15
 * Time: 3:21 PM
 */?>
@extends('emails.studentNotification.base')

@section('notificationText')
    Your instructor has graded your {{ $examName }}. Your feedback is ready to be viewed.
@endsection
