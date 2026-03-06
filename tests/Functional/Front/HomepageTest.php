<?php

namespace App\Tests\Functional\Front;

use App\Tests\BaseWebTestCase;

final class HomepageTest extends BaseWebTestCase
{
    public function testHomePageHasPublicNavAndDiscoverLinkRedirectToPortfolioPage(): void
    {
        $crawler = $this->get('/');
        self::assertResponseIsSuccessful();

        self::assertSelectorExists('nav');

        self::assertSelectorExists('nav ul a:contains("Invité")');
        self::assertSelectorExists('nav ul a:contains("Portfolio")');
        self::assertSelectorExists('nav ul a:contains("Qui suis-je ?")');
        self::assertSelectorExists('nav ul a:contains("Connexion")');
        self::assertSelectorExists('a:contains("découvrir")');
        // Dashboard should not be displayed
        self::assertSelectorNotExists('nav a:contains("Dashboard")');

        $link = $crawler->filter('[data-test-id="discover-link"]')->link();

        $this->client->click($link);
        self::assertSame('/portfolio', $this->client->getRequest()->getPathInfo());
    }

    public function testHomePageLoggedGuestHasDashboardLinkAndRedirectToDiscoverPage(): void
    {
        $this->loginAs('activeGuest@test.com');
        $crawler = $this->get('/');
        self::assertResponseIsSuccessful();

        self::assertSelectorExists('nav');
        self::assertSelectorExists('nav a:contains("Dashboard")');
        self::assertSelectorExists('nav a:contains("Déconnexion")');

        $link = $crawler->filter('[data-test-id="discover-link"]')->link();
        $this->client->click($link);
        self::assertResponseIsSuccessful();
        self::assertSame('/portfolio', $this->client->getRequest()->getPathInfo());
    }
}
