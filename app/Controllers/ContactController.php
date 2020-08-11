<?php


namespace App\Controllers;


use Laminas\Diactoros\ServerRequest;

class ContactController extends BaseController
{
    public function index(){
        return $this->renderHTML('contact/index.twig');
    }
    public function send(serverRequest $request){
        var_dump($request->getParsedBody());
    }
}