<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\PhoneBook;
use Symfony\Component\Translation\TranslatorInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(PhoneBook::class)->findBy([], ['id' => 'DESC']);
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
