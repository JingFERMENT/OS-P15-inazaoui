<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Media;
use App\Entity\User;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class UserMediaRelationTest extends TestCase
{
    public function testAddMediaAddsToCollectionAndSetsOwningSide(): void
    {
        $user = new User();
        $media = new Media();

        $user->addMedia($media);

        Assert::assertTrue($user->getMedias()->contains($media));
        Assert::assertSame($user, $media->getUser());
    }

    public function testRemoveMediaRemovesFromCollectionAndUnsetsOwningSide(): void
    {
        $user = new User();
        $media = new Media();

        $user->addMedia($media);
        $user->removeMedia($media);
        Assert::assertFalse($user->getMedias()->contains($media));
        Assert::assertNull($media->getUser());
    }
}
