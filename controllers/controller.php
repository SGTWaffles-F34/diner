<?php
/*
328/diner/controllers/controller.php
*/

class Controller { // -> in PHP is == to . in Java
    private $_f3; //fatFree object

    function __construct($f3){
        $this->_f3 = $f3;
    }

    function home(){
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function order(){
        //If the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Move orderForm1 data from POST to SESSION
            var_dump ($_POST);

            //Get the data from the post array
            $food = $_POST['food'];
            $this->_f3->set('userFood', $food);

            $meal = "";
            if(isset($_POST['meal'])){
                $meal = $_POST['meal'];
            }

            //add the users meal to the hive
            $this->_f3->set('userMeal', $meal);

            //If data is valid
            if (Validation::validFood($food)) {

                //create new order object
                $order = new Order();

                //add the food to the order
                $order->setFood($food);

                //Store it in the session array
                $_SESSION['order'] = $order;
            }
            //Data is not valid -> store an error message
            else {
                $this->_f3->set('errors["food"]', 'Please enter a food at least 2 characters');
            }
            if(Validation::validMeal($meal)){
                $_SESSION['order']->setMeal($meal);
            }
            //data is notvalid
            else {
                $this->_f3->set('errors["meal"]', 'Meal selection is invalid');
            }

            //redirect to order2 route if there are no errors
            if (empty($this->_f3->get('errors'))){
                header('location: order2');
            }
        }

        //Add meal data to hive
        $this->_f3->set('meals', DataLayer::getMeals());

        $view = new Template();
        echo $view->render('views/orderForm1.html');
    }

    function order2(){
        //Add condiment data to hive
        $this->_f3->set('condiments', DataLayer::getCondiments());

        if($_SERVER['REQUEST_METHOD'] == 'POST') { // if the form has been submitted

            var_dump($_POST);
            $conds = "";
            if (empty($_POST['conds'])) {
                $conds = "none selected";
            } else {
                $conds = implode(", ", $_POST['conds']);
            }
            $_SESSION['order']->setCondiments($conds);
            header("location: summary");
        }

        $view = new Template();
        echo $view->render('views/orderForm2.html');
    }

    function summary(){
//        echo "<pre>";    FOR TESTING
//        var_dump($_SESSION);
//        echo "</pre>";

        $view = new Template();
        echo $view->render('views/orderSummary.html');

        //Clear the session array
        session_destroy();
    }

} // END OF CLASS