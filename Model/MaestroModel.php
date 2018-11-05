<?php

namespace MauticPlugin\MauticMaestroBundle\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;
use DateTime;

class MaestroModel
{
    private $em;

    private $fromDate;
    private $toDate;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function setFromDate(DateTime $from)
    {
        $this->fromDate = $from;
    }

    public function setToDate(DateTime $to)
    {
        $this->toDate = $to;
    }

    public function getData(DateTime $from, DateTime $to)
    {
        $this->setFromDate($from);
        $this->setToDate($to);

        return [
            'timeframe' => "",
            'emails' => $this->getEmailData($this->em),
        ];
    }

    private function getEmailData($em)
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('title', 'title');
        $rsm->addScalarResult('sent', 'sent');
        $rsm->addScalarResult('failed', 'failed');
        $rsm->addScalarResult('opens', 'opens');
        $rsm->addScalarResult('bounced', 'bounced');
        $result = $em->createNativeQuery('SELECT m.subject as title, 
            SUM(CASE WHEN es.is_failed=1 then 1 else 0 end) failed, 
            SUM(es.open_count) opens, 
            SUM(CASE WHEN es.is_failed=0 then 1 else 0 end) sent, 
            SUM(CASE WHEN ldnc.channel="email" AND ldnc.channel_id=es.email_id AND ldnc.reason=1 then 1 else 0 end) bounced 
            FROM mautic_email_stats es 
            LEFT JOIN mautic_emails m on es.email_id=m.id 
            LEFT JOIN mautic_lead_donotcontact ldnc on es.email_id=ldnc.channel_id
            GROUP BY es.email_id',$rsm)->getResult();
        var_dump($result);die;
        return $result;
    }
}