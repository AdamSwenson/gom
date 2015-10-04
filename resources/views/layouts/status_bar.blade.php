<?php
/**
 * This displays flashed messages from the server
 * flashed messages can have keys:
 *      flash_message  => text to display
 *      status_success => true (if included, just don't include if failure)
 *      status_failure => true (if included, just don't include if success)
 *      message_important => true (if true, do not fade out the message)
 */?>

@if (session()->has('flash_message'))
    <?php
            $type = session()->has('status_success') ? 'alert-success' : '';
            $dismissable = session()->has('message_important') ? '';
    ?>
    <div class="alert {{ }}">
        {{ session('success_message') }}
    </div>
    @elseif(session()->has('failure_message'))
    <div class="alert alert-warning</div>
        {{ session('success_message') }}
    </div>

@endif
