<?php
session_start();
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload
require_once('vendor/autoload.php');
require_once('model/validation-functions.php');
$sound = "cluck";
$_SESSION['sound'] = $sound;
//create an instance of the Base class
$f3 = Base::instance();

//Turn on fat free error reporting
$f3->set('DEBUG', 3);


//$colors = array('pink', 'green', 'blue');
$f3->set('colors', array('pink', 'green', 'blue'));

//


////Define route
$f3->route('GET /',
    function() {
        echo '<h1>My Pets</h1>';
        echo '<a href="order">Order a Pet</a>';
        //$view = new View;
        //echo $view->render('views/home-page.html');
    }
);

//define a route with multiple parameter
$f3->route('GET /@animal', function($f3,$params){
//    print_r($params);
    $validAnimals=['chicken','dog','bird','lizard','pig'];
    $animal=$params['animal'];

    //check validity
    if(!in_array($animal,$validAnimals)){
        $f3->error(404);
    }else{
        switch($animal){
            case 'chicken':
                $sound="Cluck!";
                break;
            case 'dog':
                $sound="Woof!";
                break;
            case 'bird':
                $sound="Chirp!";
                break;
            case 'lizard':
                $sound="Hisss!";
                break;
            case 'pig':
                $sound="Oink!";

        }
        //echo $animal."".$sound;
        $_SESSION['sound'] = $sound;
    }

    ;
});

//define route order

	$f3->route('GET|POST /order',
		function($f3)
		{
			$_SESSION = array();
			if (isset($_POST['animal']))
			{
				$animal = $_POST['animal'];
				if (validText($animal))
				{
					$_SESSION['animal'] = $animal;
					$f3->reroute('/form2');
				}
				else
				{
					$f3->set("errors['animal']", "Please enter an animal.");
				}
			}
			$template = new Template();
			echo $template->render('views/form1.html');
		});

$f3->route('GET|POST /form2',
    function($f3) {


        if(isset($_POST['color'])){
            $color = ($_POST['color']);
            if(validColor($color)) {
                $_SESSION['color'] = $color;
                $f3->reroute('/results');
            }else{
                $f3->set("error['color']", "Please select a color");
              }
            }

        $template = new Template();

        echo $template->render('views/form2.html');
    });

$f3->route('GET|POST /results',
    function($f3) {

        //Create global variables
        $f3->set('animal', $_SESSION['animal']);
        $f3->set('color', $_SESSION['color']);
        $f3->set('sound', $_SESSION['sound']);
        //load a page using a Template
        $template = new Template();
        //print_r($_SESSION);
        echo $template->render('views/results.html');
    });

//Run fat free
$f3->run();