<?php

namespace App\Tests\Functional\Admin;

use App\Tests\BaseWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AlbumPageTest extends BaseWebTestCase
{
    public function testAlbumPageRequiresLogin(): void
    {
        $this->get('/admin/album');
        self::assertResponseRedirects('/login');
    }

    public function testAlbumPageRequiresAdmin(): void
    {
        $this->loginAs('activeGuest@test.com');
        $this->get('/admin/album');
        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testAlbumPageIndexRenders(): void
    {
        $this->loginAs('ina@zaoui.com');
        $this->get('/admin/album');
        self::assertResponseIsSuccessful();
        self::assertAnySelectorTextContains('a.nav-link', 'Invités');
        self::assertAnySelectorTextContains('a.nav-link', 'Albums');
    }

    public function testAlbumPageCanAddAlbum(): void
    {
        $this->loginAs('ina@zaoui.com');
        $crawler = $this->get('/admin/album');
        $addLink = $crawler->filter('a.btn[href="/admin/album/add"]')->link();
        $crawler = $this->client->click($addLink);
        self::assertResponseIsSuccessful();
        self::assertSame('/admin/album/add', $this->client->getRequest()->getPathInfo());

        $addAlbumName = 'Album Name test';

        $form = $crawler->selectButton('Ajouter')->form(['album[name]' => $addAlbumName]);

        $this->client->submit($form);
        self::assertResponseRedirects('/admin/album');
        $this->client->followRedirect();
        self::assertResponseIsSuccessful();
    }

    public function testAlbumPageCanUpdateAlbum(): void
    {
        $this->loginAs('ina@zaoui.com');
        $crawler = $this->get('/admin/album');

        self::assertResponseIsSuccessful();
        $updateNodes = $crawler->filter('a.btn[href^="/admin/album/update/"]');
        self::assertGreaterThan(0, $updateNodes->count(), "Pas d'album à modifier");

        $updateFirstlink = $updateNodes->first()->link();
        $updateFirstHref = $updateNodes->first()->attr('href');
        $crawler = $this->client->click($updateFirstlink);

        self::assertSame($updateFirstHref, $this->client->getRequest()->getPathInfo());

        $updatedAlbumName = 'New Ablum Name Test';
        $form = $crawler->selectButton('Modifier')->form(['album[name]' => $updatedAlbumName]);
        $this->client->submit($form);

        self::assertResponseRedirects('/admin/album');
        $this->client->followRedirect();
        self::assertResponseIsSuccessful();
    }

    public function testAlbumPageCanDeleteAlbum(): void
    {
        $this->loginAs('ina@zaoui.com');
        $crawler = $this->get('/admin/album');
        self::assertResponseIsSuccessful();
        $deleteNodes = $crawler->filter('a.btn[href^="/admin/album/delete/"]');
        self::assertGreaterThan(0, $deleteNodes->count(), "Pas d'album à supprimer");

        $deleteFirstlink = $deleteNodes->first()->link();
        $this->client->click($deleteFirstlink);
        self::assertResponseRedirects('/admin/album');
        $this->client->followRedirect();
        self::assertResponseIsSuccessful();
    }
}
