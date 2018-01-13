<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tirelire;
use AppBundle\Service\TransactionChecker;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Tirelire controller.
 *
 */
class TirelireController extends Controller
{
    /**
     * Lists all tirelire entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $transactions = $em->getRepository('AppBundle:Tirelire')->findAll();

        return $this->render('tirelire/index.html.twig', array(
            'transactions' => $transactions,
        ));
    }

    /**
     * Creates a new tirelire entity.
     *
     */
    public function newAction(Request $request, TransactionChecker $transacCheck)
    {
        $tirelire = new Tirelire();
        $form = $this->createForm('AppBundle\Form\TirelireType', $tirelire);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $formData = $form->getData();

            if($transacCheck->isAllowed( $formData->getMontant() )){

                $em = $this->getDoctrine()->getManager();

                $em->persist($tirelire);
                $em->flush();

                return $this->redirectToRoute('tirelire_index');

            }else{
                $form->addError(new FormError('Vous etes deja a sec !'));
            }
        }

        return $this->render('tirelire/new.html.twig', array(
            'tirelire' => $tirelire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tirelire entity.
     *
     */
    public function showAction(Tirelire $tirelire)
    {

        return $this->render('tirelire/show.html.twig', array(
            'tirelire' => $tirelire,
        ));
    }

    /**
     * Displays a form to edit an existing tirelire entity.
     *
     */
    public function editAction()
    {
        throw new NotFoundHttpException('Sorry this action is not possile !');
    }

    /**
     * Deletes a tirelire entity.
     *
     */
    public function deleteAction()
    {
        throw new NotFoundHttpException('Sorry this action is not possile !');
    }

}
