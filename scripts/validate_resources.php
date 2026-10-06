<?php

declare(strict_types=1);

use Symfony\Component\Yaml\Yaml;

require dirname(__DIR__).'/vendor/autoload.php';

/**
 * Stop validation when a required invariant fails.
 *
 * @param bool $condition
 * @param string $message
 * @return void
 * @throws RuntimeException
 */
function ensure(bool $condition, string $message): void
{
    if (! $condition) {
        throw new RuntimeException($message);
    }
}

/**
 * Read a resource while reporting unreadable files as validation failures.
 *
 * @param string $path
 * @return string
 * @throws RuntimeException
 */
function readResource(string $path): string
{
    $content = file_get_contents($path);
    ensure($content !== false, "Cannot read resource: {$path}");

    return $content;
}

/**
 * Find Markdown resources recursively without scanning installed dependencies.
 *
 * @param string $directory
 * @return list<string>
 */
function markdownFiles(string $directory): array
{
    $files = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS),
    );

    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'md') {
            $files[] = $file->getPathname();
        }
    }

    sort($files);

    return $files;
}

/**
 * Validate skill entry points and their discovery metadata.
 *
 * @param string $skillsDirectory
 * @return list<string>
 * @throws RuntimeException
 */
function validateSkills(string $skillsDirectory): array
{
    $directories = glob($skillsDirectory.'/*', GLOB_ONLYDIR) ?: [];
    ensure($directories !== [], 'No packaged skills found');
    $names = [];

    foreach ($directories as $directory) {
        $entry = $directory.'/SKILL.md';
        ensure(is_file($entry), "{$directory}: missing SKILL.md");
        $text = readResource($entry);
        ensure(preg_match('/\A---\R(.*?)\R---(?:\R|\z)/s', $text, $matches) === 1, "{$entry}: missing YAML frontmatter");
        $metadata = Yaml::parse($matches[1]);
        ensure(is_array($metadata) && ! array_is_list($metadata), "{$entry}: frontmatter must be a mapping");
        $name = $metadata['name'] ?? null;
        ensure($name === basename($directory), "{$entry}: name must match the skill directory");
        ensure(strlen($name) <= 64 && preg_match('/\A[a-z0-9]+(?:-[a-z0-9]+)*\z/', $name) === 1, "{$entry}: invalid skill name");
        $description = $metadata['description'] ?? null;
        ensure(
            is_string($description) && trim($description) !== '' && mb_strlen(trim($description)) <= 1024,
            "{$entry}: description must be a non-empty string of at most 1024 characters",
        );
        ensure(! str_contains($text, '[TODO:'), "{$entry}: unfinished skill placeholder");
        $names[] = $name;
    }

    sort($names);

    return $names;
}

/**
 * Resolve dot segments before mapping a simulated consumer path to its source.
 *
 * @param string $path
 * @return string
 */
function normalizePath(string $path): string
{
    $parts = [];

    foreach (explode('/', $path) as $part) {
        if ($part === '' || $part === '.') {
            continue;
        }
        if ($part === '..') {
            array_pop($parts);
        } else {
            $parts[] = $part;
        }
    }

    return '/'.implode('/', $parts);
}

/**
 * Check consumer paths against the package and copied skill inventories.
 *
 * @param string $path
 * @param string $root
 * @return bool
 */
function consumerPathExists(string $path, string $root): bool
{
    $path = normalizePath($path);
    $locations = [
        '/consumer/vendor/maarsson/agent-guidelines/' => $root.'/',
        '/consumer/.agents/skills/' => $root.'/resources/boost/skills/',
    ];

    foreach ($locations as $prefix => $source) {
        if (str_starts_with($path, $prefix)) {
            return file_exists($source.substr($path, strlen($prefix)));
        }
    }

    return false;
}

/**
 * Check local inline links and consumer-root-relative shared guideline paths.
 *
 * @param list<string> $files
 * @param string $root
 * @param bool $consumer
 * @return void
 * @throws RuntimeException
 */
function validateLinks(array $files, string $root, bool $consumer = false): void
{
    $packagePrefix = 'vendor/maarsson/agent-guidelines/';
    $skillsPrefix = $root.'/resources/boost/skills/';

    foreach ($files as $file) {
        $text = readResource($file);
        $location = $file;
        if ($consumer) {
            $location = str_starts_with($file, $skillsPrefix)
                ? '/consumer/.agents/skills/'.substr($file, strlen($skillsPrefix))
                : '/consumer/'.$packagePrefix.substr($file, strlen($root) + 1);
        }

        preg_match_all('/\[[^\]]*\]\(([^)]+)\)/', $text, $links);
        foreach ($links[1] as $target) {
            $url = parse_url(trim($target, '<>'));
            ensure($url !== false, "{$file}: invalid link {$target}");
            if (isset($url['scheme']) || isset($url['host']) || empty($url['path'])) {
                continue;
            }
            $path = dirname($location).'/'.rawurldecode($url['path']);
            $exists = $consumer ? consumerPathExists($path, $root) : file_exists($path);
            ensure($exists, "{$location}: broken local link {$target}");
        }

        // The shared paths stay rooted in the application when Boost copies skills.
        preg_match_all('/`('.preg_quote($packagePrefix, '/').'[^`]+)`/', $text, $paths);
        foreach ($paths[1] as $target) {
            $path = $root.'/'.substr($target, strlen($packagePrefix));
            ensure(file_exists($path), "{$location}: missing {$target}");
        }
    }
}

/**
 * Verify core routes without treating third-party skills as package contents.
 *
 * @param string $root
 * @param list<string> $skillNames
 * @return void
 * @throws RuntimeException
 */
function validateRouting(string $root, array $skillNames): void
{
    $core = readResource($root.'/resources/boost/guidelines/core.blade.php');
    ensure(preg_match('/## Guideline Routing\R(.*?)## Skill Activation\R/s', $core, $guidelines) === 1, 'Missing core routing sections');
    preg_match_all('/\| `([^`]+\.md)` \|/', $guidelines[1], $routes);
    ensure($routes[1] !== [], 'Core has no shared guideline routes');
    foreach ($routes[1] as $name) {
        ensure(is_file($root.'/resources/guidelines/'.$name), "Missing guideline: {$name}");
    }

    ensure(preg_match('/## Skill Activation\R(.*?)For supporting skills/s', $core, $activation) === 1, 'Missing core skill activation section');
    preg_match_all('/\| `([^`]+)` \|/', $activation[1], $skills);
    $routedSkills = array_values(array_unique($skills[1]));
    sort($routedSkills);
    ensure($routedSkills === $skillNames, 'Core skill routes do not match packaged skills');
}

try {
    $root = dirname(__DIR__);
    $skillNames = validateSkills($root.'/resources/boost/skills');
    validateRouting($root, $skillNames);
    $files = array_merge(glob($root.'/*.md') ?: [], markdownFiles($root.'/resources'));
    validateLinks($files, $root);

    // Model both Composer's vendor layout and Boost's copied skill locations.
    $consumerFiles = array_merge(
        glob($root.'/resources/guidelines/*.md') ?: [],
        markdownFiles($root.'/resources/boost/skills'),
    );
    validateLinks($consumerFiles, $root, true);

    printf("Validated %d skills, core routing, and source/consumer file references.\n", count($skillNames));
} catch (Throwable $exception) {
    fwrite(STDERR, 'Validation failed: '.$exception->getMessage().PHP_EOL);
    exit(1);
}
