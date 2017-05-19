<?php

namespace Yoh\JasperReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('YohJasperReportBundle:Default:index.html.twig');
    }
}
