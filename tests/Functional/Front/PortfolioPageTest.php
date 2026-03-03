<?php

namespace App\Tests\Functional\Front;

use App\Repository\AlbumRepository;
use App\Repository\MediaRepository;
use App\Tests\BaseWebTestCase;
use Symfony\Component\DomCrawler\Crawler;

final class PortfolioPageTest extends BaseWebTestCase
{
    public function testPortfolioRequiresLogin(): void
    {
        $this->assertPageRequiresLogin('/portfolio');
    }

    public function testPortfolioPageRendersAlbumsAndMediaWhenLoggedIn(): void
    {
        $this->loginAs('activeGuest@test.com');
        $crawler = $this->get('/portfolio');
        self::assertResponseIsSuccessful();

        self::assertSelectorTextContains('h3', 'Portfolio');

        $albumsBouttons = $crawler->filter('.mb-5 a.btn');

        $albumsTexts = $albumsBouttons->each(fn (Crawler $a) => trim($a->text()));

        self::assertContains('Toutes', $albumsTexts);
        self::assertGreaterThan(0, $albumsBouttons->count());

        $albumsRepo = static::getContainer()->get(AlbumRepository::class);

        $albums = $albumsRepo->findAll();
        self::assertNotEmpty($albums, "Pas d'album trouvé dans la base des données");

        foreach ($albums as $album) {
            self::assertContains($album->getName(), $albumsTexts);
        }

        // active albumButton when album is null
        $activeAlbumText = $crawler->filter('.mb-5 a.btn.active')->text();
        self::assertSame('Toutes', $activeAlbumText);

        // media
        $mediaCards = $crawler->filter('.media');

        // media number > 0
        self::assertGreaterThan(0, $mediaCards->count(), 'Pas de média trouvé sur la page de portfolio.');

        foreach ($mediaCards as $mediaCard) {
            // image
            $card = new Crawler($mediaCard);
            self::assertGreaterThan(0, $card->filter('img')->count());
            $src = $card->filter('img')->attr('src');
            self::assertNotSame('', trim($src), "Le media n'a pas d'image");

            // media title
            self::assertGreaterThan(0, $card->filter('.media-title')->count(), "Le Média n'a pas de titre.");
            $mediaTitle = $card->filter('.media-title')->text();
            self::assertNotSame('', $mediaTitle);
        }

        // total number of the media
        $mediaRepo = static::getContainer()->get(MediaRepository::class);
        $expectedMediaForActiveGuests = $mediaRepo->findForActiveGuests();
        self::assertCount(count($expectedMediaForActiveGuests), $mediaCards);
    }

    public function testPortfolioPageFilterByAlbumByClickOnAlbumButtons(): void
    {
        $this->loginAs('activeGuest@test.com');
        $crawler = $this->get('/portfolio');

        $firstAlbumLinkNode = $crawler->filter('.mb-5 a.btn[href^="/portfolio/"]')->first();
        $firstAlbumLink = $firstAlbumLinkNode->link();

        $crawler = $this->client->click($firstAlbumLink);
        self::assertResponseIsSuccessful();

        $albumId = $this->client->getRequest()->attributes->get('id');

        $albumRepo = static::getContainer()->get(AlbumRepository::class);
        $album = $albumRepo->find($albumId);

        $activeAlbumText = $crawler->filter('.mb-5 a.btn.active')->text();
        self::assertSame($album->getName(), $activeAlbumText);

        $mediaRepo = static::getContainer()->get(MediaRepository::class);
        $expectedMediaBelongToAlbum = $mediaRepo->findByAlbum($album);
        self::assertCount(count($expectedMediaBelongToAlbum), $crawler->filter('.media'));
    }
}
