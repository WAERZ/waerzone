<?php
class Widget implements Access{
    private function test($action){
        $template = View::init();
        $template->set('widget',$template->load('widget/test'));
        $template->set('testcont', '<br>Это блок test');
        $template->set('testact', "<br>Вам можно: $action");
    }

    private function best($action){
        $template = View::init();
        $template->set('widgetForAdmin',$template->load('widget/best'));
        $template->set('bestcont', '<br>Это блок best');
        $template->set('bestact', "<br>Вам можно: $action");
    }

    /**
     * @param $group
     * @param $future
     * @param $action
     */
    public function set($group, $future, $action){
        if(Auth::checkAuth('role') == $group){
            if(method_exists(__CLASS__,$future)){
                $this->$future($action);
            }
        }
    }

}