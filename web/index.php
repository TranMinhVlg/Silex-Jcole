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
    
//  case 'preppod.monsite.com':
//    $config['debug'] = true;
//    $config['db_host'] = '';
//    $config['db_name'] = '';
//    $config['db_user'] = '';
//    $config['db_pass'] = '';
//    break;
    
//  case 'monsite.com':
//    $config['debug'] = false;
//    $config['db_host'] = '';
//    $config['db_name'] = '';
//    $config['db_user'] = '';
//    $config['db_pass'] = '';
//    break;
    
}
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;





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
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\SwiftmailerServiceProvider(), array(
  'swiftmailer.options' => array(
    'host'       => 'smtp.gmail.com',
    'port'       => 465,
    'username'   => 'smtp.hetic.p2020@gmail.com',
    'password'   => 'heticp2020smtp',
    'encryption' => 'ssl',
    'auth_mode'  => 'login'
  )
));

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


$app->match('/contact', function(Request $request) use($app)
            {
              $data = array();

              $formBuilder = $app['form.factory']->createBuilder();

              $formBuilder->setMethod('post');
              $formBuilder->setAction($app['url_generator']->generate('contact'));

              $formBuilder->add(
                'name',
                TextType::class,
                array(
                  'label'=> 'Your name',
                  'trim'=> true,
                  'required'=>true,
                  'constraints' => array(
                    new Length(
                      array(
                        'max' => 20,
                        'min' => 3,
                        'maxMessage' => 'Too long',
                        'minMessage' => 'Too short',

                      )
                    )
                  )
                )
              );

              $formBuilder->add(
                'email',
                EmailType::class,
                array(
                  'label'=> 'Your email',
                  'trim'=> true,
                  'required'=>true
                )
              );

              $formBuilder->add(
                'subject',
                ChoiceType::class,
                array(
                  'label'=> 'Subject',
                  'required'=> true,
                  'choices'=> array(
                    'Informations'=>'Informations',
                    'Proposition'=>'Proposition',
                    'Other'=>'Other',
                  )
                )
              );

              $formBuilder->add(
                'message',
                TextareaType::class,
                array(
                  'label'=>'Your message',
                  'trim'=>true,
                  'required'=>true
                )
              );


              $formBuilder->add('submit', Symfony\Component\Form\Extension\Core\Type\SubmitType::class);

              $form = $formBuilder->getForm();

              $form->handleRequest($request);

              if($form->isSubmitted() && $form->isValid())
              {
                $formData = $form ->getData();

                $message = new \Swift_Message();
                $message->setSubject($formData['subject']);
                $message->setFrom($formData['email']);
                $message->setTo(array(''));
                $message->setBody($formData['message']);

                $app['mailer']->send($message);
                
                return $app->redirect($app['url_generator']->generate('contact'));


              }

              $data['contact_form'] = $form->createView();

              return $app['twig']->render('pages/contact.twig', $data);
            })
  ->bind('contact');

$app->get('/random', function() use ($app)
          {
            $randomId = rand(1,811);
            $url = $app['url_generator']->generate('pokemon',array('id' => $randomId));
            return $app->redirect($url);
          });

$app -> error(function() use($app)
              {
                $data = array();
                $data['title'] = 'Error';
                
                return $app['twig']->render('pages/error.twig',$data);
              });

// Run Silex
$app->run();