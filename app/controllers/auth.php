<?php
class Auth extends Controller{

    private static $error = array();
    private static $message;

    private $user_list = array(
        'admin'     => array(
            'name'  => 'Сева',
            'password' => '0ac1dd08b9166a5a26a7f1bf54f42ced15078588', // ghbdtn
            'role' => 'admins',
        ),
        'vasya' => array(
            'name'  => 'Василий',
            'password' => '0ac1dd08b9166a5a26a7f1bf54f42ced15078588',
            'role' => 'moders',
        ),
        'user' => array(
            'name'  => 'Пользователь',
            'password' => '0ac1dd08b9166a5a26a7f1bf54f42ced15078588',
            'role' => 'users',
        ),
    );

    // salt password
    private $salt = 'dokasdji123d;.';

    /**
     *  validation form
     *  login [a-zA-Z0-9]{3,16}
     *  password [a-zA-Z0-9]{6,32}
     */
    public function actionLogin(){
        if(isset($_POST['submit'])){
            $login = Helper::cleanString($_POST['user']);
            $password = Helper::cleanString($_POST['password']);

            if(!preg_match('~^[a-zA-Z0-9]{3,16}$~', $login)){
               self::$error[] = 'Некорректный логин';
            }
            if(!preg_match('~^[a-zA-Z0-9]{6,32}$~', $password)){
               self::$error[] = 'Некорректный пароль';
            }
            if(!self::checkPass($login, $password)){
                self::$error[] = 'Неправильный логин или пароль';
            }

            if(empty(self::$error)){
                $_SESSION['user'] = array(
                    'login'  => $login,
                    'name'  => $this->user_list[$login]['name'],
                    'role'  => $this->user_list[$login]['role'],
                    'password'  => $this->user_list[$login]['password'],
                );
                setcookie('auth',session_id(), time()+3600*24*365);
                header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
            } else{
                foreach(self::$error as $key => $value){
                    self::$message = self::$message . $value.'<br>';
                }
            }
        }

        $template = View::init();
        $template->set('title', 'Авторизация');
        if(self::checkAuth()){
            $template->set('content', $template->load('/controller/auth_index'));
            $template->set('h1', 'Авторизация уже пройдена');
            $template->set('name', self::checkAuth('name'));
            $template->set('login', 'Твой логин '.self::checkAuth('login'));
            $template->set('rule', 'Уровень доступа: '.self::checkAuth('role'));
        } else {
            $template->set('content', $template->load('/controller/auth_login'));
            $template->set('h1', 'Авторизация');
        }
        $template->set('message', self::$message);

        $widget = Widget::init();
        $widget->set('admins','best','view/add/delete');
        $widget->set('moders','best','view/');
        $widget->set('users','best','view');
    }

    /**
     * @param $login
     * @param $password
     * @return bool
     * Verify Data on the user list
     */
    public function checkPass($login,$password){
        $password = sha1(sha1($password. $this->salt));
        if(array_key_exists($login, $this->user_list) && in_array($password, $this->user_list[$login])){
        return true;
        } else{
            return false;
        }
    }

    /**
     * delete all session and 'Auth' cookie
     */
    public function actionLogout(){
        if(self::checkAuth()){
            $_SESSION = array();
            session_destroy();
            setcookie(session_name(), session_id(), time()-3600*24*365);
            setcookie('auth',session_id(), time()-3600*24*365);
        }
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
    }

    /**
     * This method checks the user and return the required value of session
     * @param string $param
     * @return bool
     * @todo cookie exist
     */
    public static function checkAuth($param = 'login'){
        if (isset($_SESSION["user"])) {     // session exist
            return $_SESSION["user"][$param];    // return required value session
        } else{
            return false;
        }
    }
}
?>