<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 03-Nov-19
 * Time: 1:08 AM
 */

namespace App\Entity;


use Symfony\Component\Security\Core\User\UserInterface;

interface AuthoredEntityInterface
{
    public function setAuthor(UserInterface $user): AuthoredEntityInterface;

}