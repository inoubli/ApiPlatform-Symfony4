<?php
/**
 * Created by PhpStorm.
 * User: inoub
 * Date: 17/03/2019
 * Time: 16:43
 */

namespace App\Entity;


use Symfony\Component\Security\Core\User\UserInterface;

interface AuthoredEntityInterface
{
    public function setAuthor(UserInterface $user): AuthoredEntityInterface ;

}