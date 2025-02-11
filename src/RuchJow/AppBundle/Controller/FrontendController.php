<?php

namespace RuchJow\AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FrontendController
 *
 * @package RuchJow\AppBundle\Controller
 *
 * @Route("/")
 */
class FrontendController extends ModelController
{
    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/", name="frontend_homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $referendumDate = new \DateTime('2015-09-06');
        $today = new \DateTime();

        if ($today > new \DateTime('2015-09-05 00:00:00')) {
            $daysToReferendum = 1;
            if ($today > new \DateTime('2015-09-06 00:00:00')) {
                $daysToReferendum = 0;
            }
            if ($today > new \DateTime('2015-09-06 22:01:00')) {
                $daysToReferendum = -1;
            }
        } else {
            $interval = $today->diff($referendumDate);
            $daysToReferendum=$interval->days+1;
        }

        // $_GET parameters
        if ($request->query->count()) {
            if ($url = $request->query->get('url')) {

                return $this->redirect($this->generateUrl('frontend_homepage') . '#' . $url, 301);
            };
        }

        return array('daysToReferendum'=>$daysToReferendum);
    }
}
