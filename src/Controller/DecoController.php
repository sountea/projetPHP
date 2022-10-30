<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Decorum;
use App\Repository\DecorumRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\Type\DecoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class DecoController extends AbstractController
{
    #[Route('/deco/new', name: 'app_Deco')]
    public function index(ManagerRegistry $doctrine,Request $request): Response
    {


        $entityManager=$doctrine->getManager();
        $deco =new Decorum;
  
        $form = $this->createForm(DecoType::class,$deco);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
        $deco = $form->getData();
        $entityManager->persist($deco);
        $entityManager->flush();
        return $this->redirectToRoute('homedeco');
               }



        return $this->renderForm('deco/index.html.twig', [
            'controller_name' => 'DecoController', 'form' => $form
        ]);
    }


    #[Route('', name: 'homedeco')]
    public function homepage(DecorumRepository $deco ): Response
    {

        $all= $deco->findAll();


        return $this->render('deco/home.html.twig', [
            'controller_name' => 'DecoController', 'all'=>$all
        ]);
    }



    #[Route('/decoDetail/{id}', name: 'homedetail')]
    public function detail(DecorumRepository $deco ,Decorum $comparaison): Response
    {
        $monId=$comparaison->getId();
        $maMarque=$comparaison->getMarque();

        $identique=$deco->findAllUnique($monId,$maMarque);
        
        


        return $this->render('deco/detail.html.twig', [
            'controller_name' => 'DecoController', 'comparaison'=>$identique,'madeco'=>$comparaison
        ]);
    }
    #[Route('/admin', name: 'homeadmin')]
    #[IsGranted('ROLE_USER')]
    public function admin(DecorumRepository $deco  ): Response
    {
        $monadmin=$deco->findAll();

        


        return $this->render('deco/admin.html.twig', [
            'controller_name' => 'DecoController', 'monadmin'=>$monadmin
        ]);
    }
    #[Route('/deco/{id}/update', name: 'homeupdate')]
    public function upadate(ManagerRegistry $doctrine,Request $request,Decorum $deco): Response
    
{
    $entityManager=$doctrine->getManager();

    $form = $this->createForm(DecoType::class,$deco);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
        $deco ->getId();
        $entityManager->flush();
        return $this->redirectToRoute('homeadmin');
               } 

    return $this->render('deco/update.html.twig', [
        'form' => $form->createView()
    ]);
}
#[Route('/deco/{id}/delete', name: 'homedelete')]
public function delete(Decorum $deco ,int $id,ManagerRegistry $doctrine  ): Response
{
   
    $entityManager =$doctrine->getManager();
    //$vegetable =$vegetableRepository;
    //$vegetable =$vegetableRepository->find($id);

   
   if(!$deco){
    throw $this->createNotFoundException('No vegetable found for id' .$deco->getId());
   }
   $entityManager->remove($deco);
   $entityManager->flush();
    return $this ->redirectToRoute('homeadmin');
}


}
