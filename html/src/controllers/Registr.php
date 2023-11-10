<?php
namespace Src\controllers;
use Src\models\User;

class Registr extends BaseController
{
    public function index()
    {
       return $this->view->renderTwig('/auth.php', ['type' => 'TWIG']);
    }

    public function auth()
    {
        if (!empty($_POST)){
            
            $user = new User();
            $user->email = $_POST['email'];
            $user->password = $_POST['password'];
            $user->name = $_POST['name'];
            $user->confirm_password = $_POST['confirm_password'];
            if($user->registration()) return $this->view->render(VIEW_DIR . '/login.php', ['info' => 'Вы успешно авторизировались! Войдите!']);
                else  return $this->view->renderTwig('/auth.php', ['type' => 'TWIG', 'error' => $user->error]);


        }
        return $this->index();
    }
}
?>
