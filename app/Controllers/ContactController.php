<?php


namespace App\Controllers;


use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\ServerRequest;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class ContactController extends BaseController
{
    public function index(){
        return $this->renderHTML('contact/index.twig');
    }
    public function send(serverRequest $request){
        $requestData = $request->getParsedBody();
        $transport = (new Swift_SmtpTransport(getenv('SMTP_HOST'), getenv('SMTP_PORT')))
                ->setUsername(getenv('SMTP_USER'))
                ->setPassword(getenv('SMTP_PASS'))
            ;

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message('Wonderful Subject'))
            ->setFrom(['contact@mail.com' => 'Contact Form'])
            ->setTo(['fermartorr01@gmail.com', 'other@domain.org' => 'A name'])
            ->setBody('Hi, you have a new message. Name: ' . $requestData['name']
            . ' Email: ' . $requestData['email'] . ' Message: ' . $requestData['message']
            )
        ;

        $result = $mailer->send($message);
        return new RedirectResponse('/cursophp2/contact');
    }
}


