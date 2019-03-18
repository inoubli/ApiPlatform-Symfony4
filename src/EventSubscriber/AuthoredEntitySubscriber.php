<?php
/**
 * Created by PhpStorm.
 * User: inoub
 * Date: 15/03/2019
 * Time: 21:24
 */

namespace App\EventSubscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\AuthoredEntityInterface;
use App\Entity\BlogPost;
use App\Entity\Comment;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuthoredEntitySubscriber implements EventSubscriberInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage){
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['getAuthenticatedUser', EventPriorities::PRE_WRITE]
        ];
    }

    public function  getAuthenticatedUser(GetResponseForControllerResultEvent $event){
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        $author = $this->tokenStorage->getToken()->getUser();

//        if (!$entity instanceof BlogPost && !$entity instanceof Comment || Request::METHOD_POST !== $method){
        if (!$entity instanceof AuthoredEntityInterface || Request::METHOD_POST !== $method){
            return ;
        }



        $entity->setAuthor($author);
    }
}