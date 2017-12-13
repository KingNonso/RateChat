<?php

class Errata extends Controller {

    function __construct() {
        parent::__construct();
        
    }

    function index(){
        $this->view->title = "Error ";
        $this->view->msg = "This page doesn't exist";
        $this->view->render('error/index','none');
        exit();

    }


}