<?php

namespace BeautyCoding\ArtTools\Console\Commands;

use BeautyCoding\ArtTools\Console\Commands\BeautyCommand;
use Illuminate\Console\Command;
use Illuminate\Foundation\Console\Artisan;

class MakeBeautyControllerCommand extends BeautyCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'beauty:controller {name} {--full} {--model} {--body}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make resource controller with proper requests.';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Http\Controllers';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return resource_path('/vendor/arttools/stubs/controllers/controller.full.stub');
    }

    /**
     * Create Request pack
     * @param  string $namespace
     */
    public function createRequests($namespace)
    {
        $needle = [
            'IndexRequest',
            'CreateRequest',
            'StoreRequest',
            'ShowRequest',
            'EditRequest',
            'UpdateRequest',
            'DestroyRequest',
        ];

        foreach ($needle as $requestName) {
            \Artisan::call('beauty:request', [
                'name' => sprintf('%s/%s', $namespace, $requestName),
            ]);
        }

        \Artisan::call('beauty:request', [
            'name' => 'Request',
            '--base' => true,
        ]);

    }

    /**
     * Create model
     * @param  string $name
     */
    public function createModel($name)
    {
        \Artisan::call('beauty:model', [
            'name' => $name,
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function doHandle()
    {
        $this->createRequests($this->argument('name'));

        if ($this->option('full') || $this->option('model')) {
            $this->createModel(str_replace("Controller", "", $this->buildClass($this->name)));
        }
        if ($this->option('full') || $this->option('body')) {
        }

        parent::doHandle();
    }
}
