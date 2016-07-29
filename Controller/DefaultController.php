<?php

namespace YohKenn\JasperReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('YohKennJasperReportBundle:Default:index.html.twig');
    }
}
