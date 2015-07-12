<?php

namespace PageToolClasses;

/**
 * This detects the presence of an external internet connection. If a connection is present, it loads the file connecting to cdn copies of jquery If it is absent, it uses locally stored versions of jquery.
 *
 * @author adam
 */
class JQueryVersionSelect {

    /**
     *
     * @var boolean whether there is an external connection
     */
    public $externalConnection;

    public static $min_jquery = 'http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.2.min.js';

    public static $min_jquery_ui = 'http://ajax.aspnetcdn.com/ajax/jquery.ui/1.11.4/jquery-ui.min.js';

    public static $min_template = 'http://ajax.aspnetcdn.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js';

    public static $min_touchpunch = 'inc/js/touchpunch.js';



    public function __construct() {
        self::checkConnection();
    }

    /**
     * This is the main method that should be called. It checks whether the program has access to the internet and loads local if it does not
     */
    public static function load() {
        self::checkConnection();
    }

    protected static function checkConnection() {
        $tryconnect = @fsockopen("www.google.com", 80);
        if ($tryconnect) {
            $externalConnection = true;
            fclose($tryconnect);
            if(isset($_SESSION['test']) && $_SESSION['test'] === TRUE){
             self::useHostedFull();   
            }
            else{
            self::useHosted();
            }
        } else {
            $externalConnection = false;
            self::useLocal();
        }
    }

    /**
     * Loads locally stored jquery files. These have been given generic names here. New versions should have the files renamed to match this
     */
    protected static function useLocal() {
        #stylesheet
        echo '<link rel="stylesheet" href="inc/js/local_jquery/jquery.ui.custom.min.css">';
        #jquery main
        echo '<script type="text/javascript" src="inc/js/local_jquery/jquery.min.js"></script>';
        #jquery ui (smoothness)
        echo '<script type="text/javascript" src="inc/js/local_jquery/jquery.ui.custom.min.js"></script>';
        #template plugin
        echo '<script type="text/javascript" src="inc/js/local_jquery/jquery.tmpl.min.js"></script>';
        #Fix for mouse on ipads etc
        echo '<script type="text/javascript" src="inc/js/touchpunch.js"></script>';
    }

    public static function returnHosted()
    {
        $r = array();
        self::chooseStyle();
        $scripts = array(self::$min_jquery, self::$min_jquery_ui, self::$min_template, self::$min_touchpunch);
        foreach ($scripts as $s) {
            array_push($r, '<script type="text/javascript" src="' . $s . '">"</script>');
        }

        return $r;
    }

    /**
     * Loads remote jquery files
     * Using all from aspnetcdn so that will load faster
     * was working okay with jquery 1.9.1 and ui 1.10.4
     */
    protected static function useHosted() {
        $r = self::returnHosted();
        foreach ($r as $script) {
            echo $script;
        }
//        self::chooseStyle();
//        //Nb, Starting with the // gets around problems with http and https
//        // (though will create problems if page is not loaded on a server --if loaded file://)
//        $scripts = array(self::$min_jquery, self::$min_jquery_ui, self::$min_template, self::$min_touchpunch);
//        foreach($scripts as )
//
//        #jquery main
//        echo self::$main_jquery;
//        //'<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.2.min.js"></script>';
//        #jquery ui
//        echo '<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.11.4/jquery-ui.min.js"></script>';
////            echo '<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.11.0/jquery-ui.min.js"></script>';
//        #template
//        echo '<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js"></script>';
//        #Fix for mouse on ipads etc
//        echo '<script type="text/javascript" src="js/touchpunch.js"></script>';
    }

    /**
     * This loads the non-minified version for testing
     */
    protected static function useHostedFull() {
        self::chooseStyle();
        //Nb, Starting with the // gets around problems with http and https
        // (though will create problems if page is not loaded on a server --if loaded file://)
        #jquery main
        echo '<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.2.js"></script>';
        #jquery ui
        echo '<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.11.4/jquery-ui.js"></script>';
//            echo '<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.11.0/jquery-ui.min.js"></script>';
        #template
        echo '<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.templates/beta1/jquery.tmpl.js"></script>';
        #Fix for mouse on ipads etc
        echo '<script type="text/javascript" src="inc/js/touchpunch.js"></script>';
    }

    /**
     * This detects whether the app wants a particular jquery theme (as defined in filemaster;
     * defaults to trontastic. Possible values include black-tie, overcast, smoothness....
     */
    protected static function chooseStyle() {
        if (JQUERYTHEME) {
            echo '<link rel="stylesheet" href="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/themes/' . JQUERYTHEME . '/jquery-ui.css">';
        } else {
            echo '<link rel="stylesheet" href="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/themes/overcast/jquery-ui.css">';
        }
    }

#JQUERY VERSION SELECT
}
