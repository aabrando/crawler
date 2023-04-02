<?php
App::import('Vendor','SimpleHTMLDom' .DS. 'simple_html_dom');

class DomObject {
    static $dom;

    private static function getInstance(){
        if (!self::$dom || self::$dom instanceof simple_html_dom ) {
            self::$dom = new simple_html_dom();
        }

        return self::$dom;
    }

    public static function make($from_html){
        $simpeDom = self::getInstance();
        return $simpeDom->load($from_html);
    }

    public static function make_str($from_html){
        return str_get_html($from_html);
    }

}


