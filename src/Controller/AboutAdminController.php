<?php


namespace App\Controller;


use App\Entity\About;
use App\Form\AboutType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AboutAdminController extends AbstractController
{
    /**
     * @Route("/api/admin/about", name="about_post", methods={"POST"})
     * @param Request $request
     * @return About|Response
     */
    public function postAction(Request $request)
    {

//        $about_table = $this->getDoctrine()->getManager()
//            ->getRepository(About::class)
//            ->findAll();
//        $id='';
//        foreach ($about_table as $about_row) {
//            $getAbouts = json_decode($about_row->getAbout());
//
//
//            foreach ($getAbouts as $key=>$about) {
//                if($key == 'text' && $about=='myau1234') {
//                    $id = $about_row->getId()->toString();
//                }
//
//            }
//        }


//       $aboutj = $about_table->getAbout();
//
//       foreach ($aboutj as $key=>$a) {
//            if($key == 'text') {
//                $aboutj[$key] = 'mm';
//            }
//       }


//        //validation here is not working with json
//        $data = json_decode($request->getContent(), true);
//        $about = new About();
//        $em = $this->getDoctrine()->getManager();
//
//
//        $about->setJson($data['json']);
//        $about->setStatus($data['status']);
//        $about->setLang($data['lang']);
////        $errors = $validator->validate($about);
////
////        if (count($errors) > 0) {
////            $err = [];
////            foreach ($errors as $error) {
////                array_push($err, $error->getMessage());
////            }
////
////            return new JsonResponse($err);
////        }
////
////        return new Response('The author is valid! Yes!');
//        $em->persist($about);
//
//        $em->persist($about);
//        $em->flush();
//        return new Response($about->getStatus());


//            //without transaction
//            $lang = $data['lang'];
//            $actual = $em
//                ->getRepository(About::class)
//                ->findOneBy(['lang' => $lang, 'status'=> 'actual']);
//
//            if($actual!=null) {
//                $actual->setStatus('old');
//                $em->flush();
//            }
//            $em->persist($form->getData());
//            $em->flush();
//
//            return $about;



        //with form validation (with json form is not working)
//        $data = $request->request->all();      //alternative option with form-data
        $data = json_decode($request->getContent(), true);

        $about = new About();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(AboutType::class, $about);

        $form->submit($data);

        if($form->isValid()) {

            $conn = $this->getDoctrine()->getConnection();
            $conn->setAutoCommit(true);
            $conn->beginTransaction();

            try{
                $actual = $em
                    ->getRepository(About::class)
                    ->findOneBy(['status'=> 'show']);

                if($actual!=null) {
                    $actual->setStatus('hide');
                    $em->flush();
                }
                $em->persist($about);
                $em->flush();

                $conn->commit();

                return new JsonResponse(["TextArm"=>$about->getTextArm(), "TextRus"=>$about->getTextRus(), "TextEng"=>$about->getTextEng()], '200');

            }catch (\Exception $ex){
                $conn->rollback();
                return new Response("Something goes wrong, try again");
            }
        }
        else{
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
     * @Route("/api/admin/about/{id}", name="about_put", methods={"PUT"})
     * @param Request $request
     * @return About|JsonResponse
     */
    public function putAction(Request $request, $id) {

        //with form validation (with json form is not working)

        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        $about = $em
            ->getRepository(About::class)
            ->find($id);


        $form = $this->createForm(AboutType::class, $about);

        $form->submit($data);
        if($form->isValid()) {

            $conn = $this->getDoctrine()->getConnection();
            $conn->setAutoCommit(true);
            $conn->beginTransaction();

            try{
                if($data['status'] == 'show') {
                    $actual = $em->getRepository(About::class)->findOneBy(['status' => 'show']);

                    if ($actual != null ) {
                        if($actual->getId() != $id) {
                            $actual->setStatus('hide');
                            $em->flush();
                        }
                    }
                }
                $em->persist($about);
                $em->flush();

                $conn->commit();

                return new JsonResponse(["TextArm" => $about->getTextArm(), "TextRus" => $about->getTextRus(), "TextEng" => $about->getTextEng()], '200');

            }catch (\Exception $ex){
                $conn->rollback();
                return new JsonResponse("Something goes wrong, try again");
            }
        }
        else{
            $errors = $form->getErrors(true, true);
            $errorCollection = array();

            foreach($errors as $error){
                $errorCollection[] = $error->getMessage();
            }

            $errorCollection = array('status' => 404, 'errorMsg' => 'Bad Request', 'errorReport' => $errorCollection);

            return new JsonResponse($errorCollection);
        }


//        $em = $this->getDoctrine()->getManager();
//        $about = $em
//            ->getRepository(About::class)
//            ->find($id);
//
//        $about->setAbout($request->getContent());
//
//        $em->persist($about);
//        $em->flush();
//
//        return $about;
    }


    /**
     * @Route("/api/admin/about/{id}", name="about_delete", methods={"DELETE"})
     * @param Request $request
     * @return About|Response
     */
    public function deleteAction($id) {


        $em = $this->getDoctrine()->getManager();
        $about = $em
            ->getRepository(About::class)
            ->find($id);
        if($about) {
            $em->remove($about);
            $em->flush();

            return new JsonResponse(["success" => "Text successfully deleted."]);
        }else{
            return new JsonResponse(["error" => "Text not found."]);
        }

    }
}