<?php
/**
 * Created by PhpStorm.
 * User: inoub
 * Date: 14/03/2019
 * Time: 02:34
 */

namespace App\EventSubscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordHashSubscriber implements EventSubscriberInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {

        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getSubscribedEvents()
    {
       return [
           KernelEvents::VIEW => ['hashPassword', EventPriorities::PRE_WRITE]
       ];
    }

    public function  hashPassword(GetResponseForControllerResultEvent $event){
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$user instanceof User ||  !in_array($method , [Request::METHOD_POST !== $method,Request::METHOD_PUT !== $method])  ){
            return ;
        }

        //it is a User, we need to hash password herer
        $user->setPassword(
          $this->passwordEncoder->encodePassword($user, $user->getPassword())
        );
    }
}