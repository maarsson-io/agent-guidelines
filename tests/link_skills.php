<?php

declare(strict_types=1);

/**
 * Invoke the real CLI in an isolated consumer directory without booting Laravel.
 *
 * @param string $project
 * @param list<string> $arguments
 * @return array{int, string, string}
 * @throws RuntimeException
 */
function runLinkCommand(string $project, array $arguments = []): array
{
    $command = [PHP_BINARY, dirname(__DIR__).'/bin/agent-guidelines-link-skills', ...$arguments];
    $process = proc_open($command, [1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes, $project);
    if (! is_resource($process)) {
        throw new RuntimeException('Cannot start CLI test');
    }
    $output = stream_get_contents($pipes[1]);
    $error = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);

    return [proc_close($process), $output, $error];
}

/**
 * Fail on an observable behavior that differs from the expected contract.
 *
 * @param bool $condition
 * @param string $message
 * @return void
 * @throws RuntimeException
 */
function expectLinkBehavior(bool $condition, string $message): void
{
    if (! $condition) {
        throw new RuntimeException($message);
    }
}

/**
 * Remove only the temporary fixture, without following directory symlinks.
 *
 * @param string $project
 * @return void
 */
function removeLinkFixture(string $project): void
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
    'creates relative links and preserves skills on repeat runs' => function (string $project): void {
        mkdir($project.'/.agents/skills/custom', 0755, true);
        file_put_contents($project.'/.agents/skills/custom/SKILL.md', 'existing custom skill');
        mkdir($project.'/.agents/skills/boost-generated');
        file_put_contents($project.'/.agents/skills/boost-generated/SKILL.md', 'existing generated skill');
        for ($run = 0; $run < 2; $run++) {
            [$status, , $error] = runLinkCommand($project);
            expectLinkBehavior($status === 0, $error);
            foreach (['.claude', '.github'] as $directory) {
                expectLinkBehavior(readlink($project.'/'.$directory.'/skills') === '../.agents/skills', 'Missing relative link');
                expectLinkBehavior(file_get_contents($project.'/'.$directory.'/skills/custom/SKILL.md') === 'existing custom skill', 'Custom skill was changed');
                expectLinkBehavior(file_get_contents($project.'/'.$directory.'/skills/boost-generated/SKILL.md') === 'existing generated skill', 'Generated skill was changed');
            }
        }
    },
    'refuses real skill directories before making changes' => function (string $project): void {
        mkdir($project.'/.github/skills', 0755, true);
        file_put_contents($project.'/.github/skills/keep.md', 'keep this');
        [$status] = runLinkCommand($project);
        expectLinkBehavior($status === 1, 'Directory conflict must fail');
        expectLinkBehavior(file_get_contents($project.'/.github/skills/keep.md') === 'keep this', 'Existing directory was changed');
        expectLinkBehavior(! file_exists($project.'/.agents') && ! file_exists($project.'/.claude'), 'Conflict must be detected before creating destinations');
    },
    'refuses incorrect links without replacing them' => function (string $project): void {
        mkdir($project.'/.github');
        symlink('../other-skills', $project.'/.github/skills');
        [$status] = runLinkCommand($project);
        expectLinkBehavior($status === 1, 'Incorrect symlink must fail');
        expectLinkBehavior(readlink($project.'/.github/skills') === '../other-skills', 'Incorrect symlink was replaced');
        expectLinkBehavior(! file_exists($project.'/.agents'), 'Conflict must be detected before creating the canonical directory');
    },
    'retains correct dangling links and creates their target' => function (string $project): void {
        mkdir($project.'/.claude');
        symlink('../.agents/skills', $project.'/.claude/skills');
        [$status, , $error] = runLinkCommand($project);
        expectLinkBehavior($status === 0, $error);
        expectLinkBehavior(is_dir($project.'/.claude/skills'), 'Correct dangling link was not made usable');
    },
    'accepts correct absolute links without rewriting them' => function (string $project): void {
        mkdir($project.'/.agents/skills', 0755, true);
        mkdir($project.'/.claude');
        symlink($project.'/.agents/skills', $project.'/.claude/skills');
        [$status, , $error] = runLinkCommand($project);
        expectLinkBehavior($status === 0, $error);
        expectLinkBehavior(readlink($project.'/.claude/skills') === $project.'/.agents/skills', 'Correct absolute link was rewritten');
    },
    'refuses files at skill destinations' => function (string $project): void {
        mkdir($project.'/.claude');
        file_put_contents($project.'/.claude/skills', 'keep file');
        [$status] = runLinkCommand($project);
        expectLinkBehavior($status === 1, 'File conflict must fail');
        expectLinkBehavior(file_get_contents($project.'/.claude/skills') === 'keep file', 'Existing file was changed');
    },
    'refuses symlinked parent directories' => function (string $project): void {
        mkdir($project.'/shared');
        symlink('shared', $project.'/.github');
        [$status] = runLinkCommand($project);
        expectLinkBehavior($status === 1, 'Symlinked parent must fail');
        expectLinkBehavior(! file_exists($project.'/shared/skills'), 'Symlinked parent was written through');
    },
    'supports an explicit project directory' => function (string $project): void {
        mkdir($project.'/consumer');
        file_put_contents($project.'/consumer/composer.json', '{}');
        [$status, , $error] = runLinkCommand($project, [$project.'/consumer']);
        expectLinkBehavior($status === 0, $error);
        expectLinkBehavior(is_link($project.'/consumer/.github/skills'), 'Explicit project was not used');
        expectLinkBehavior(! file_exists($project.'/.agents'), 'Current directory was changed despite explicit target');
    },
    'help and invalid projects do not create files' => function (string $project): void {
        unlink($project.'/composer.json');
        [$status, $output] = runLinkCommand($project, ['--help']);
        expectLinkBehavior($status === 0 && str_contains($output, 'Usage:'), 'Help must succeed without a project');
        [$status] = runLinkCommand($project);
        expectLinkBehavior($status === 1, 'Missing composer.json must fail');
        expectLinkBehavior(! file_exists($project.'/.agents'), 'Invalid project was changed');
    },
];

try {
    foreach ($cases as $name => $test) {
        $project = sys_get_temp_dir().'/agent-guidelines-links-'.bin2hex(random_bytes(8));
        mkdir($project);
        file_put_contents($project.'/composer.json', '{}');
        try {
            $test($project);
            echo "PASS: {$name}\n";
        } finally {
            removeLinkFixture($project);
        }
    }
    printf("Passed %d CLI tests.\n", count($cases));
} catch (Throwable $exception) {
    fwrite(STDERR, 'Test failed: '.$exception->getMessage().PHP_EOL);
    exit(1);
}
