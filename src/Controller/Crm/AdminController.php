<?php

namespace App\Controller\Crm;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
  public function index()
  {
    return $this->render('crm/admin/index.html.twig');
  }
  
}