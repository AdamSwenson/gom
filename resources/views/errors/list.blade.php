<?php
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 7/19/2015
 * Time: 11:03 PM
 */

// Outputs any errors on the page
    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
@stop