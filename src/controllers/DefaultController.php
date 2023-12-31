<?php

require_once 'AppController.php';

class DefaultController extends AppController
{
    public function index()
    {
        if ($this->isGet()) {
            $this->render('index');
        } else {
            throw new Exception("405");
        }
    }

    public function login()
    {
        if ($this->isGet()) {
            $this->render('login');
        }
        if ($this->isPost()) {
            
        }
    }
    public function register()
    {
        if ($this->isGet()) {
            $this->render('register');
        }
        if ($this->isPost()) {

        }
    }

    public function dashboard()
    {

        if ($this->isGet()) {
            $this->render('dashboard');
        } else {
            throw new Exception("405");
        }
    }

    public function profile()
    {
        if ($this->isGet()) {
            $this->render('profile');
        } else {
            throw new Exception("405");
        }
    }
}
