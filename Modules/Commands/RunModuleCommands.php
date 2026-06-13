<?php

namespace Modules\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class RunModuleCommands extends Command
{
    protected $signature = 'run:modules {--fresh : Delete all modules first, then recreate from scratch}';
    protected $description = 'Run all make:module / make:table commands from command.txt — skips already-created modules';

    public function handle()
    {
        $filePath = base_path('command.txt');

        if (!file_exists($filePath)) {
            $this->error("command.txt not found at project root.");
            return 1;
        }

        $commands = $this->parseCommands($filePath);

        if ($this->option('fresh')) {
            $this->runFresh($commands);
        }

        $this->runCommands($commands);
        return 0;
    }

    // ─────────────────────────────────────────────────────────────────────
    // Fresh mode — delete everything first, then recreate
    // ─────────────────────────────────────────────────────────────────────

    private function runFresh(array $commands): void
    {
        $total = count($commands);
        $this->warn("=== FRESH MODE: Deleting {$total} modules ===");

        foreach (array_reverse($commands) as $i => $cmd) {
            $num        = $total - $i;
            $moduleName = $this->extractModuleName($cmd);
            if (!$moduleName) continue;

            if (str_contains($cmd, 'make:module')) {
                $withVue = str_contains($cmd, '--vue');
                $this->warn("[{$num}/{$total}] Deleting: {$moduleName}");
                $args = ['module_name' => $moduleName, '--force' => true];
                if ($withVue) $args['--vue'] = true;
                $this->call('delete:module', $args);
            }

            if (str_contains($cmd, 'make:table')) {
                $this->deleteTableFiles($moduleName);
                $this->warn("[{$num}/{$total}] Deleted table files: {$moduleName}");
            }
        }

        $this->newLine();
        $this->info("=== All deleted. Starting fresh run... ===");
        $this->newLine();
    }

    private function deleteTableFiles(string $moduleName): void
    {
        $parts     = explode('/', $moduleName);
        $finalName = array_pop($parts);
        $groupPath = implode('/', $parts);
        $tableName = Str::plural(Str::snake($finalName));

        $migFile   = base_path("Modules/Management/{$groupPath}/Database/Migrations/create_{$tableName}_table.php");
        $modelFile = base_path("Modules/Management/{$groupPath}/Database/Models/{$finalName}Model.php");

        if (file_exists($migFile))   File::delete($migFile);
        if (file_exists($modelFile)) File::delete($modelFile);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Normal run — skip existing, call artisan directly (no shell quoting issues)
    // ─────────────────────────────────────────────────────────────────────

    private function runCommands(array $commands): void
    {
        $total   = count($commands);
        $done    = 0;
        $skipped = 0;
        $failed  = 0;

        foreach ($commands as $i => $cmd) {
            $num = $i + 1;

            if ($this->alreadyExists($cmd)) {
                $this->warn("[{$num}/{$total}] Skipped (exists): " . $this->extractModuleName($cmd));
                $skipped++;
                continue;
            }

            $parsed = $this->parseArtisanCommand($cmd);
            if (!$parsed) {
                $this->error("[{$num}/{$total}] Could not parse: {$cmd}");
                $failed++;
                continue;
            }

            $this->info("[{$num}/{$total}] Running: {$parsed['command']} {$parsed['module_name']}");

            try {
                $exitCode = $this->call($parsed['command'], $parsed['args']);
                if ($exitCode === 0) {
                    $done++;
                } else {
                    $this->error("[{$num}/{$total}] Failed (exit {$exitCode}): {$parsed['module_name']}");
                    $failed++;
                }
            } catch (\Throwable $e) {
                $this->error("[{$num}/{$total}] Exception: " . $e->getMessage());
                $failed++;
            }
        }

        $this->newLine();
        $this->info("Finished — Done: {$done}  Skipped: {$skipped}  Failed: {$failed}  Total: {$total}");
    }

    // ─────────────────────────────────────────────────────────────────────
    // Parse "php artisan make:module Name "[fields]" --vue" into args array
    // ─────────────────────────────────────────────────────────────────────

    private function parseArtisanCommand(string $cmd): ?array
    {
        // Extract: artisan_command  module_name  "[fields]"  --flags
        if (!preg_match('/artisan\s+([\w:]+)\s+([\w\/]+)\s*(?:"?(\[[^\]]*\])"?)?\s*(.*)?$/', $cmd, $m)) {
            return null;
        }

        $command    = $m[1];                   // make:module / make:table
        $moduleName = $m[2];                   // ProductManagement/Product
        $fields     = isset($m[3]) ? trim($m[3], '"') : null;   // [field:type,...] — strip surrounding quotes
        $flags      = isset($m[4]) ? trim($m[4]) : '';

        $args = ['module_name' => $moduleName];

        if ($fields) {
            $args['[field]'] = $fields;
        }

        if (str_contains($flags, '--vue')) {
            $args['--vue'] = true;
        }

        if (str_contains($flags, '--model')) {
            $args['--model'] = true;
        }

        return ['command' => $command, 'module_name' => $moduleName, 'args' => $args];
    }

    // ─────────────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────────────

    private function parseCommands(string $filePath): array
    {
        $commands = [];

        foreach (file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $trimmed = trim($line);

            if (
                $trimmed === '' ||
                str_starts_with($trimmed, '#') ||
                str_starts_with($trimmed, '//') ||
                str_starts_with($trimmed, '/*') ||
                str_starts_with($trimmed, '|') ||
                str_starts_with($trimmed, '*') ||
                str_starts_with($trimmed, '*/')
            ) {
                continue;
            }

            $commands[] = $trimmed;
        }

        return $commands;
    }

    private function alreadyExists(string $cmd): bool
    {
        $moduleName = $this->extractModuleName($cmd);
        if (!$moduleName) return false;

        if (str_contains($cmd, 'make:module')) {
            return is_dir(base_path("Modules/Management/{$moduleName}"));
        }

        if (str_contains($cmd, 'make:table')) {
            $parts     = explode('/', $moduleName);
            $finalName = array_pop($parts);
            $groupPath = implode('/', $parts);
            $tableName = Str::plural(Str::snake($finalName));
            $migFile   = base_path("Modules/Management/{$groupPath}/Database/Migrations/create_{$tableName}_table.php");
            return file_exists($migFile);
        }

        return false;
    }

    private function extractModuleName(string $cmd): ?string
    {
        if (preg_match('/artisan\s+(?:make:module|make:table)\s+([\w\/]+)/', $cmd, $m)) {
            return $m[1];
        }
        return null;
    }
}
