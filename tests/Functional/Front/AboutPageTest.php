<?php

namespace App\Tests\Functional\Front;

use App\Tests\BaseWebTestCase;

class AboutPageTest extends BaseWebTestCase
{
    public function testAboutPageIsSuccessfulAndShowContents(): void
    {
        $crawler = $this->get('/about');

        self::assertResponseIsSuccessful();

        self::assertSelectorTextContains('h2.about-title', 'Qui suis-je ?');

        self::assertSelectorExists('img.about-img[alt="Ina Zaoui"]');

        $imgSrc = $crawler->filter('img.about-img')->attr('src');

        self::assertStringContainsString('/images/ina.png', $imgSrc);

        self::assertSelectorTextContains('.about-description', "Chaque cliché d'Ina Zaoui est une ode à la beauté brute et à la fragilité de notre planète");
    }
}
