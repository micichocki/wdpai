<?php

require_once 'AppController.php';
require_once 'src/models/Dog.php';

class DefaultController extends AppController
{
    public function index()
    {
        $this->render('index');
    }

    public function login()
    {
        if ($this->isGet()) {
            $this->render('login');
        }
        if ($this->isPost()) {
            die("FORM SEND");
        }
    }
    public function register()
    {
        if ($this->isGet()) {
            $this->render('register');
        }
        if ($this->isPost()) {
            die("FORM SEND");
        }
    }

    public function dashboard()
    {
        $dogs = array(
            new Dog("Buddy", "Golden Retriever", "Golden", "buddy.jpg"),
            new Dog("Max", "German Shepherd", "Black and Tan", "max.jpg"),
            new Dog("Bailey", "Labrador Retriever", "Yellow", "bailey.jpg"),
            new Dog("Charlie", "Bulldog", "Brindle", "charlie.jpg"),
            new Dog("Lucy", "Beagle", "Tri-color", "lucy.jpg")
        );
        var_dump($dogs);
        $this->render('dashboard', ["dogs" => $dogs]);
    }
}
