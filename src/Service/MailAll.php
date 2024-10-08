<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use DateTime;

class MailAll
{
    public $mailer;
    public $repo;

    public function __construct(MailerInterface $mailer, UserRepository $repo)
    {
        $this->mailer = $mailer;
        $this->repo = $repo;
    }
    public function NotifyUsers(string $objet, DateTime $fin, bool $suivi, bool $repetitive)
    {
        $users = $this->repo->findAll();
        $suiv;
        $rep;
        if($suivi)
        $suiv = "avec suivi";
        else $suiv = "sans suivi";
        if($repetitive)
        $rep = "repetitive";
        else $rep = "non repetitive";
        foreach($users as $user){
            $to = $user->getEmail();
            $email = (new Email())
            ->from('atct@app.com')
            ->to($to)
            ->subject('Notification du contrat: '. $objet)
            ->html("Le contrat : ". $objet . "<br> Prendra fin le ". $fin->format('Y-m-d') ." . <br> Ce contrat est " . $rep . " et " . $suiv .".");

            $this->mailer->send($email);
        }
    }
}