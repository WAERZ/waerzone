<?php
class View
{
    private static $instance = null;

    // this array contains all the template keys
    private $data = array();

    final private function __construct(){}
    final private function __clone(){}

    public static function init(){
        {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }
    }

    /**
     * load html file
     * @param $name
     * @return
     */
    public static function load($name){
        $html_file = VIEW .'default/'.$name.'.html';
        if(file_exists($html_file)){
            $html = file_get_contents($html_file);
        }
        return $html;
    }

    /**
     * Replace template values
     */
    public function parse(){
        $html = $this->load('main');
        foreach ($this->data as $key => $value) {
            $key = '<!--'.$key.'-->';
            $html = str_replace($key, $value, $html);
        }
        echo $html;
    }

    /**
     * setter array data
     * @param $key
     * @param $value
     */
    public function set($key, $value){
        $this->data[$key] = $value;
    }

/*
 * @deprecated use $this->parse
 *
*/
    public function __destruct(){
        $html = $this->load('main');
        foreach ($this->data as $key => $value) {
            $key = '<!--'.$key.'-->';
            $html = str_replace($key, $value, $html);
        }
        echo $html;
    }
}