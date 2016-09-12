<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/2/15
 * Time: 3:22 PM
 */?>
@extends('emails.studentNotification.base')

@section('notificationText')
    Your instructor has updated the feedback for {{ $examName }}. Your feedback may have changed.
@endsection
