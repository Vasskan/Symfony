<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Messages;
use Knp\Component\Pager\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

/**
 * Message controller.
 *
 * @Route("messages")
 */
class MessagesController extends Controller
{
    /**
     * Lists all message entities.
     *
     * @Route("/", name="messages_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //$messages = $em->getRepository('AppBundle:Messages')->findAll();
        $dql   = "SELECT m FROM AppBundle:Messages m";
        $query = $em->createQuery($dql);
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */

        $paginator  = $this->get('knp_paginator');
        $result = $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1),/*page number*/
            $request->query->getInt('limit', 5)/*limit per page*/
        );

        return $this->render('messages/index.html.twig', array(
            'messages' => $result,
        ));
    }

    /**
     * Creates a new message entity.
     *
     * @Route("/new", name="messages_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $message = new Messages();
        $form = $this->createForm('AppBundle\Form\MessagesType', $message, array (
            'userip' => $this->get('request_stack')->getCurrentRequest()->getClientIp(),
            'browser' => $_SERVER['HTTP_USER_AGENT']
        ));
        $form->handleRequest($request);
        $alert_image = [];

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $image
             */
            $image = $message->getImage();

            $imagename = md5(uniqid()).'.'.$image->guessExtension();

            $image->move(
                $this->getParameter('image_directory'), $imagename
            );

            $message->setImage($imagename);
            /**
             * @var UploadedFile $textfile
             */
            $textfile = $message->getTextfile();
            $filename = md5(uniqid()).'.'.$textfile->guessExtension();

            $textfile->move(
                $this->getParameter('files_directory'), $filename
            );

            $message->setTextfile($filename);
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            if (!$_FILES['appbundle_messages']['type']['image'] == 'image/jpeg') {
                $this
                    ->addFlash('success', 'Image attached!');
            }

            return $this->redirectToRoute('messages_show', array('id' => $message->getId()));
        }

        return $this->render('messages/new.html.twig', array(
            'message' => $message,
            'form' => $form->createView(),
            'alert_image' => $alert_image,
        ));
    }

    /**
     * Finds and displays a message entity.
     *
     * @Route("/{id}", name="messages_show")
     * @Method("GET")
     */
    public function showAction(Messages $message)
    {
        $deleteForm = $this->createDeleteForm($message);

        return $this->render('messages/show.html.twig', array(
            'message' => $message,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing message entity.
     *
     * @Route("/{id}/edit", name="messages_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Messages $message)
    {
        $deleteForm = $this->createDeleteForm($message);
        $editForm = $this->createForm('AppBundle\Form\MessagesType', $message);
        $editForm->handleRequest($request);
        $filename = $this->getParameter('files_directory').'/'.$message->getTextfile();
        $imagename = $this->getParameter('image_directory').'/'.$message->getImage();
            dump($filename);
            dump($imagename);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /*$filename = $this->getParameter('files_directory').$message->getTextfile();
            $imagename = $this->getParameter('image_directory').$message->getImage();
            $filesystem = new Filesystem();
            $filesystem->remove($filename);
            $filesystem->remove($imagename);*/
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('messages_index', array('id' => $message->getId()));
        }

        return $this->render('messages/edit.html.twig', array(
            'message' => $message,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a message entity.
     *
     * @Route("/{id}", name="messages_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Messages $message)
    {
        $form = $this->createDeleteForm($message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $filename = $this->getParameter('files_directory').'/'.$message->getTextfile();
            $imagename = $this->getParameter('image_directory').'/'.$message->getImage();
            $filesystem = new Filesystem();
            $filesystem->remove($filename);
            $filesystem->remove($imagename);
            $em->remove($message);
            $em->flush();
        }

        return $this->redirectToRoute('messages_index');
    }

    /**
     * Creates a form to delete a message entity.
     *
     * @param Messages $message The message entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Messages $message)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('messages_delete', array('id' => $message->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
