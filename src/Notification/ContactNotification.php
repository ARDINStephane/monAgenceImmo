<?php

namespace App\Notification;


use App\Entity\Contact;
use Twig\Environment;

/**
 * Class ContactNotification
 * @package App\Notification
 */
class ContactNotification
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $renderer;

    /**
     * ContactNotification constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $renderer
     */
    public function __construct(
        \Swift_Mailer $mailer,
        Environment $renderer
    )
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    /**
     * @param Contact $contact
     */
    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message('Agence:' . $contact->getProperty()->getTitle()))
            ->setFrom('noreply@agence.fr')
            ->setTo('contact@agnece.fr')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('email/contact.html.twig', [
                'contact' => $contact
            ]), 'text/html');
        $this->mailer->send($message);
    }
}