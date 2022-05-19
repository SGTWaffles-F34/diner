<?php

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require the necessary files
require_once('vendor/autoload.php');

//Start a session
session_start();

//Create an instance of the Base class
$f3 = Base::instance();

//create an instance of the controller class
$con = new Controller($f3);//hand it to our controller class to create an instance

//Define a default route
$f3->route('GET /', function() {
    $GLOBALS['con']->home(); //$GLOBALS gives access to global variables inside a php method
});

//Define a breakfast route
$f3->route('GET /breakfast', function() {
    //echo "Breakfast page";

    $view = new Template();
    echo $view->render('views/breakfast-menu.html');
});

//Define a lunch route
$f3->route('GET /lunch', function() {
    //echo "Breakfast page";

    $view = new Template();
    echo $view->render('views/lunch.html');
});

//Define a lunch route
$f3->route('GET /breakfast/brunch', function() {
    //echo "Breakfast page";

    $view = new Template();
    echo $view->render('views/breakfast-menu.html');
});

//Define an order route
$f3->route('GET|POST /order', function($f3) {

    $GLOBALS['con']->order();

});

//Define an order2 route
$f3->route('GET|POST /order2', function($f3) {

    $GLOBALS['con']->order2();
});

//Define a summary route -> orderSummary.html
$f3->route('GET|POST /summary', function() {

    $GLOBALS['con']->summary();
});

//Run fat-free
$f3->run();