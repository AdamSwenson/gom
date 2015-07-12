<?php
namespace PageToolClasses;
/**
 * Detects whether using a phone or tablet and does stuff to prevent webkit behaviors
 *
 * @author adam
 */
class WebkitHead
{
/**
 *
 * @var array A list of devices using webkit
 */
    protected static $webkit_devices = array('ipad', 'iPhone', 'iPod', 'webOS');
/**
 * Does the actual detecting. This is the one that should be called
 */
    public static function detect()
    {
        $agent = $_SERVER['HTTP_USER_AGENT'];
        foreach (self::$webkit_devices as $d) {
            $result = stripos($agent, $d);
            # If not false, the user agent is in the list of webkit devices
            if ($result) {
                self::set_webkit_styles();
            }
        }
    }

/**
 * When a webkit device is detected, echo the settings
 */
    protected static function set_webkit_styles()
    {
            # Fixes the page size to full screen and prevents zooming in and out
            echo  '<meta name="viewport" content="width=device-width; initial-scale=1.0; user-scalable=0;">';
            # Allows to run full screen
            echo '<meta name="apple-mobile-web-app-capable" content="yes">';
            echo '<style type="text/css">';
                echo ' *{';
                    echo '-webkit-touch-callout: none;'; /*prevents the highlight and display of copy etc option behaiour*/
                    //	    -webkit-user-select: none; /*prevent userselecting and copying stuff*/
                    //	    -webkit-tap-highlight-color: rgba(0,0,0,0);/*stop highlighting links*/
                    //	    -webkit-text-size-adjust: none; /*no autoresizing of text*/
                echo '}';
                // echo '.instructions { -webkit-user-select: text;}';
            echo '</style> ';
    }

#webkithead
}
