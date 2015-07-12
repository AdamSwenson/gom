<?php

namespace PageToolClasses;

/**
 * This manages jquery plugins so that a page just needs to call this to load the plugins and all the locations and syntax are defined in one place
 * TODO: Add datatables to local jquery and setup to fall back to it
 * @author adam
 */
class JQueryPlugins
{
    protected static function a_syncLoad($file)
    {
        echo "<script>";
        echo "var node = document.createElement('script');";
        echo "node.type = 'text/javascript';";
        echo "node.async = true;";
        echo "node.src = '$file';";
        // echo "here.document.getElementByID('scripts_here');";
        echo " $('#scripts_here').append(node) ; ";
        echo "</script>";
    }

    /**
     * Callable from object context
     */
    public function jCookie()
    {
        self::jCookieLoad();
    }

    public static function jCookieLoad()
    {
        echo "<script type='text/javascript' src='" . \classes\Navigation::JCOOKIE . "/jquery.cookie.js'></script>";
    }

    public function datatables() { self::dataTablesLoad();}

    /**
     * Adds links to the css and js files for the jquery plugin dataTables
     */
    public static function dataTablesLoad($current_version='1.10.5')
    {
        echo "<link rel='stylesheet' href='//cdn.datatables.net/$current_version/css/jquery.dataTables.min.css' />";
        echo "<link rel='stylesheet' href='//cdn.datatables.net/plug-ins/f2c75b7247b/integration/jqueryui/dataTables.jqueryui.css' />"; //jquery ui plugin
        echo "<script type='text/javascript' src='//cdn.datatables.net/$current_version/js/jquery.dataTables.min.js'></script>";
        echo "<script type='text/javascript' src='//cdn.datatables.net/plug-ins/f2c75b7247b/integration/jqueryui/dataTables.jqueryui.js'></script>";
    }

    /**
     * Echos the css, jquery plugin, and specific plugins needed for jqplot
     */
    public static function jQPlotLoad()
    {
        self::jQPlot();
    }

    /**
     * Callable from object context
     */
    public function jQPlot()
    {
        # CSS
        echo '<link rel="stylesheet" type="text/css" href="' . \classes\Navigation::JQPLOT . '/jquery.jqplot.min.css" />';
        # JS main
        echo '<script language="javascript" type="text/javascript" src="' . \classes\Navigation::JQPLOT . '/jquery.jqplot.min.js"></script>';
        # JS plugin
        echo '<script type="text/javascript" src="' . \classes\Navigation::JQPLOT . '/plugins/jqplot.json2.min.js"></script>';
        echo '<script type="text/javascript" src="' . \classes\Navigation::JQPLOT . '/plugins/jqplot.barRenderer.min.js"></script>';
        echo '<script type="text/javascript" src="' . \classes\Navigation::JQPLOT . '/plugins/jqplot.categoryAxisRenderer.min.js"></script>';
        echo '<script type="text/javascript" src="' . \classes\Navigation::JQPLOT . '/plugins/jqplot.pointLabels.min.js"></script>';
        echo '<script type="text/javascript" src="' . \classes\Navigation::JQPLOT . '/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>';
        echo '<script type="text/javascript" src="' . \classes\Navigation::JQPLOT . '/plugins/jqplot.canvasTextRenderer.min.js"></script>';
        echo '<script type="text/javascript" src="' . \classes\Navigation::JQPLOT . '/plugins/jqplot.enhancedLegendRenderer.min.js"></script>';
    }

    /**
     * The jqplot files needed for the input page
     */
    public static function input_jQPlot()
    {
        echo "'js/jquery.jqplot.1.0.4/jquery.jqplot.min.js', ";
        echo "'js/jquery.jqplot.1.0.4/plugins/jqplot.json2.min.js, '";
        echo "'js/jquery.jqplot.1.0.4/plugins/jqplot.meterGaugeRenderer.min.js'";
//        echo '<script type="text/javascript" src="js/jquery.jqplot.1.0.4/jquery.jqplot.min.js"></script>';
//		echo '<script type="text/javascript" src="js/jquery.jqplot.1.0.4/plugins/jqplot.json2.min.js"></script>';
//		echo '<script type="text/javascript" src="js/jquery.jqplot.1.0.4/plugins/jqplot.meterGaugeRenderer.js"></script>';
    }

    public static function input_jQSlider()
    {
//        echo "var jqslider_scripts = [
//            'js/jslider/js/jshashtable-2.1_src.js',
//            'js/jslider/js/jquery.numberformatter-1.2.3.js',
//            'js/jslider/js/tmpl.js',
//            'js/jslider/js/jquery.dependClass-0.1.js',
//            'js/jslider/js/draggable-0.1.js',
//            'js/jslider/js/jquery.slider.js'
//            ];";
////
//        echo '<script type="text/javascript" src="js/jslider/js/jshashtable-2.1_src.js"></script>';
//        echo '<script type="text/javascript" src="js/jslider/js/jquery.numberformatter-1.2.3.js"></script>';
//        echo '<script type="text/javascript" src="js/jslider/js/tmpl.js"></script>';
//        echo '<script type="text/javascript" src="js/jslider/js/jquery.dependClass-0.1.js"></script>';
//        echo '<script type="text/javascript" src="js/jslider/js/draggable-0.1.js"></script>';
//        echo '<script type="text/javascript" src="js/jslider/js/jquery.slider.js"></script>';
    }

}

/*
 * ../jqueryFiles/jqPlot/jquery.jqplot.min.css" />';
        # JS main
        echo '<script language="javascript" type="text/javascript" src="../jqueryFiles/jqPlot/jquery.jqplot.min.js"></script>';
        # JS plugin
        echo '<script type="text/javascript" src="../jqueryFiles/jqPlot/plugins/jqplot.json2.min.js"></script>';
        echo '<script type="text/javascript" src="../jqueryFiles/jqPlot/plugins/jqplot.barRenderer.min.js"></script>';
        echo '<script type="text/javascript" src="../jqueryFiles/jqPlot/plugins/jqplot.categoryAxisRenderer.min.js"></script>';
        echo '<script type="text/javascript" src="../jqueryFiles/jqPlot/plugins/jqplot.pointLabels.min.js"></script>';
        echo '<script type="text/javascript" src="../jqueryFiles/jqPlot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>';
        echo '<script type="text/javascript" src="../jqueryFiles/jqPlot/plugins/jqplot.canvasTextRenderer.min.js"></script>';
        echo '<script type="text/javascript" src="../jqueryFiles/jqPlot/plugins/jqplot.enhancedLegendRenderer.min.js"></script>';
 */
