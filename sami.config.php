<?php

use Sami\RemoteRepository\GitHubRemoteRepository;
use Sami\Sami;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
// ->exclude('Resources')
// ->exclude('Tests')
    ->in($dir = __DIR__ . '/src')
;

// generate documentation for all v2.0.* tags, the 2.0 branch, and the master one
$versions = GitVersionCollection::create($dir)
    ->addFromTags('v1.0.*')
    ->add('1.0', '1.0 branch')
    ->add('master', 'master branch')
;

return new Sami($iterator, array(
    // 'theme' => 'symfony',
    'versions' => '1.0.0',
    'title' => 'OVAC/Hubtel-Payment API',
    'build_dir' => __DIR__ . '/docs/%version%/documentation',
    'cache_dir' => __DIR__ . '/docs/%version%/cache',
    'default_opened_level' => 2,
    'remote_repository' => new GitHubRemoteRepository('symfony/symfony', dirname($dir)),
));
