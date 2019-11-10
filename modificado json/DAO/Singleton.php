<?php namespace DAO;
 
 //se pone en el index  y se exiende de singleton en el dao de sql
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
?>