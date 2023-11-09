<?php
    include 'vendor/autoload.php';
    include 'base/Config.php';

    use Base\Route;
    use Src\controllers\NotFound;
    use Src\controllers\Login;
    use Src\controllers\Registr;
    use Src\controllers\PostController;
    use Src\models\User;
    use Base\Application;

    $user = new User();
    $route = new Route();
    $route->addRoute('/', Login::class, 'index');
    $route->addRoute('/main', Login::class, 'index');
    $route->addRoute('/login', Login::class, 'login');
    $route->addRoute('/registration', Registr::class, 'index');
    $route->addRoute('/auth', Registr::class, 'auth');
    $route->addRoute('/notfound', NotFound::class, 'index');
    $route->addRoute('/logout', Login::class, 'logout');
    
    if(isset($_SESSION['id_user'])){
        $user->get($_SESSION['id_user']);
        $route->addRoute('/add', PostController::class, 'addPost');
        $route->addRoute('/api/getposts', PostController::class, 'getPosts');
        if ($user->isAdmin()) $route->addRoute('/admin/delpost', PostController::class, 'delPost');
    }

    $app = new Application($route, $user);
    $app->run();

?>
