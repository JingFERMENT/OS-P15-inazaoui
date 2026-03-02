<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use App\Entity\User;
use App\Form\MediaType;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class MediaController extends AbstractController
{
    #[Route('/admin/media', name: 'admin_media_index')]
    public function index(Request $request, MediaRepository $media): Response
    {
        $page = $request->query->getInt('page', 1);

        $criteria = [];

        if (!$this->isGranted('ROLE_ADMIN')) {
            $criteria['user'] = $this->getUser();
        }

        $limit = 8;
        $offset = 8 * ($page - 1);

        $medias = $media->findBy(
            $criteria,
            ['id' => 'ASC'],
            $limit,
            $offset
        );
        $total = $media->count($criteria);

        return $this->render('admin/media/index.html.twig', [
            'medias' => $medias,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
        ]);
    }

    #[Route('/admin/media/add', name: 'admin_media_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $media = new Media();
        $form = $this->createForm(MediaType::class, $media, ['is_admin' => $this->isGranted('ROLE_ADMIN')]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->isGranted('ROLE_ADMIN')) {
                $user = $this->getUser();

                if (!$user instanceof User) {
                    throw $this->createAccessDeniedException('You must be logged in.');
                }

                $media->setUser($user);
            }

            $filename = md5(uniqid()).'.'.$media->getFile()->guessExtension();
            $media->setPath('uploads/'.$filename);
            $media->getFile()->move('public/uploads/', $filename);
            $em->persist($media);
            $em->flush();

            return $this->redirectToRoute('admin_media_index');
        }

        return $this->render('admin/media/add.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/admin/media/delete/{id}', name: 'admin_media_delete', methods: ['POST'])]
    public function delete(Media $media, Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->isCsrfTokenValid('media_delete_'.$media->getId(), (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $em->remove($media);

        $em->flush();

        if (is_file($media->getPath())) {
            unlink($media->getPath());
        }

        return $this->redirectToRoute('admin_media_index');
    }
}
