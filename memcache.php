<?php

namespace Pasarkode;

class Memcache {   

    private $host;
    private $port;

    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
    }
        
    public static function get($key){
        if(class_exists('Memcache')){
            try{
                $memcache = new Memcache;
                $memcache->connect($this->host, $this->port) or error_log("Could not connect memcached");
                $get_result = $memcache->get($key);
                return $get_result;
            } catch (Exception $e){
                error_log('memcache: '.$e->getMessage());
                return false;
            }
        }else{
            return false;
        }
    }
    
    public static function del($key){
        if(class_exists('Memcache')){
            try{
                $memcache = new Memcache;
                $memcache->connect($this->host, $this->port) or error_log("Could not connect memcached");
                $get_result = $memcache->delete($key);
                return $get_result;
            } catch (Exception $e){
                error_log('memcache: '.$e->getMessage());
                return false;
            }
        }else{
            return false;
        }
    }
    
    public static function set($key, $params, $endtime=''){
        if(class_exists('Memcache')){
            try{
                $memcache = new Memcache;
                $memcache->connect($this->host, $this->port) or error_log("Could not connect memcached");
                $hour = 3;
                if($endtime==''){
                    $expired = 60 * 40;// * $hour;
                }else{
                    $expired = $endtime;
                }
                $memcache->set($key, $params, MEMCACHE_COMPRESSED, $expired); 	
            } catch (Exception $e){
                    error_log('memcache: '.$e->getMessage());
                return false;
            }
        } 
    }
}
