<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/13/15
 * Time: 6:19 PM
 */?>
<!DOCTYPE html>
        <html lang="en">
<head>
<meta charset="utf-8">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>
<body>
<div id="main" class="container">
    <input type="text" v-model="minScore">
    <input type="text" v-model="maxScore">
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/0.12.10/vue.js"></script>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
