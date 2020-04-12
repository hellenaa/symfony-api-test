<?php


namespace App\Controller;


use App\Entity\Partner;
use App\Form\PartnerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PartnerAdminController extends AbstractController
{

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/api/admin/partner", name="partner_post", methods={"POST"})
     */
    public function postPartnerAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $partner = new Partner();

        $form = $this->createForm(PartnerType::class, $partner);

        $form->handleRequest($request);

        if($form->isValid()) {

            $em->persist($partner);
            $em->flush();

            return new JsonResponse([$partner->getId(), $partner->getFilepath(), $partner->getUrl()]);

        }else {

            $errors = $form->getErrors(true, true);
            $errorCollection = array();

            foreach($errors as $error){
                $errorCollection[] = $error->getMessage();
            }

            $errorCollection = array('status' => 404, 'errorMsg' => 'Bad Request', 'errorReport' => $errorCollection);

            return new JsonResponse($errorCollection);
        }

    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/api/admin/partner/{id}", name="partner_put", methods={"POST"})
     */
    public function putPartnerAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();

        $partner = $em
            ->getRepository(Partner::class)
            ->find($id);

        $form = $this->createForm(PartnerType::class, $partner);

        $form->handleRequest($request);

        if($form->isValid()) {

            $em->persist($partner);
            $em->flush();

            return new JsonResponse([$partner->getId(), $partner->getFilepath(), $partner->getUrl()]);

        }else {

            $errors = $form->getErrors(true, true);
            $errorCollection = array();

            foreach($errors as $error){
                $errorCollection[] = $error->getMessage();
            }

            $errorCollection = array('status' => 404, 'errorMsg' => 'Bad Request', 'errorReport' => $errorCollection);

            return new JsonResponse($errorCollection);
        }

    }

    /**
     * @Route("/api/admin/partner/{id}", name="partner_delete", methods={"DELETE"})
     * @param Request $request
     * @return Partner|JsonResponse
     */
    public function deleteAction($id) {


        $em = $this->getDoctrine()->getManager();
        $partner = $em
            ->getRepository(Partner::class)
            ->find($id);
        if($partner) {
            $em->remove($partner);
            $em->flush();

            return new JsonResponse(["success" => "Text successfully deleted."]);
        }else{
            return new JsonResponse(["error" => "Text not found."]);
        }

    }
}