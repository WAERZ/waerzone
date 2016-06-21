<?php
class Controller {
    function __construct(){
        $widget = Widget::init();
        $widget->set('admins','test','view/add/edit/delete');
        $widget->set('moders','test','view/add');
        $widget->set('users','test','view');

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