<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/9/17
 * Time: 5:49 PM
 */?>
@extends('layouts.master')

@include('layouts.commonCssInclude')

@section('body')
<h1>taco!</h1>
    <div id="app">

<breadcrumbs
        :active-index="2"
        route-root="{{ url('') }}"
        group="main">
</breadcrumbs>

        <breadcrumbs
                :active-index="0"
                route-root="{{ url('') }}"
                group="setup">
        </breadcrumbs>

    </div>
<script>const activeTab='';</script>
<script src="{{asset('js/common-package.js')}}"></script>

<script src="{{ asset('/js/dev/test2.js') }}"></script>
<script>

</script>
    @endsection

