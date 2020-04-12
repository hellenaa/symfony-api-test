<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 03-Nov-19
 * Time: 1:20 AM
 */

namespace App\Entity;


interface PublishedDateEntityInterface
{
    public function setPublished(\DateTimeInterface $published): PublishedDateEntityInterface;

}