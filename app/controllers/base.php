<?php
class Base extends Controller{
    public $test = 'Добро пожаловать!';

    public function actionIndex(){
        $template = View::init();
        $template->set('title', 'Главная страница');
        $template->set('content', $template->load('/controller/base_index'));
        $template->set('h1',$this->test);
    }
}