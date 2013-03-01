<?php

namespace Pcdummy\AjaxCompleteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{   
    public function get_AjaxAction(Request $request)
    {

        // TODO: Add Support for Propel.
        $em = $this->get('doctrine')->getEntityManager();
        
        // TODO: Add security
//        if (false === $this->get('security.context')->isGranted( $entity_inf['role'] )) {
//            throw new AccessDeniedException();
//        }

        // The Property to look up for ( SQL column ).
        $property = $request->get('property');
        // The Entity 
        $entity = $request->get('entity');
        
        // Search phrase.
        $letters = $request->get('letters');
        
        // Max rows to return.
        $maxRows = $request->get('maxRows');

        if (trim($letters) != "") {
            $like = '%' . $letters . '%';
            $results = $em->createQuery(
                'SELECT e.id, e.' . $property . '
                 FROM ' . $entity . ' e
                 WHERE e.' . $property . ' LIKE :like
                 ORDER BY e.' . $property)
                ->setParameter('like', $like )
                ->setMaxResults($maxRows)
                ->getScalarResult();
        } else {
            $results = $em->createQuery(
                'SELECT e.id, e.' . $property . '
                 FROM ' . $entity . ' e
                 ORDER BY e.' . $property)
                ->setMaxResults($maxRows)
                ->getScalarResult();            
        }

        $res = array();
        foreach ($results AS $r) {
            $res[$r['id']] = $r[$property];
        }

        return new Response(json_encode($res));
    }
}
