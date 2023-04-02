<?php 
abstract class AbstractCache {
    protected $key;
    protected $config;

    abstract protected function createCache();

    function __construct(){
    	if (!$this->config)
        	$this->config = 'default';
    }

    public function read(){
        $data = Cache::read($this->key,$this->config);
        if (!$data){
            $this->createCache();
        }

        return Cache::read($this->key,$this->config);
    }

    public function clear(){
        Cache::delete($this->key);
    }
    
}