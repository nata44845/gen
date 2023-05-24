<?php

namespace App\Controller\Crm;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Crm\Admin;

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
  
}