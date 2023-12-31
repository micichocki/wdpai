<?php

require_once 'AppController.php';

class ErrorController extends AppController
{

    public function error404()
    {
        $this->render('error404');
    }
    public function error401()
    {
        $this->render('error401');
    }
    public function error()
    {
        $this->render('error');
    }
}
