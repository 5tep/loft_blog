<?php
namespace Src\controllers;
use Src\models\User;
use Src\models\Post;

class Login extends BaseController
{
    public function index()
    {
        if (isset($_SESSION['id_user'])) {
            $posts = new Post();
            return $this->view->render(VIEW_DIR . '/blog.php', ['posts' => $posts->get20Posts(), 'user' => $this->user]);
        }
        return $this->view->render(VIEW_DIR . '/login.php');
    }

    public function login()
    {
        if (!empty($_POST)){
            $user = new User();
            $posts = new Post();
            $user->email = $_POST['email'];
            $user->password = $_POST['password'];
           
            if ($user->autorization()){
                $_SESSION['id_user'] = $user->id_user;
                $this->setUser($user);
                return $this->view->render(VIEW_DIR . '/blog.php', ['posts' => $posts->get20Posts(), 'user' => $user]);
            } 
            else  return $this->view->render(VIEW_DIR . '/login.php', ['error' => $user->error]);
        } 
        else  return $this->index();
    }
    public function logout()
    {
        session_unset();
        return $this->index();
    }

}
?>