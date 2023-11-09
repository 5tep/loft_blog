<?php
namespace Src\models;

class User extends BaseModel
{
    public $name;
    public $email;
    public $dateReg;
    public $password;
    public $confirm_password;
    public $id_user;
    public $is_auth = false;
    public $error = '';

/*    public function __construct($email = null)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $res = $stmt->fetch();
        if(isset($res)){
            $this->name = $res['name'];
            $this->email = $res['email'];
            $this->dateReg = $res['dateReg'];
            $this->password = $res['password'];
            $this->id_user = $res['id_user'];
        }
    }
*/
    // Регистрация    
    public function save()
    {
        if(!$this->check()) return false;
        $stmt = $this->pdo->prepare("SELECT id_user FROM users WHERE email = :email");
        $stmt->execute(['email' => $this->email]);
        if ($stmt->fetch()){
           $this->error = 'Пользователь с таким email-ом уже существует';  return false;
        }
        $stmt = $this->pdo->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        $this->data = $stmt->execute([$this->name, $this->email, password_hash($this->password, PASSWORD_DEFAULT)]);
        return true;
    }


    public function get($id_user)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id_user = :id_user");
        $stmt->execute(['id_user' => $id_user]);
        $res = $stmt->fetch();
        if(isset($res)){
            $this->name = $res['name'];
            $this->email = $res['email'];
            $this->dateReg = $res['dateReg'];
            $this->password = $res['password'];
            $this->id_user = $res['id_user'];
        } else return false;
        return true;   
    }

    private function check()
    {
        // check name
        if (strlen($this->name) < 2) {$this->error = 'Недостаточная длина имени!'; return false;}
        if (is_int($this->name) ) {$this->error = 'Имя не должно состоять из цифр'; return false;}
        // check email
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){$this->error = 'Неправильно введен email'; return false;}
        // check password
        if(strlen($this->password) < 4) {$this->error = 'Длина пароля должна быть не меньше 4 символов'; return false;}
        if($this->password != $this->confirm_password) {$this->error = 'Не совподают пароли'; return false;}
        return true;
    }

    public function autorization()
    {
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){$this->error = 'Неправильно введен email'; return false;}
        // check password
        if(strlen($this->password) < 4) {$this->error = 'Длина пароля должна быть не меньше 4 символов'; return false;}

        $stmt = $this->pdo->prepare("SELECT name, email, dateReg, password, id_user FROM users WHERE email = :email");
        $stmt->execute(['email' => $this->email]);
        $res = $stmt->fetch();

        //echo password_hash($this->password, PASSWORD_DEFAULT);
        if(!isset($res['password']) || !password_verify($this->password, $res['password'])){ $this->error = 'Пользователь с таким email-ом и паролем не найден :('; return false;}

        $this->name = $res['name'];
        $this->email = $res['email'];
        $this->dateReg = $res['dateReg'];
        $this->password = $res['password'];
        $this->id_user = $res['id_user'];
        return true;
    }

    public function registration()
    {
       if ($this->check()) return $this->save();
       return false;
    }

    public function isAdmin()
    {
        return in_array($this->id_user, ADMINS);
    }

}
 // echo "model users";
?>