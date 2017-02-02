<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/9/17
 * Time: 4:49 PM
 *
 * Expects variables named: $activeIndex and $group
 * These should be injected into master.blade by CrumbComposer
 *
 * Depends on crumbnav.js being included in the client script
 */?>

<breadcrumbs
        :active-index="{{ $activeIndex or 0 }}"
        route-root="{{ url('') }}"
        group="{{$group or 'setup'}}">
</breadcrumbs>