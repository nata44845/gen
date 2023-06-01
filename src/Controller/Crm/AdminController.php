<?php

namespace App\Controller\Crm;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Crm\Admin;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\Crm\AdminType;

class AdminController extends AbstractController
{
  private $doctrine;

  public function __construct(ManagerRegistry $doctrine) {
    $this->doctrine = $doctrine;
  }
  public function index()
  {
    $admins = $this->doctrine->getRepository(Admin::class)->findAll();
    return $this->render('crm/admin/index.html.twig',[
      'admins' => $admins
  ]);
  }
  
  public function edit(Request $request, $id = null)
  {
    if (!$id) {
      /** @var Admin $admin */
      $admin = new Admin();
    } else {
      /** @var Admin $admin */
      $admin = $this->doctrine->getRepository(Admin::class)->find($id);
    }

    $form = $this->createForm(AdminType::class, $admin);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->doctrine->getManager();
      $em->persist($admin);
      $em->flush();

      return $this->redirectToRoute('administrators');
    }
    return $this->render('crm/admin/edit.html.twig',[
      'form' => $form->createView()
    ]);
  }


}