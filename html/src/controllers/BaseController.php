<?php
namespace Src\controllers;

class BaseController
{
    
    protected $view;
    protected $user;

    public function setView($view)
    {
        $this->view = $view;
    }    
    
    public function setUser($user)
    {
        $this->user = $user;
    }
}
?>