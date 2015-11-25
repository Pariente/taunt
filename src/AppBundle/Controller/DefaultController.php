<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Taunt;
use AppBundle\Form\TauntType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $taunts = $this->getDoctrine()->getRepository("AppBundle:Taunt")->findAll();
        return $this->render('homepage.html.twig', ['taunts' => $taunts]);
    }



    /**
     * @Route("/taunt/{id}", name="taunt")
     */
    public function playTauntAction(Request $request, $id)
    {
        $taunts = $this->getDoctrine()->getRepository("AppBundle:Taunt")->findAll();
        $tauntToPlay = $this->getDoctrine()->getRepository("AppBundle:Taunt")->find($id);
        return $this->render('homepage.html.twig', [
          'taunts' => $taunts,
          'taunt' => $tauntToPlay
        ]);
    }

        /**
     * @Route("/search/{keyword}", name="search")
     */
    public function searchAction(Request $request, $keyword)
    {
        $taunts = $this->getDoctrine()->getRepository("AppBundle:Taunt")->findAll();
        $tauntToPlay = $this->getDoctrine()->getRepository("AppBundle:Taunt")->find($id);
        return $this->render('homepage.html.twig', [
          'taunts' => $taunts,
          'taunt' => $tauntToPlay
        ]);
    }

        /**
     * @Route("/new", name="new")
     */
        public function createAction(Request $request)
        {

            $taunt = new Taunt();
            $form = $this->createFormBuilder($taunt)
            ->add('title', 'text',  array('label' => 'Titre'))
            ->add('ref', 'text',  array('label' => 'Film'))
            ->add('quote', 'textarea',  array('label' => 'Citation'))
            ->add('file', 'file', array('label' => 'Fichier'))
            ->add('submit', 'submit',  array('label' => 'Publier'))
            ->getForm();

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $taunt->upload();

                $em->persist($taunt);
                $em->flush();

                return $this->redirectToRoute('homepage');
            }

            return $this->render('new.html.twig', array(
                'form' => $form->createView()
                )
            );
        }
    }
