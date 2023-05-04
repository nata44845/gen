<?php

namespace App\Controller\Crm;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
  public function index()
  {
    return $this->render('crm/default/index.html.twig');
  }
  
}