<?php

namespace App\Controller;

use App\Entity\PhoneBook;
use App\Form\PhoneBookType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/admin/phonebook")
 */
class PhoneBookController extends AbstractController
{
    /**
     * @Route("/new", name="phonebook_new")
     * @param Request $request
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $phonebook = new PhoneBook();
        $user = $this->getUser();

        $form = $this->createForm(PhoneBookType::class, $phonebook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $phonebook->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($phonebook);
            $em->flush();
            $this->addFlash(
                'notice',
                $translator->trans('entry-added')
            );

            return $this->redirectToRoute('home');
        }


        return $this->render('phonebook/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/search", name="phonebook_search")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request, PaginatorInterface $paginator, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(PhoneBook::class)->findByPhoneOrName($request->request->get('search'));
        $phonesbook = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('home/index.html.twig', [
            'controller_name' => 'PhoneBookController',
            'phonesbook' => $phonesbook
        ]);
    }
}
