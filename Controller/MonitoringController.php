<?php

/*
 * @copyright   2016 Mautic, Inc. All rights reserved
 * @author      Mautic, Inc
 *
 * @link        https://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticMaestroBundle\Controller;

use Mautic\CoreBundle\Controller\FormController;
use Mautic\LeadBundle\Controller\EntityContactsTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use DateTime;

/**
 * Class MonitoringController.
 */
class MonitoringController extends FormController
{
    use EntityContactsTrait;

    /*
     * @param int $page
     */
    public function indexAction($page = 1)
    {
        $to = new DateTime("");
        $from = new DateTime("2017-11-15 00:00:00");

        return new JsonResponse($this->getModel("maestro")->getData($from,$to));
    }
}
