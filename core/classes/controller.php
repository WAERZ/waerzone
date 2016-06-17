<?php
class Controller {
    function __construct(){
        $widget = new Widget();
        $widget->set('admins','test','view/add/edit/delete');
        $widget->set('moders','test','view/add');
        $widget->set('users','test','view');

        $widget->set('admins','best','view/add/delete');
        $widget->set('moders','best','view/');
        $widget->set('users','best','view');

        $template = View::init();
        $template->set('title','Добро пожаловать');
        $template->set('description', '');
        $template->set('keywords', '');

        if(Auth::checkAuth()){
            $template->set('user', $template->load('widget/auth_menu'));
            $template->set('who', Auth::checkAuth('name'));
            $template->set('role', '('.Auth::checkAuth('role').')');
            $template->set('user_menu',"<a href='/auth/logout'>Выход</a>");
        }
    }
}