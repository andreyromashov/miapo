<?php

require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));


$app->get('/', function() use($app) {

  return "Hello World!";
});

$app->post('/bot', function() use($app) {
	$data = json_decode(file_get_contents('php://input'));

	if( !$data )
		return 'No data';


	switch( $data->type )
	{
		case 'confirmation':
		return getenv('vk_confirmatiom_code');
		break;




		case 'message_new':

			$request_params = array(
				'random_id' => rand(1, 2147483647),
				'peer_id' => $data->object->message->from_id,
				'message'=> 'Привет, меня зовут Билли. Я почти готов к работе!',
				'access_token'=> getenv("VK_TOKEN"),
				'v'=> '5.103'
			);

		file_get_contents('https://api.vk.com/method/messages.send?'. http_build_query($request_params));

		return 'ok';

		break;
	}




  return "no2" ;
});

$app->run();
