<!DOCTYPE html>
<html class="html" lang="en-US">
<head>
    <script type="text/javascript">
        if(typeof Muse == "undefined") window.Muse = {}; window.Muse.assets = {"required":["jquery-1.8.3.min.js", "museutils.js", "webpro.js", "musewpslideshow.js", "jquery.museoverlay.js", "touchswipe.js", "jquery.watch.js", "index.css"], "outOfDate":[]};
    </script>

    <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
    <meta name="generator" content="2015.0.2.310"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Welcome to gradeomatic</title>
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('/inc/home/css/site_global.css?4052507572', env('APP_ENV') == 'production')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/inc/home/css/index.css?273850682', env('APP_ENV') == 'production')}}" id="pagesheet"/>
    <!-- Other scripts -->
    <script type="text/javascript">
        document.documentElement.className += ' js';
    </script>

        @include('layouts.js_jquery_loader')
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

<div class="clearfix" id="page"><!-- column -->

    <div class="position_content" id="page_position_content">
    <div class="container">

        <a href="{{url('home')}}" >
        <div class="clearfix colelem" id="pu88"><!-- group -->
            <div class="browser_width" id="u88-bw">
                <div class="shadow" id="u88"><!-- simple frame --></div>
            </div>
            <div class="clearfix" id="u82-4"><!-- content -->
                <p>gradeomatic</p>
            </div>
        </div>
        </a>

        </div>


        <div class="clearfix pinned-colelem" id="u305"><!-- group -->

         <a href="{{url('auth/register')}}" >
            <div class="rounded-corners clearfix" id="u78"><!-- group -->
                <div class="clearfix" id="u75-4"><!-- content -->
                   Sign Up
                </div>
            </div>
         </a>

         <a href="#" id="cloneExamLink" class="" data-toggle="collapse"
            data-target="#loginMenu" data-parent="#examAction" style="cursor:pointer;">
            <div class="rounded-corners clearfix" id="u79"><!-- group -->
                <div class="clearfix" id="u77-4"><!-- content -->
                    Login
                </div>
            </div>
         </a>

        </div>


        <div class="SlideShowWidget clearfix colelem" id="slideshowu278"><!-- none box -->
            <div class="popup_anchor" id="u283popup">
                <div class="SlideShowContentPanel clearfix" id="u283"><!-- stack box -->
                    <div id="loginMenu" class="collapse">
                        <div class="row" >
                            <div class="col-xs-8">
                                <!-- Something goes here -->
                            </div>
                            @include('auth.login_form')

                        </div>
                    </div>
                    <div class="SSSlide clip_frame grpelem" id="u284"><!-- image -->
                        <img class="ImageInclude" id="u284_img" data-src="{{asset('inc/home/images/stack%20of%20papers.jpg', env('APP_ENV') == 'production')}}" src="{{asset('inc/home/images/blank.gif', env('APP_ENV') == 'production')}}" alt="" data-width="1160" data-height="774"/>
                    </div>
                </div>
            </div>

        </div>
        <div class="clearfix colelem" id="u101-3"><!-- content -->
            <p>&nbsp;</p>
        </div>
        <div class="clearfix colelem" id="pu87-7"><!-- group -->
            <div class="clearfix grpelem" id="u87-7"><!-- content -->
                <p id="u87-2">Grade faster</p>
                <p><span id="u87-3">Teach better.</span></p>
            </div>
            <div class="clearfix grpelem" id="u303-4"><!-- content -->
                <p>The app teachers love.</p>
            </div>
        </div>
        <a href="{{url('account/create')}}">
        <div class="rounded-corners clearfix colelem" id="u95"><!-- group -->
            <div class="clearfix grpelem" id="u96-4"><!-- content -->
                <p>Get Started</p>
            </div>
        </div>
        </a>
        <div class="browser_width colelem" id="u304-bw">
            <div id="u304"><!-- simple frame --></div>
        </div>
        <div class="clearfix colelem" id="pu90"><!-- group -->
            <div class="browser_width grpelem" id="u90-bw">
                <div id="u90"><!-- simple frame --></div>
            </div>
            <div class="SlideShowWidget clearfix grpelem" id="slideshowu194"><!-- none box -->
                <div class="popup_anchor" id="u197popup">
                    <div class="SlideShowContentPanel clearfix" id="u197"><!-- stack box -->
                        <div class="SSSlide clip_frame grpelem" id="u198"><!-- image -->
                            <img class="ImageInclude" id="u198_img" data-src="{{asset('inc/home/images/teacher%20grading_1.png', env('APP_ENV') == 'production')}}" src="{{asset('inc/home/images/blank.gif', env('APP_ENV') == 'production')}}" alt="picture of teacher grading" data-width="1160" data-height="774"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix grpelem" id="u100-4"><!-- content -->
                <p>Grade faster</p>
            </div>
            <div class="clearfix grpelem" id="u102-4"><!-- content -->
                <p>Designed by a teacher, gradeomatic helps educators create and grade written assignments, cutting work time and improving test quality.</p>
            </div>
        </div>
        <div class="browser_width colelem" id="u98-bw">
            <div id="u98"><!-- group -->
                <div class="clearfix" id="u98_align_to_page">
                    <div class="clip_frame grpelem" id="u272"><!-- image -->
                        <img class="block" id="u272_img" src="{{asset('inc/home/images/guage.png', env('APP_ENV') == 'production')}}" alt="large gauge" width="938" height="630"/>
                    </div>
                    <div class="clearfix grpelem" id="pu103-4"><!-- column -->
                        <div class="clearfix colelem" id="u103-4"><!-- content -->
                            <p>Teach better</p>
                        </div>
                        <div class="clearfix colelem" id="u267-8"><!-- content -->
                            <p>Our analytical tools illuminate grading.&nbsp; Tracking student performance allows teachers to</p>
                            <p>self-assess and build better tests</p>
                            <p>that the right questions.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="SlideShowWidget clearfix colelem" id="slideshowu140"><!-- none box -->
            <div class="popup_anchor" id="u149popup">
                <div class="SlideShowContentPanel clearfix" id="u149"><!-- stack box -->
                    <div class="SSSlide clip_frame grpelem" id="u150"><!-- image -->
                        <img class="ImageInclude" id="u150_img" data-src="{{asset('inc/home/images/students_1.png', env('APP_ENV') == 'production')}}" src="{{asset('inc/home/images/blank.gif', env('APP_ENV') == 'production')}}" alt="" data-width="1160" data-height="774"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix colelem" id="pu107"><!-- group -->
            <div class="browser_width grpelem" id="u107-bw">
                <div id="u107"><!-- simple frame --></div>
            </div>
            <div class="clearfix grpelem" id="u108-4"><!-- content -->
                <p>PersonalizedFeedback</p>
            </div>
            <div class="clearfix grpelem" id="u268-4"><!-- content -->
                <p>Automatically build individualized responses for each student, letting them see exactly where they succeeded and where they need to improve.</p>
            </div>
        </div>
        <div class="browser_width colelem" id="u117-bw">
            <div id="u117"><!-- group -->
                <div class="clearfix" id="u117_align_to_page">
                    <div class="clearfix grpelem" id="u118-4"><!-- content -->
                        <p>Sign up today for free</p>
                    </div>
                    <a href="{{url('account/create')}}">
                    <div class="rounded-corners clearfix grpelem" id="u119"><!-- group -->
                        <div class="clearfix grpelem" id="u120-4"><!-- content -->
                            <p>Get Started</p>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="clearfix colelem" id="pu106"><!-- group -->
            <div class="browser_width grpelem" id="u106-bw">
                <div id="u106"><!-- group -->
                    <div class="clearfix" id="u106_align_to_page">
                        <div class="clearfix grpelem" id="u116-4"><!-- content -->
                            <p>2015 gradeomatic</p>
                        </div>
                        <div class="clearfix grpelem" id="u114-4"><!-- content -->
                            <p>About</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix grpelem" id="u115-4"><!-- content -->
                <p>Contact</p>
            </div>
        </div>

        <div class="verticalspacer"></div>
    </div>
    </div>
</div>
<!-- JS includes -->
<script src="{{asset('inc/home/scripts/jquery-1.8.3.min.js', env('APP_ENV') == 'production')}}" type="text/javascript"></script>
<script src="{{asset('inc/home/scripts/museutils.js?275725342', env('APP_ENV') == 'production')}}" type="text/javascript"></script>
<script src="{{asset('inc/home/scripts/webpro.js?3883484123', env('APP_ENV') == 'production')}}" type="text/javascript"></script>
<script src="{{asset('inc/home/scripts/musewpslideshow.js?360574455', env('APP_ENV') == 'production')}}" type="text/javascript"></script>
<script src="{{asset('inc/home/scripts/jquery.museoverlay.js?342093292', env('APP_ENV') == 'production')}}" type="text/javascript"></script>
<script src="{{asset('inc/home/scripts/touchswipe.js?4218319045', env('APP_ENV') == 'production')}}" type="text/javascript"></script>
<script src="{{asset('inc/home/scripts/jquery.watch.js?3999102769', env('APP_ENV') == 'production')}}" type="text/javascript"></script>
<!-- Other scripts -->
<script type="text/javascript">
    $(document).ready(function() { try {
        (function(){var a={},b=function(a){if(a.match(/^rgb/))return a=a.replace(/\s+/g,"").match(/([\d\,]+)/gi)[0].split(","),(parseInt(a[0])<<16)+(parseInt(a[1])<<8)+parseInt(a[2]);if(a.match(/^\#/))return parseInt(a.substr(1),16);return 0};(function(){$('link[type="text/css"]').each(function(){var b=($(this).attr("href")||"").match(/\/?css\/([\w\-]+\.css)\?(\d+)/);b&&b[1]&&b[2]&&(a[b[1]]=b[2])})})();(function(){$("body").append('<div class="version" style="display:none; width:1px; height:1px;"></div>');
            for(var c=$(".version"),d=0;d<Muse.assets.required.length;){var f=Muse.assets.required[d],g=f.match(/([\w\-\.]+)\.(\w+)$/),k=g&&g[1]?g[1]:null,g=g&&g[2]?g[2]:null;switch(g.toLowerCase()){case "css":k=k.replace(/\W/gi,"_").replace(/^([^a-z])/gi,"_$1");c.addClass(k);var g=b(c.css("color")),h=b(c.css("background-color"));g!=0||h!=0?(Muse.assets.required.splice(d,1),"undefined"!=typeof a[f]&&(g!=a[f]>>>24||h!=(a[f]&16777215))&&Muse.assets.outOfDate.push(f)):d++;c.removeClass(k);break;case "js":k.match(/^jquery-[\d\.]+/gi)&&
            typeof $!="undefined"?Muse.assets.required.splice(d,1):d++;break;default:throw Error("Unsupported file type: "+g);}}c.remove();if(Muse.assets.outOfDate.length||Muse.assets.required.length)c="Some files on the server may be missing or incorrect. Clear browser cache and try again. If the problem persists please contact website author.",(d=location&&location.search&&location.search.match&&location.search.match(/muse_debug/gi))&&Muse.assets.outOfDate.length&&(c+="\nOut of date: "+Muse.assets.outOfDate.join(",")),d&&Muse.assets.required.length&&(c+="\nMissing: "+Muse.assets.required.join(",")),alert(c)})()})();
        /* body */
        Muse.Utils.transformMarkupToFixBrowserProblemsPreInit();/* body */
        Muse.Utils.prepHyperlinks(true);/* body */
        Muse.Utils.initWidget('#slideshowu278', function(elem) { $(elem).data('widget', new WebPro.Widget.ContentSlideShow(elem, {heroFitting:'fillFrameProportionally',autoPlay:true,displayInterval:3000,slideLinkStopsSlideShow:false,transitionStyle:'fading',lightboxEnabled_runtime:false,shuffle:false,transitionDuration:500,enableSwipe:true,elastic:'fullWidth',resumeAutoplay:true,resumeAutoplayInterval:3000,playOnce:false,autoActivate_runtime:false})); });/* #slideshowu278 */
        Muse.Utils.resizeHeight()/* resize height */
        Muse.Utils.initWidget('#slideshowu194', function(elem) { $(elem).data('widget', new WebPro.Widget.ContentSlideShow(elem, {heroFitting:'fillFrameProportionally',autoPlay:true,displayInterval:3000,slideLinkStopsSlideShow:false,transitionStyle:'fading',lightboxEnabled_runtime:false,shuffle:false,transitionDuration:500,enableSwipe:true,elastic:'fullWidth',resumeAutoplay:true,resumeAutoplayInterval:3000,playOnce:false,autoActivate_runtime:false})); });/* #slideshowu194 */
        Muse.Utils.initWidget('#slideshowu140', function(elem) { $(elem).data('widget', new WebPro.Widget.ContentSlideShow(elem, {heroFitting:'fillFrameProportionally',autoPlay:true,displayInterval:3000,slideLinkStopsSlideShow:false,transitionStyle:'fading',lightboxEnabled_runtime:false,shuffle:false,transitionDuration:500,enableSwipe:true,elastic:'fullWidth',resumeAutoplay:true,resumeAutoplayInterval:3000,playOnce:false,autoActivate_runtime:false})); });/* #slideshowu140 */
        Muse.Utils.fullPage('#page');/* 100% height page */
        Muse.Utils.showWidgetsWhenReady();/* body */
        Muse.Utils.transformMarkupToFixBrowserProblems();/* body */
    } catch(e) { if (e && 'function' == typeof e.notify) e.notify(); else Muse.Assert.fail('Error calling selector function:' + e); }});
</script>
@include('other.google_analytics_include')
</body>
</html>
