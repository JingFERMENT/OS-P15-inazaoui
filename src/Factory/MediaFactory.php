<?php

namespace App\Factory;

use App\Entity\Media;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<Media>
 */
final class MediaFactory extends PersistentObjectFactory
{
    private static int $pathIndex;

    #[\Override]
    public static function class(): string
    {
        return Media::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    #[\Override]
    protected function defaults(): array|callable
    {
        return function () {
            if (!isset(self::$pathIndex)) {
                self::$pathIndex = 1;
            }

            $n = self::$pathIndex++;

            return [
                'path' => 'uploads/'.sprintf('%04d', $n).'.jpg',
                'title' => self::faker()->words(4, true),
                'user' => UserFactory::new(),
                'album' => null,
            ];
        };
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this;
        // ->afterInstantiate(function(Media $media): void {};
    }
}
