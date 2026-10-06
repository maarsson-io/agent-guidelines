<?php

declare(strict_types=1);

use Symfony\Component\Yaml\Yaml;

require dirname(__DIR__).'/vendor/autoload.php';

/**
 * Run the actual initializer against an isolated consumer fixture.
 *
 * @param string $project
 * @param list<string> $arguments
 * @return array{int, string, string}
 * @throws RuntimeException
 */
function runInitializer(string $project, array $arguments = []): array
{
    $command = [PHP_BINARY, dirname(__DIR__).'/bin/agent-guidelines-init', ...$arguments];
    $process = proc_open($command, [1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes, $project);
    if (! is_resource($process)) {
        throw new RuntimeException('Cannot start initializer test');
    }
    $output = stream_get_contents($pipes[1]);
    $error = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);

    return [proc_close($process), $output, $error];
}

/**
 * Fail on an observable result that violates the initialization contract.
 *
 * @param bool $condition
 * @param string $message
 * @return void
 * @throws RuntimeException
 */
function expectInitialization(bool $condition, string $message): void
{
    if (! $condition) {
        throw new RuntimeException($message);
    }
}

/**
 * Remove only a test fixture, without following symlinks into other directories.
 *
 * @param string $project
 * @return void
 */
function removeInitializerFixture(string $project): void
{
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($project, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST,
    );
    foreach ($iterator as $file) {
        if ($file->isDir() && ! $file->isLink()) {
            rmdir($file->getPathname());
        } else {
            unlink($file->getPathname());
        }
    }
    rmdir($project);
}

$cases = [
    'creates a usable local index without replacing the default maintainer' => function (string $project): void {
        [$status, , $error] = runInitializer($project);
        expectInitialization($status === 0, $error);
        $index = $project.'/.agents/guidelines/project.md';
        expectInitialization(is_file($index), 'Missing local project index');
        preg_match_all('/\[[^\]]*\]\(([^)]+)\)/', file_get_contents($index), $links);
        expectInitialization($links[1] !== [], 'Project index has no routes');
        foreach ($links[1] as $link) {
            expectInitialization(is_file(dirname($index).'/'.$link), 'Broken project route: '.$link);
        }
        expectInitialization(! file_exists($project.'/.agents/guidelines/maintainer.md'), 'Default initialization must retain the package profile');
        expectInitialization(! file_exists($project.'/.ai'), 'Default initialization must not create an unrequested domain skill');
        expectInitialization(! file_exists($project.'/.claude'), 'Initialization must not implicitly configure agent links');
    },
    'preserves edited guidelines on repeated initialization' => function (string $project): void {
        [$status] = runInitializer($project);
        expectInitialization($status === 0, 'Initial setup failed');
        $context = $project.'/.agents/guidelines/project/context.md';
        file_put_contents($context, 'Verified project context');
        file_put_contents($project.'/.agents/guidelines/project.md', 'Custom local routing');
        [$status, , $error] = runInitializer($project);
        expectInitialization($status === 0, $error);
        expectInitialization(file_get_contents($context) === 'Verified project context', 'Edited context was overwritten');
        expectInitialization(file_get_contents($project.'/.agents/guidelines/project.md') === 'Custom local routing', 'Edited index was overwritten');
    },
    'creates optional maintainer and a rendered domain skill without overwriting edits' => function (string $project): void {
        $arguments = ['--maintainer', '--skill=project-payroll'];
        [$status, , $error] = runInitializer($project, $arguments);
        expectInitialization($status === 0, $error);
        $profile = $project.'/.agents/guidelines/maintainer.md';
        $skill = $project.'/.ai/skills/project-payroll/SKILL.md';
        expectInitialization(is_file($profile) && is_file($skill), 'Missing optional templates');
        $text = file_get_contents($skill);
        preg_match('/\A---\R(.*?)\R---/s', $text, $frontmatter);
        $metadata = Yaml::parse($frontmatter[1]);
        expectInitialization($metadata['name'] === 'project-payroll', 'Rendered skill name does not match directory');
        expectInitialization(is_string($metadata['description']) && trim($metadata['description']) !== '', 'Missing skill description');
        expectInitialization(! str_contains($text, '{{skill-name}}'), 'Unrendered skill-name placeholder');
        file_put_contents($profile, 'Custom maintainer');
        file_put_contents($skill, 'Custom domain knowledge');
        [$status, , $error] = runInitializer($project, $arguments);
        expectInitialization($status === 0, $error);
        expectInitialization(file_get_contents($profile) === 'Custom maintainer', 'Local profile was overwritten');
        expectInitialization(file_get_contents($skill) === 'Custom domain knowledge', 'Domain skill was overwritten');
    },
    'adds a second domain skill without changing the first' => function (string $project): void {
        [$status] = runInitializer($project, ['--skill=project-payroll']);
        expectInitialization($status === 0, 'First skill setup failed');
        $first = $project.'/.ai/skills/project-payroll/SKILL.md';
        file_put_contents($first, 'Existing payroll rules');
        [$status, , $error] = runInitializer($project, ['--skill=project-scheduling']);
        expectInitialization($status === 0, $error);
        expectInitialization(is_file($project.'/.ai/skills/project-scheduling/SKILL.md'), 'Missing second skill');
        expectInitialization(file_get_contents($first) === 'Existing payroll rules', 'Existing skill was changed');
    },
    'preserves existing file symlinks' => function (string $project): void {
        mkdir($project.'/.agents/guidelines', 0755, true);
        file_put_contents($project.'/local-index.md', 'Existing index');
        symlink('../../local-index.md', $project.'/.agents/guidelines/project.md');
        [$status, , $error] = runInitializer($project);
        expectInitialization($status === 0, $error);
        expectInitialization(is_link($project.'/.agents/guidelines/project.md'), 'Existing file symlink was replaced');
        expectInitialization(file_get_contents($project.'/local-index.md') === 'Existing index', 'Symlink target was changed');
    },
    'refuses directory conflicts before creating files' => function (string $project): void {
        mkdir($project.'/.agents/guidelines/project.md', 0755, true);
        [$status] = runInitializer($project, ['--skill=project-payroll']);
        expectInitialization($status === 1, 'Directory conflict must fail');
        expectInitialization(! file_exists($project.'/.ai'), 'Conflict must be detected before creating optional skills');
        expectInitialization(! file_exists($project.'/.agents/guidelines/project'), 'Conflict must be detected before creating guidelines');
    },
    'refuses symlinked parents without writing through them' => function (string $project): void {
        mkdir($project.'/.ai');
        mkdir($project.'/shared');
        symlink('../shared', $project.'/.ai/skills');
        [$status] = runInitializer($project, ['--skill=project-payroll']);
        expectInitialization($status === 1, 'Symlinked parent must fail');
        expectInitialization(! file_exists($project.'/shared/project-payroll'), 'Symlinked parent was written through');
        expectInitialization(! file_exists($project.'/.agents'), 'Conflict must be detected before creating guidelines');
    },
    'rejects invalid names and options before making changes' => function (string $project): void {
        foreach (['--skill=../escape', '--skill=', '--skill=UpperCase', '--skill=double--hyphen', '--skill='.str_repeat('a', 65), '--force'] as $argument) {
            [$status] = runInitializer($project, [$argument]);
            expectInitialization($status === 1, 'Invalid argument was accepted: '.$argument);
            expectInitialization(! file_exists($project.'/.agents') && ! file_exists($project.'/.ai'), 'Invalid argument caused writes');
        }
    },
    'supports an explicit consumer directory' => function (string $project): void {
        mkdir($project.'/consumer');
        file_put_contents($project.'/consumer/composer.json', '{}');
        [$status, , $error] = runInitializer($project, ['--skill=project-payroll', $project.'/consumer']);
        expectInitialization($status === 0, $error);
        expectInitialization(is_file($project.'/consumer/.agents/guidelines/project.md'), 'Explicit directory was not used');
        expectInitialization(! file_exists($project.'/.agents'), 'Current directory was changed despite explicit target');
    },
    'help and invalid projects leave the filesystem unchanged' => function (string $project): void {
        unlink($project.'/composer.json');
        [$status, $output] = runInitializer($project, ['--help']);
        expectInitialization($status === 0 && str_contains($output, 'Usage:'), 'Help must work without a project');
        [$status] = runInitializer($project);
        expectInitialization($status === 1, 'Invalid project must fail');
        expectInitialization(! file_exists($project.'/.agents'), 'Invalid project was changed');
    },
];

try {
    foreach ($cases as $name => $test) {
        $project = sys_get_temp_dir().'/agent-guidelines-init-'.bin2hex(random_bytes(8));
        mkdir($project);
        file_put_contents($project.'/composer.json', '{}');
        try {
            $test($project);
            echo "PASS: {$name}\n";
        } finally {
            removeInitializerFixture($project);
        }
    }
    printf("Passed %d initializer tests.\n", count($cases));
} catch (Throwable $exception) {
    fwrite(STDERR, 'Test failed: '.$exception->getMessage().PHP_EOL);
    exit(1);
}
