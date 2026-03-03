<?php

namespace App\Tests\Functional\Front;

use App\Repository\UserRepository;
use App\Tests\BaseWebTestCase;

final class GuestspageTest extends BaseWebTestCase
{
    public function testGuestsPageListsGuestsWithDiscoverLinks(): void
    {
        // open guests list
        $crawler = $this->get('/guests');
        self::assertResponseIsSuccessful();

        // assert the page title
        self::assertSelectorTextContains('h3', 'Invités');

        self::assertGreaterThan(0, $crawler->filter('.guests .guest')->count());

        // title (character + space + digital)
        $firstGuestTitle = trim($crawler->filter('.guests .guest h4')->first()->text());
        self::assertMatchesRegularExpression('/^.+\s\(\d+\)$/', $firstGuestTitle);

        $firstLink = $crawler
            ->filter('.guests .guest a:contains("découvrir")')
            ->first()
            ->link();

        $firstHref = $firstLink->getUri();

        self::assertStringContainsString('/guest/', $firstHref);

        // open the discover link
        $this->client->click($firstLink);
        self::assertResponseIsSuccessful();

        self::assertMatchesRegularExpression('#^/guest/\d+$#', $this->client->getRequest()->getPathInfo());
    }

    public function testGuestPagesDoesNotShowBlockedGuests(): void
    {
        $this->loginAs('blockedGuest@test.com');

        /** @var UserRepository $usersRepo */
        $usersRepo = static::getContainer()->get(UserRepository::class);
        $blockedGuest = $usersRepo->findOneBy(['email' => 'blockedGuest@test.com']);
        $idOfBlockedGuest = $blockedGuest->getId();

        $crawler = $this->get('/guests');
        self::assertResponseIsSuccessful();

        $selector = sprintf('.guest .guest[data-guest-id="%d"]', $idOfBlockedGuest);

        self::assertCount(0, $crawler->filter($selector));
    }
}
