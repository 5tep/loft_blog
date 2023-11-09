<?php
namespace Src\models;

class Post extends BaseModel
{
    public $date_event;
    public $title;
    public $text;
    public $id_user;
    public $img;

    public function savePost()
    {
        $stmt = $this->pdo->prepare('INSERT INTO posts (title, text, img, id_user) VALUES (:title, :text, :img, :id_user)');
        return $this->data = $stmt->execute([$this->title, $this->text, $this->img, $_SESSION['id_user']]);
    }
    
    public function get20Posts($id_user = null)
    {
        $addstring = (isset($id_user) && is_int($id_user)) ? 'and id_user=' . $id_user : '';
        $stmt = $this->pdo->prepare("SELECT id, name, date_event, title, text, img  FROM posts, users where users.id_user = posts.id_user $addstring order by date_event DESC LIMIT 20");
        $stmt->execute();
        $res = $stmt->fetch();
        $posts = [];
        while ($res){
            $posts[] = ['id' =>  $res['id'], 'name' => $res['name'], 'date_event' => $res['date_event'], 'title' => $res['title'], 'text' => $res['text'], 'img' => $res['img']];
            $res = $stmt->fetch();
        }
        return $posts;
    }

    public function delPost($id)
    {
        echo $id;
        $stmt = $this->pdo->prepare('DELETE FROM posts WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
?>