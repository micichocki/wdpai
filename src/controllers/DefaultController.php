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
}
