<?php namespace DAO;
 
class Singleton
{
    private static $instance=array();
    public static function getInstance()
    {
        $myClass=get_called_class();
        if(!isset(self::$instance[$myClass]))
            {
                self::$instance[$myClass]=new $myClass;
            }
        return self::$instance[$myClass];
    }
}
