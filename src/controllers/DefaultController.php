<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function index()
    {
        $this->render('dashboard');
    }

    public function login()
    {
        $this->render('login');
    }
}