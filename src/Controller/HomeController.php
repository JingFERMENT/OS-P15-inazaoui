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
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $offset = $limit * ($page - 1);

        $cacheKey = sprintf('guests_with_media_count_page_%d_limit_%d', $page, $limit);

        $guests = $cache->get($cacheKey, function (ItemInterface $item) use ($userRepository, $limit, $offset) {
            $item->expiresAfter(3600); // adapter à la fréquence des mises à jour

            return $userRepository->findForActiveGuestsWithMediaCount($limit, $offset);
        });

        $total = $userRepository->countActiveGuests();

        return $this->render('front/guests.html.twig', [
            'guests' => $guests,
            'total' => $total,
            'limit' => $limit,
            'page' => $page,
        ]);
    }

    #[Route('/guest/{id:guest}', name: 'guest', requirements: ['id' => '\d+'])]
    public function guest(User $guest, Request $request, MediaRepository $mediaRepository, CacheInterface $cache): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 6;
        $offset = $limit * ($page - 1);

        $cacheKey = sprintf('one_guest_with_media_count_guest_%d_page_%d_limit_%d', $guest->getId(), $page, $limit);

        // total media for this guest
        $total = $mediaRepository->count(['user' => $guest]);

        $medias = $cache->get($cacheKey, function (ItemInterface $item) use ($mediaRepository, $guest, $limit, $offset) {
            $item->expiresAfter(3600); // adapter à la fréquence des mises à jour

            return $mediaRepository->findBy(
                ['user' => $guest],
                ['id' => 'DESC'],
                $limit,
                $offset,
            );
        });

        return $this->render('front/guest.html.twig', [
            'guest' => $guest,
            'medias' => $medias,
            'total' => $total,
            'limit' => $limit,
            'page' => $page,
        ]);
    }

    #[Route('/portfolio/{id:album}', name: 'portfolio', defaults: ['id' => null], requirements: ['id' => '\d+'])]
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

        $cacheKey = sprintf('portfolio_medias_album_%d', $albumId);

        /** @var list<Media> $medias */
        $medias = $cache->get($cacheKey, function (ItemInterface $item) use ($mediasRepo, $album) {
            $item->expiresAfter(3600); // 1 heure

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
