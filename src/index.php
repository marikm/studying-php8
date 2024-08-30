<?php 
    require_once __DIR__ . '/../vendor/autoload.php';

    use App\Utils\Routes;
    use App\Utils\TwigUtils;

    
    $routes = new Routes(); // cria novo objeto Routes
   
    if(class_exists($routes->controller)) { // existe controller para esse objeto?
        $controllerInstance = new $routes->controller; // atribui a controllerInstance o array controller do routes 
    }
    
    $data = $controllerInstance->index(); // retorna o conteudo do controller
  
    $twig = new TwigUtils();

    echo $twig->render($routes->template, [
        'routes' => $routes,
        'data' => $data,
    ]);
