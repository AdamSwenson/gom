<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/6/15
 * Time: 6:40 PM
 */?>
        <!-- resources/views/emails/password.blade.php -->

Click here to reset your password: {{ url('password/reset/'.$token) }}
