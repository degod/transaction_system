<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\PHPUnit\Set\PHPUnitSetList;
use RectorLaravel\Set\LaravelLevelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/bootstrap',
        __DIR__.'/config',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ])
    ->withSkip([
        __DIR__.'/bootstrap/cache',
    ])
    // Disabled caching for now because rector was skipping a lot of files and required changes
//    ->withCache(
//        cacheClass: FileCacheStorage::class,
//        cacheDirectory: __DIR__ . '/.cache/rector'
//    )

    ->withPhpSets()

//    ->withPreparedSets(
//        deadCode: true,
//        codeQuality: true,
//        codingStyle: true,
//        typeDeclarations: true,
//        privatization: true,
//        naming: true,
//        instanceOf: true,
//        earlyReturn: true,
//        strictBooleans: true
//    )

    ->withSets([
        LaravelLevelSetList::UP_TO_LARAVEL_100,
        PHPUnitSetList::PHPUNIT_100,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        PHPUnitSetList::ANNOTATIONS_TO_ATTRIBUTES,
    ]);
