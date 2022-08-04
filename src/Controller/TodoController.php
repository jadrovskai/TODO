<?php

namespace App\Controller;

use App\Entity\TodoEntity;
use App\Form\TodoFormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;




class TodoController extends AbstractController
{
    /** * @Route("/todos", name="todo_list") */
    
    public function todoAction(EntityManagerInterface $em)
    {
        $task = new TodoEntity();
        
        $repository = $em->getRepository(TodoEntity::class);
        /** @var TodoEntity $task */
        $task = $repository->findAll();

        if (!$task) {
            throw $this->createNotFoundException(sprintf('No tasks'));
        }

        return $this->render('tasks.html.twig', [
            'task' => $task,
        ]);

    }

    /**
     * @Route("/todos/create", name="todo_create")
     */
    public function createAction(Request $request, EntityManagerInterface $em) 
    { 
        $task = new TodoEntity(); 
        $form = $this->createForm(TodoFormType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
         { $em->persist($task);
             $em->flush();
            return $this->redirect($this->generateUrl( 'todo_list' )); 
         } 
         
         return $this->render('form.html.twig',['form' => $form->createView()]); 
    } 

    /**
     * @Route("/todos/update/{id}", name="todo_update")
     */
    public function updateAction($id, Request $request, EntityManagerInterface $em) 
    { 
        $repository = $em->getRepository(TodoEntity::class)->find($id);
        $task = new TodoEntity(); 
        $form = $this->createForm(TodoFormType::class, $repository); 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
         { $em->persist($repository);
             $em->flush();
            return $this->redirect($this->generateUrl( 'todo_list' )); 
         } 
         
         return $this->render('update.html.twig',['form' => $form->createView()]); 
    } 
         

    /** * @Route("/todo/delete/{id}", name="todo_delete", requirements={"id" = "\d+"}, defaults={"id" = 0}) */ 
    public function deleteAction($id, EntityManagerInterface $em) 
    { 
        $repository = $em->getRepository(TodoEntity::class)->find($id); 

        if (!$repository){ 
             throw $this->createNotFoundException( 'No todo found for id '.$id ); 
            } 
        else 
        { 
            $em->remove($repository); 
            $em->flush();  
            return $this->redirect($this->generateUrl('todo_list')); 
        } 
    }
}