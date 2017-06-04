<?php 

$config = array();
switch($_SERVER['HTTP_HOST'])
{
  case 'localhost':
  case 'localhost:8080':
  case 'localhost:8888':
    $config['debug'] = true;
    $config['db_host'] = 'localhost';
    $config['db_name'] = 'artist';
    $config['db_user'] = 'root';
    $config['db_pass'] = 'root';
    break;
    
}

// Require dependendies
$loader = require_once __DIR__.'/../vendor/autoload.php';
$loader->addPsr4('Site\\', __DIR__.'/../src/');

// Init Silex
$app = new Silex\Application();
$app['config'] = $config;
$app['debug'] = $app['config']['debug'];

// Services
$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path' => __DIR__.'/../views',
));

$app->register(new Silex\Provider\VarDumperServiceProvider());

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
  'db.options' => array (
    'driver'    => 'pdo_mysql',
    'host'      => $app['config']['db_host'],
    'dbname'    => $app['config']['db_name'],
    'user'      => $app['config']['db_user'],
    'password'  => $app['config']['db_pass'],
    'charset'   => 'utf8'
  ),
));
$app['db']->setFetchMode(PDO::FETCH_OBJ);


// Create routes
$app
  ->get('/', function() use ($app)
        {
          return $app['twig']->render('pages/home.twig');
        })
  ->bind('home');

$app
  ->get('/covers', function() use ($app)
        {
          $data = array();

          $coversModel = new Site\Models\Albums($app['db']);
          $data['covers'] = $coversModel->getAll();

          return $app['twig']->render('pages/covers.twig', $data);
        })
  ->bind('covers');

$app
  ->get('/album/{id}', function($id) use ($app)
        {
          $data = array();

          $albumModel = new Site\Models\Albums($app['db']);
          $data['album'] = $albumModel->getById($id);

          return $app['twig']->render('pages/album.twig', $data);
        })
  ->bind('album');


$app -> error(function() use($app)
              {
                $data = array();
                $data['title'] = 'Error';
                
                return $app['twig']->render('pages/error.twig',$data);
              });

// Run Silex
$app->run();