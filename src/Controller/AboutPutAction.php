<?php


namespace App\Controller;

use App\Entity\About;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

//no need, already write action in AboutAdminController
class AboutPutAction
{
//    private $entityManager;
//
//    public function __construct(EntityManagerInterface $entityManager)
//    {
//        $this->entityManager = $entityManager;
//    }
//
//    public function __invoke(Request $request, $id)
//    {
//
//
//        $about = $this->entityManager
//            ->getRepository(About::class)
//            ->find($id);
//
//        $about->setAbout($request->getContent());
//
//        $this->entityManager->persist($about);
//        $this->entityManager->flush();
//
//        return $about;
//    }
}