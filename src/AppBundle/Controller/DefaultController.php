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
      $form = $this->createFormBuilder()
        ->add('Rechercher', 'text', ['label' => false ,'attr' => ['placeholder' => 'Rechercher', 'autocomplete' => 'off']])
        ->getForm();
      $form->handleRequest($request);

      if ($form->isValid()) {
        $keyword = $form["Rechercher"]->getData();
        return $this->redirectToRoute('search', ["keyword" => $keyword]);
      }
      else {
        $taunts = $this->getDoctrine()->getRepository("AppBundle:Taunt")->findAll();
        return $this->render('homepage.html.twig', ['taunts' => $taunts, 'form' => $form->createView()]);
      }
    }

    /**
     * @Route("/taunt/{id}", name="taunt")
     */
    public function playTauntAction(Request $request, $id)
    {
      $taunts = $this->getDoctrine()->getRepository("AppBundle:Taunt")->findAll();
      $tauntToPlay = $this->getDoctrine()->getRepository("AppBundle:Taunt")->find($id);

      $form = $this->createFormBuilder()
        ->add('Rechercher', 'text', ['label' => false ,'attr' => ['placeholder' => 'Rechercher', 'autocomplete' => 'off']])
        ->getForm();
      $form->handleRequest($request);

      if ($form->isValid()) {
        $keyword = $form["Rechercher"]->getData();
        return $this->redirectToRoute('search', ["keyword" => $keyword]);
      }
      else {
        $taunts = $this->getDoctrine()->getRepository("AppBundle:Taunt")->findAll();
        return $this->render('homepage.html.twig', [
          'taunts' => $taunts,
          'taunt' => $tauntToPlay,
          'form' => $form->createView()]);
      }
    }

    /**
     * @Route("/search/{keyword}", name="search")
     */
    public function searchAction(Request $request, $keyword)
    {
      $form = $this->createFormBuilder()
        ->add('Rechercher', 'text', ['label' => false ,'attr' => ['placeholder' => 'Rechercher', 'autocomplete' => 'off']])
        ->getForm();
      $form->handleRequest($request);

      $em = $this->getDoctrine()->getManager();
      $query = $em->getRepository("AppBundle:Taunt")->createQueryBuilder('t');

      if ($form->isValid()) {
        $keyword = $form["Rechercher"]->getData();
        return $this->redirectToRoute('search', ["keyword" => $keyword]);
      }

      return $this->render('homepage.html.twig', [
        'form' => $form->createView(),
        'taunts' => $query
          ->where('t.quote LIKE :keyword')
          ->orWhere('t.title LIKE :keyword')
          ->orWhere('t.ref LIKE :keyword')
          ->setParameter('keyword', '%'.$keyword.'%')
          ->getQuery()
          ->getResult()
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
        /**
         * @Route("/team", name="team")
         */
        public function teamAction(Request $request)
        {
            return $this->render('team.html.twig');
        }



         /**
     * @Route("/remove/{id}", name="remove")
     */
        public function removeAction($id)
         {
           $quote = $this->getDoctrine()->getRepository("AppBundle:Taunt")->find($id);

           $em = $this->getDoctrine()->getManager();
           $em->remove($quote);
           $em->flush();

           return $this->redirectToRoute("homepage");
         }

         /**
     * @Route("/edit/{id}", name="edit")
     */
        public function editAction($id, Request $request)
         {
           $em = $this->getDoctrine()->getManager();
           $taunt = $em->getRepository("AppBundle:Taunt")->find($id);
           $form = $this->createFormBuilder($taunt)
           ->add('title', 'text',  array('label' => 'Titre'))
           ->add('ref', 'text',  array('label' => 'Film'))
           ->add('quote', 'textarea',  array('label' => 'Citation'))
           ->add('submit', 'submit',  array('label' => 'Publier'))
           ->getForm();

           $form->handleRequest($request);

           if ($form->isValid()) {
             $editedTaunt = $form->getData();
             $taunt->setTitle($editedTaunt->getTitle());
             $taunt->setQuote($editedTaunt->getQuote());
             $taunt->setRef($editedTaunt->getRef());
             $em->flush();

             return $this->redirectToRoute('homepage');
           }

           return $this->render('edit.html.twig', array(
             'form' => $form->createView()
             )
           );
         }
}
