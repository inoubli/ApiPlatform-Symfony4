<?php
/**
 * Created by PhpStorm.
 * User: inoub
 * Date: 17/03/2019
 * Time: 16:51
 */

namespace App\Entity;


interface PublishedDateEntityInterface
{
    public function setPublished(\DateTimeInterface $published): PublishedDateEntityInterface;
}