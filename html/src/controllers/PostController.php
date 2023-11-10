<?php
namespace Src\controllers;
use Src\models\Post;

class PostController extends BaseController
{
    private $post;

    public function addPost()
    {
        $post = new Post();
        if (!empty($_POST) && isset($_POST['title']) && isset($_POST['text']) && !empty($_POST['title']) && !empty($_POST['text'])){
            $post->title = $_POST['title'];
            $post->text = $_POST['text'];
            $post->id_user = $_SESSION['id_user'];

            if($_FILES['img']['size'] != 0){
                $post->img = base64_encode(file_get_contents($_FILES['img']['tmp_name']));
            }
            $post->savePost();
        }
        return $this->view->render(VIEW_DIR . '/blog.php', ['posts' => $post->get20Posts(), 'user' => $this->user]);
    }

        public function getPosts(){
            $post = new Post();
            $id_user = $_GET['id_user'] ?? null;
            header('Content-type: application/json');
            return json_encode($post->get20Posts($id_user));
        }

        public function delPost()
        {
            $post = new Post();
            if (!empty($_POST)){
                $post->delPost($_POST['id_post']);
            }
            return $this->view->render(VIEW_DIR . '/blog.php', ['posts' => $post->get20Posts(), 'user' => $this->user]);

        }
    
}
?>
