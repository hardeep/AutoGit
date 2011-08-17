<?php

define('SERVER_PHP_VERSION', substr(phpversion(), 0, strpos(phpversion(), '-')));

class AutoLoader
{

    static $libFolders;

    public function __construct()
    {
        Autoloader::$libFolders = array();

        spl_autoload_register('Autoloader::loadLibraries');
    }

    public function registerLibraries($directories)
    {
        if (!is_array($directories))
        {
            if (!is_array(Autoloader::$libFolders))
            {
                $temp = array($directories);
                $directories = $temp;
            } 
            else
            {
                array_push(Autoloader::$libFolders, $directories);
            }

        }

        foreach ($directories as $dir)
        {
           array_push(Autoloader::$libFolders, $dir);
        }
    }

    static function loadLibraries($class)
    {
        if (!is_array(Autoloader::$libFolders) || count(Autoloader::$libFolders) <= 0)
        {
            throwClassNotFound($class);
        } 

        foreach (Autoloader::$libFolders as $dir)
        {

            if (file_exists($dir."/".$class.".php"))
            {
                include $dir."/".$class.".php";
                return true;
            }
            else if (file_exists($dir."/".$class.".class.php"))
            {
                include $dir."/".$class.".class.php"; 
                return true;
            }
         }

        AutoLoader::throwClassNotFound($class);

    }

    function registeredLibraries()
    {
        return Autoloader::$libFolders;
    }

    static function throwClassNotFound($class)
    {
        if (strnatcmp(SERVER_PHP_VERSION, '5.3') >= 0)
        {
            // We are using php greater or equal to 5.3 safe to throw exception
            if ($type)
            {
                throw new ControllerClassNotFoundException($class.' was not found');
            }
            else 
            {
                throw new ClassNotFoundException($class.' was not found');
            }
        } 
        else         
        {
            // older versions of php < 5.3 cause a fatal error when throwing exceptions in __autoload
            eval("
                class  $class {
                    function __construct() {
                        throw new Exception('Class $class not found');
                    }
                }
            ");
        }
    }

}
