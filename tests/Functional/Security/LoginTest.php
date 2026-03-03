<?php

namespace App\Tests\Functional\Security;

use App\Tests\BaseWebTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class LoginTest extends BaseWebTestCase
{
    // test page rendered correctly
    public function testLoginPageShouldRender(): void
    {
        $this->get('/login');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Connexion');
        self::assertSelectorExists('form');
        self::assertSelectorExists('input[name="_csrf_token"]');
        self::assertSelectorExists('input[name="_username"]');
        self::assertSelectorExists('input[name="_password"]');
    }

    // test wrong username and password and blocked guest
    #[DataProvider('provideInvalidLogins')]
    public function testLoginFails(string $username, string $password, string $expectedErrorContains): void
    {
        $this->get('/login');

        self::assertResponseIsSuccessful();

        $this->client->submitForm('Connexion', [
            '_username' => $username,
            '_password' => $password,
        ]);

        self::assertResponseRedirects('/login');
        $this->client->followRedirect();

        self::assertAnySelectorTextContains('.alert-danger', $expectedErrorContains);
    }

    /**
     * @return iterable<string, array{string, string, string}>
     */
    public static function provideInvalidLogins(): iterable
    {
        yield 'wrong password' => [
            'activeGuest@test.com',
            'wrongPassword',
            'Identifiants invalides',
        ];

        yield 'unknown user' => [
            'unknownUser@test.com',
            'password123@',
            'Identifiants invalides',
        ];

        yield 'blocked user' => [
            'blockedGuest@test.com',
            'password123@',
            "Votre compte est bloqué ou non-activé. Veuillez contacter l'administrateur.",
        ];
    }
}
