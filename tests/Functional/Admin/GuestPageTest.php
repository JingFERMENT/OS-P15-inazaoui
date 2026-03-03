<?php

namespace App\Tests\Functional\Admin;

use App\Entity\User;
use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class GuestPageTest extends BaseWebTestCase
{
    public function testGuestPageRequiresLogin(): void
    {
        $this->get('/admin/guests');
        self::assertResponseRedirects('/login');
    }

    public function testGuestPageRequiresAdmin(): void
    {
        $this->loginAs('activeGuest@test.com');
        $this->get('/admin/guests');
        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testGuestPageIndexRenders(): void
    {
        $this->loginAs('ina@zaoui.com');

        $this->get('/admin/guests');
        self::assertResponseIsSuccessful();

        self::assertAnySelectorTextContains('a.nav-link', 'Invités');
        self::assertAnySelectorTextContains('a.nav-link', 'Albums');
    }

    public function testGuestPageCanAddGuest(): void
    {
        $this->loginAs('ina@zaoui.com');
        $crawler = $this->get('/admin/guests');

        $addLink = $crawler->filter('a.btn[href="/admin/guest/add"]')->link();
        $crawler = $this->client->click($addLink);
        self::assertResponseIsSuccessful();
        self::assertSame('/admin/guest/add', $this->client->getRequest()->getPathInfo());

        $email = 'guesttest@test.com';
        $name = 'guest test';
        $description = 'guest description test';

        $form = $crawler->selectButton('Ajouter')->form(
            ['guest[name]' => $name,
                'guest[email]' => $email,
                'guest[description]' => $description, ],
        );

        $this->client->submit($form);

        self::assertResponseRedirects('/admin/guests');
        $this->client->followRedirect();
        self::assertResponseIsSuccessful();

        self::assertAnySelectorTextContains(
            '.alert-success',
            'Invité ajouté avec succès'
        );
    }

    public function testGuestPageCanDisableGuest(): void
    {
        $this->loginAs('ina@zaoui.com');
        $crawler = $this->get('/admin/guests');

        self::assertResponseIsSuccessful();
        $blockFormNode = $crawler->filter('form[action^="/admin/guest/disable/"]');
        self::assertGreaterThan(0, $blockFormNode->count(), "Pas d'invité à bloquer");

        $this->client->submit($blockFormNode->form());
        self::assertResponseRedirects('/admin/guests');
        $this->client->followRedirect();
        self::assertResponseIsSuccessful();
    }

    public function testGuestPageCanEnableGuest(): void
    {
        $this->loginAs('ina@zaoui.com');
        $crawler = $this->get('/admin/guests');
        self::assertResponseIsSuccessful();

        $unblockFormNode = $crawler->filter('form[action^="/admin/guest/enable/"]');
        self::assertGreaterThan(0, $unblockFormNode->count(), "Pas d'invité à débloquer");

        $this->client->submit($unblockFormNode->form());
        self::assertResponseRedirects('/admin/guests');
        $this->client->followRedirect();
        self::assertResponseIsSuccessful();
    }

    public function testGuestPageCanDeleteGuest(): void
    {
        $this->loginAs('ina@zaoui.com');
        $crawler = $this->get('/admin/guests');
        self::assertResponseIsSuccessful();
        $deleteFormNode = $crawler->filter('form[action^="/admin/guest/delete/"]');
        self::assertGreaterThan(0, $deleteFormNode->count(), "Pas d'invité à supprimer");

        $this->client->submit($deleteFormNode->form());
        self::assertResponseRedirects('/admin/guests');
        $this->client->followRedirect();
        self::assertResponseIsSuccessful();
    }

    public function testSetPasswordPageRendersAndActivateGuests(): void
    {
        $container = static::getContainer();
        $em = $container->get(EntityManagerInterface::class);

        $guest = new User();
        $guest->setEmail('test@test.com');
        $guest->setName('test_set_password_activate_guest');
        $guest->setRoles(['ROLE_USER']);
        $guest->setIsActive(false);

        $token = bin2hex(random_bytes(32));
        $guest->setInvitationToken($token);
        $guest->setInvitationExpiredAt(new \DateTimeImmutable('+2 days'));
        $em->persist($guest);
        $em->flush();

        $this->get('/set-password/'.$token);
        self::assertResponseIsSuccessful();
        self::assertSelectorExists('form');

        $this->client->submitForm('Activer ton compte', [
            'set_password[plainPassword][first]' => 'Password123@',
            'set_password[plainPassword][second]' => 'Password123@',
        ]);

        self::assertResponseRedirects('/');
        $this->client->followRedirect();

        $em->clear(); // reload from DB

        $reloaded = $em->getRepository(User::class)->findOneBy(['email' => 'test@test.com']);

        self::assertNotNull($reloaded);

        self::assertTrue($reloaded->isActive());
        self::assertNull($reloaded->getInvitationExpiredAt());
        self::assertNull($reloaded->getInvitationToken());
    }

    public function testSetPasswordPageRedirectToHomePageWhenTokenIsInvalide(): void
    {
        $fakeToken = str_repeat('a', 64);
        $this->get('/set-password/'.$fakeToken);

        self::assertResponseRedirects('/');
        $this->client->followRedirect();

        self::assertSelectorExists('.alert-danger');
        self::assertSelectorTextContains('.alert-danger', 'Invitation invalide ou expirée.');
    }

    public function testDisableGuestWithInvalidCsrfReturns403(): void
    {
        $this->loginAs('ina@zaoui.com');

        $crawler = $this->get('/admin/guests');
        self::assertResponseIsSuccessful();

        // disable the guest
        $firstBlockFormNode = $crawler->filter('form[action^="/admin/guest/disable/"]')->first();

        $actionInFirstBlockFormNode = $firstBlockFormNode->attr('action');

        $this->client->request('POST', $actionInFirstBlockFormNode, [
            '_token' => 'invalid-token',
        ]);

        self::assertResponseStatusCodeSame(403);
    }

    public function testEnableGuestWithInvalidCsrfReturns403(): void
    {
        $this->loginAs('ina@zaoui.com');

        $crawler = $this->get('/admin/guests');
        self::assertResponseIsSuccessful();

        // enable the guest
        $firstEnableFormNode = $crawler->filter('form[action^="/admin/guest/enable/"]')->first();

        $actionInFirstEnableFormNode = $firstEnableFormNode->attr('action');

        $this->client->request('POST', $actionInFirstEnableFormNode, [
            '_token' => 'invalid-token',
        ]);

        self::assertResponseStatusCodeSame(403);
    }

    public function testDeleteGuestWithInvalidCsrfReturns403(): void
    {
        $this->loginAs('ina@zaoui.com');

        $crawler = $this->get('/admin/guests');
        self::assertResponseIsSuccessful();

        // delete the guest
        $firstDeleteFormNode = $crawler->filter('form[action^="/admin/guest/delete/"]')->first();

        $actionInFirstDeleteFormNode = $firstDeleteFormNode->attr('action');

        $this->client->request('POST', $actionInFirstDeleteFormNode, [
            '_token' => 'invalid-token',
        ]);

        self::assertResponseStatusCodeSame(403);
    }
}
