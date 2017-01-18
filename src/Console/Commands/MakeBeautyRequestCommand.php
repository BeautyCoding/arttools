<?php

namespace BeautyCoding\ArtTools\Console\Commands;

use BeautyCoding\ArtTools\Console\Commands\BeautyCommand;
use Illuminate\Console\Command;

class MakeBeautyRequestCommand extends BeautyCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'beauty:request {name} {--base}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make requests for beauty:controller.';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Http\Requests';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        if ($this->option('base')) {
            return resource_path('vendor/arttools/stubs/requests/request.base.stub');
        }

        return resource_path('/vendor/arttools/stubs/requests/request.full.stub');
    }
}
