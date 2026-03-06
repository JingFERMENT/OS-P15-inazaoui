<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Media;
use App\Entity\User;
use App\Repository\AlbumRepository;
use App\Repository\MediaRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('front/home.html.twig');
    }

    #[Route('/guests', name: 'guests')]
    public function guests(Request $request, UserRepository $userRepository, CacheInterface $cache): Response
    {
        $criteria = [];

        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $offset = $limit * ($page - 1);

        $guests = $cache->get('guests_with_media_count', function (ItemInterface $item) use ($userRepository, $limit, $offset) {
            $item->expiresAfter(300); // adapter à la fréquence des mises à jour

            return $userRepository->findForActiveGuestsWithMediaCount($limit, $offset);
        });

        $total = $userRepository->count($criteria);

        return $this->render('front/guests.html.twig', [
            'guests' => $guests,
            'total' => $total,
            'limit' => $limit,
            'page' => $page,
        ]);
    }

    #[Route('/guest/{id}', name: 'guest', requirements: ['id' => '\d+'])]
    public function guest(User $guest, Request $request, MediaRepository $mediaRepository): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $offset = $limit * ($page - 1);

        // total media for this guest
        $total = $mediaRepository->count(['user' => $guest]);

        $medias = $mediaRepository->findBy(
            ['user' => $guest],
            ['id' => 'DESC'],
            $limit,
            $offset,
        );

        return $this->render('front/guest.html.twig', [
            'guest' => $guest,
            'media' => $medias,
            'total' => $total,
            'limit' => $limit,
            'page' => $page,
        ]);
    }

    #[Route('/portfolio/{id}', name: 'portfolio', defaults: ['id' => null], requirements: ['id' => '\d+'])]
    public function portfolio(
        AlbumRepository $albumsRepo,
        MediaRepository $mediasRepo,
        CacheInterface $cache,
        ?Album $album = null,
    ): Response {
        $albums = $cache->get('portfolio_albums', function (ItemInterface $item) use ($albumsRepo) {
            $item->expiresAfter(3600);

            return $albumsRepo->findAll();
        });

        $albumId = $album?->getId() ?? 0;

        $cacheKey = sprintf('portfolio_medias_album_%s', $albumId);

        /** @var list<Media> $medias */
        $medias = $cache->get($cacheKey, function (ItemInterface $item) use ($mediasRepo, $album) {
            $item->expiresAfter(300); // 5 mins

            if (null !== $album) {
                return $mediasRepo->findBy(['album' => $album], ['id' => 'ASC']);
            }

            return $mediasRepo->findForActiveGuests();
        });

        return $this->render('front/portfolio.html.twig', [
            'albums' => $albums,
            'album' => $album,
            'medias' => $medias,
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('front/about.html.twig');
    }
}
