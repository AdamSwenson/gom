<!DOCTYPE html>
<html class="html" lang="en-US">
<head>
    <script type="text/javascript">
        if (typeof Muse == "undefined") window.Muse = {};
        window.Muse.assets = {
            "required": ["jquery-1.8.3.min.js", "museutils.js", "webpro.js", "musewpslideshow.js", "jquery.museoverlay.js", "touchswipe.js", "jquery.watch.js", "index.css"],
            "outOfDate": []
        };
    </script>

    <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
    <meta name="generator" content="2015.0.2.310"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title')</title>
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href={{secure_asset('/inc/home/css/site_global.css?4052507572')}}/>
    <link rel="stylesheet" type="text/css" href="{{secure_asset('/inc/home/css/index.css?273850682')}}" id="pagesheet"/>
    <!-- Other scripts -->
    <script type="text/javascript">
        document.documentElement.className += ' js';
    </script>

    @include('layouts.js_jquery_loader')
    @include('layouts.js_bootstrap_loader')

</head>
<body>

<div class="clearfix" id="page"><!-- column -->

    <div class="position_content" id="page_position_content">
        <div class="container">
            <a href="{{url('home')}}">
                <div class="clearfix colelem" id="pu88"><!-- group -->
                    <div class="browser_width" id="u88-bw">
                        <div class="shadow" id="u88"><!-- simple frame --></div>
                    </div>
                    <div class="clearfix" id="u82-4"><!-- content -->
                        <p>GradeOmatic</p>
                    </div>
                </div>
            </a>

            <div class="SlideShowWidget clearfix colelem" id="slideshowu278"><!-- none box -->
                <div class="popup_anchor" id="u283popup">
                    <div class="SlideShowContentPanel clearfix" id="u283"><!-- stack box -->

                        <div class="row">
                            <div class="col-xs-8">
                                @yield('formArea')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix colelem" id="pu106"><!-- group -->

                <div class="browser_width grpelem" id="u106-bw">
                    <div id="u106"><!-- group -->
                        <div class="clearfix" id="u106_align_to_page">
                            <div class="clearfix grpelem" id="u116-4"><!-- content -->
                                <p>2015 Gradeomatic</p>
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

        </div>
    </div>
</div>
<!-- JS includes -->
{{--<script type="text/javascript">--}}
    {{--if (document.location.protocol != 'https:') document.write('\x3Cscript src="http://musecdn2.businesscatalyst.com/scripts/4.0/jquery-1.8.3.min.js" type="text/javascript">\x3C/script>');--}}
{{--</script>--}}
<script src="{{ asset('js/home-package.js') }}" type="text/javascript"></script>
{{--<script src="{{secure_asset('inc/home/scripts/jquery-1.8.3.min.js')}}" type="text/javascript"></script>--}}
{{--<script src="{{secure_asset('inc/home/scripts/museutils.js?275725342')}}" type="text/javascript"></script>--}}
{{--<script src="{{secure_asset('inc/home/scripts/webpro.js?3883484123')}}" type="text/javascript"></script>--}}
{{--<script src="{{secure_asset('inc/home/scripts/musewpslideshow.js?360574455')}}" type="text/javascript"></script>--}}
{{--<script src="{{secure_asset('inc/home/scripts/jquery.museoverlay.js?342093292')}}" type="text/javascript"></script>--}}
{{--<script src="{{secure_asset('inc/home/scripts/touchswipe.js?4218319045')}}" type="text/javascript"></script>--}}
{{--<script src="{{secure_asset('inc/home/scripts/jquery.watch.js?3999102769')}}" type="text/javascript"></script>--}}
<!-- Other scripts -->
<script type="text/javascript">
    $(document).ready(function () {
        try {
            (function () {
                var a = {}, b = function (a) {
                    if (a.match(/^rgb/))return a = a.replace(/\s+/g, "").match(/([\d\,]+)/gi)[0].split(","), (parseInt(a[0]) << 16) + (parseInt(a[1]) << 8) + parseInt(a[2]);
                    if (a.match(/^\#/))return parseInt(a.substr(1), 16);
                    return 0
                };
                (function () {
                    $('link[type="text/css"]').each(function () {
                        var b = ($(this).attr("href") || "").match(/\/?css\/([\w\-]+\.css)\?(\d+)/);
                        b && b[1] && b[2] && (a[b[1]] = b[2])
                    })
                })();
                (function () {
                    $("body").append('<div class="version" style="display:none; width:1px; height:1px;"></div>');
                    for (var c = $(".version"), d = 0; d < Muse.assets.required.length;) {
                        var f = Muse.assets.required[d], g = f.match(/([\w\-\.]+)\.(\w+)$/), k = g && g[1] ? g[1] : null, g = g && g[2] ? g[2] : null;
                        switch (g.toLowerCase()) {
                            case "css":
                                k = k.replace(/\W/gi, "_").replace(/^([^a-z])/gi, "_$1");
                                c.addClass(k);
                                var g = b(c.css("color")), h = b(c.css("background-color"));
                                g != 0 || h != 0 ? (Muse.assets.required.splice(d, 1), "undefined" != typeof a[f] && (g != a[f] >>> 24 || h != (a[f] & 16777215)) && Muse.assets.outOfDate.push(f)) : d++;
                                c.removeClass(k);
                                break;
                            case "js":
                                k.match(/^jquery-[\d\.]+/gi) &&
                                typeof $ != "undefined" ? Muse.assets.required.splice(d, 1) : d++;
                                break;
                            default:
                                throw Error("Unsupported file type: " + g);
                        }
                    }
                    c.remove();
                    if (Muse.assets.outOfDate.length || Muse.assets.required.length)c = "Some files on the server may be missing or incorrect. Clear browser cache and try again. If the problem persists please contact website author.", (d = location && location.search && location.search.match && location.search.match(/muse_debug/gi)) && Muse.assets.outOfDate.length && (c += "\nOut of date: " + Muse.assets.outOfDate.join(",")), d && Muse.assets.required.length && (c += "\nMissing: " + Muse.assets.required.join(",")), alert(c)
                })()
            })();
            /* body */
            Muse.Utils.transformMarkupToFixBrowserProblemsPreInit();
            /* body */
            Muse.Utils.prepHyperlinks(true);
            /* body */
            Muse.Utils.initWidget('#slideshowu278', function (elem) {
                $(elem).data('widget', new WebPro.Widget.ContentSlideShow(elem, {
                    heroFitting: 'fillFrameProportionally',
                    autoPlay: true,
                    displayInterval: 3000,
                    slideLinkStopsSlideShow: false,
                    transitionStyle: 'fading',
                    lightboxEnabled_runtime: false,
                    shuffle: false,
                    transitionDuration: 500,
                    enableSwipe: true,
                    elastic: 'fullWidth',
                    resumeAutoplay: true,
                    resumeAutoplayInterval: 3000,
                    playOnce: false,
                    autoActivate_runtime: false
                }));
            });
            /* #slideshowu278 */
            Muse.Utils.resizeHeight()
            /* resize height */
            Muse.Utils.initWidget('#slideshowu194', function (elem) {
                $(elem).data('widget', new WebPro.Widget.ContentSlideShow(elem, {
                    heroFitting: 'fillFrameProportionally',
                    autoPlay: true,
                    displayInterval: 3000,
                    slideLinkStopsSlideShow: false,
                    transitionStyle: 'fading',
                    lightboxEnabled_runtime: false,
                    shuffle: false,
                    transitionDuration: 500,
                    enableSwipe: true,
                    elastic: 'fullWidth',
                    resumeAutoplay: true,
                    resumeAutoplayInterval: 3000,
                    playOnce: false,
                    autoActivate_runtime: false
                }));
            });
            /* #slideshowu194 */
            Muse.Utils.initWidget('#slideshowu140', function (elem) {
                $(elem).data('widget', new WebPro.Widget.ContentSlideShow(elem, {
                    heroFitting: 'fillFrameProportionally',
                    autoPlay: true,
                    displayInterval: 3000,
                    slideLinkStopsSlideShow: false,
                    transitionStyle: 'fading',
                    lightboxEnabled_runtime: false,
                    shuffle: false,
                    transitionDuration: 500,
                    enableSwipe: true,
                    elastic: 'fullWidth',
                    resumeAutoplay: true,
                    resumeAutoplayInterval: 3000,
                    playOnce: false,
                    autoActivate_runtime: false
                }));
            });
            /* #slideshowu140 */
            Muse.Utils.fullPage('#page');
            /* 100% height page */
            Muse.Utils.showWidgetsWhenReady();
            /* body */
            Muse.Utils.transformMarkupToFixBrowserProblems();
            /* body */
        } catch (e) {
            if (e && 'function' == typeof e.notify) e.notify(); else Muse.Assert.fail('Error calling selector function:' + e);
        }
    });
</script>
</body>
</html>