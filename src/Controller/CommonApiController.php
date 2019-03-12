<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Service\Utils\SanitizeClass;


class CommonApiController extends FOSRestController
{
    /** @var SanitizeClass */
    protected $sanitizeClass;

    public function __construct()
    {
        $this->sanitizeClass = new SanitizeClass();
    }

    public function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }
}