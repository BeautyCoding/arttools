<?php

namespace BeautyCoding\ArtTools\Console\Commands;

use BeautyCoding\ArtTools\Console\Commands\BeautyCommand;
use Illuminate\Console\Command;

class MakeBeautyModelCommand extends BeautyCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'beauty:model {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make model for beauty:controller.';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Models';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return resource_path('/vendor/arttools/stubs/models/model.full.stub');
    }
}
