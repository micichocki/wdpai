<?php

require_once 'AppController.php';
require_once 'src/models/Dog.php';

class DefaultController extends AppController
{
    public function index()
    {
        if ($this->isGet()) {
            $this->render('index');
        }else {
            die("405 METHOD NOT ALLOWED");
        }
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

        if ($this->isGet()) {
            $this->render('dashboard');
        }else {
            die("405 METHOD NOT ALLOWED");
        }
    }

    public function profile()
    {
        if ($this->isGet()) {
            $this->render('profile');
        }else {
            die("405 METHOD NOT ALLOWED");
        }
    }
}
