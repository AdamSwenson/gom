<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/9/15
 * Time: 1:37 PM
 */

namespace SecurityClasses\environ;


use SecurityClasses\errors\EnvironmentException;

/**
 * Class TemplateVarHolder
 * Holds and manages the environmental variables used by the templating engine
 * @package SecurityClasses\environ
 */
class TemplateVarHolder
{
    //names of the environmental variables
    const VARNAME_CACHE = "TEMPLATE_CACHE";
    const VARNAME_TEMPLATES = "TEMPLATE_PATH";

    protected $pathToTemplateFolder;

    protected $pathToCacheFolder;

    private static $instance;

    static public $vars = [self::VARNAME_CACHE, self::VARNAME_TEMPLATES];

    private function __construct()
    {
        $this->pathToTemplateFolder = getenv(self::VARNAME_TEMPLATES);
        $this->pathToCacheFolder = getenv(self::VARNAME_CACHE);
    }

    /**
     * @return string
     */
    public function getPathToTemplateFolder()
    {
        $this->checkSet($this->pathToTemplateFolder, EnvironmentException::PATH_TEMPLATES);
        return $this->pathToTemplateFolder;
    }

    /**
     * @return string
     */
    public function getPathToCacheFolder()
    {
        $this->checkSet($this->pathToTemplateFolder, EnvironmentException::PATH_CACHE);
        return $this->pathToCacheFolder;
    }


    public function __get($name)
    {
        if($this->$name){
            return $this->$name;
        }
    }

    protected function checkSet($var, $errorType)
    {
        if (empty($var)) {
            throw new EnvironmentException($errorType);
        } else {
            return true;
        }
    }

    /**
     * Undermine the whole point of a singleton. Used for testing only
     */
    public function destroy()
    {
        self::$instance = NULL;
    }

    /**
     * Use instead of constructor
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}