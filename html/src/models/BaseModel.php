<?php  
namespace Src\models;
use PDO;
class BaseModel
{
    protected $pdo;
    function __construct() 
    {
        $host = 'localhost';
        $db  = 'loftschool';
        $user = 'mysqladmin';
        $pass = 'cheeg9aiH7fu';
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new PDO($dsn, $user, $pass, $opt);

    }
}
?>