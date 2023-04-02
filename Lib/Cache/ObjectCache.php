<?php
App::uses('AbstractCache','Lib' .DS. 'Cache');

class ObjectCache extends AbstractCache { 
    protected $Model;
    private $method;
    private $params;

    function __construct($model, $key, $config){
        $this->key   = $key;
        $this->config= ($config ? $config : 'default'); 
        $this->Model = $model;
        parent::__construct();
    } 

    static function make($model, $key, $config='default'){ 
        return new self($model, md5($key), $config); 
    }

    protected function createCache(){ 
        $result =  (call_user_func_array (array ($this->Model, $this->method), $this->params));
        Cache::write($this->key,$result,$this->config);
    }

    function __call($method, $params){
        $this->method = $method;
        $this->params = $params;
        return $this->read();
    }
}