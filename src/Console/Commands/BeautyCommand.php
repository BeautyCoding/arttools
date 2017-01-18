<?php

namespace BeautyCoding\ArtTools\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

abstract class BeautyCommand extends Command
{
    /**
     * Filesystem
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Name
     * @var string
     */
    protected $name;

    /**
     * Path
     * @var string
     */
    protected $path;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    public function getRootNamespace()
    {
        return substr($this->laravel->getNamespace(), 0, -1);
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    abstract protected function getDefaultNamespace($rootNamespace): string;

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    abstract protected function getStub(): string;

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace_first($this->laravel->getNamespace(), '', $name);

        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . '.php';
    }

    /**
     * [buildClass description]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function buildClass($name)
    {
        list($name) = array_reverse(explode('\\', $name));

        return $name;
    }

    /**
     * [replaceClassNameSpace description]
     * @param  [type] $name [description]
     * @param  [type] $stub [description]
     * @return [type]       [description]
     */
    public function replaceClassNameSpace($name, $stub)
    {
        $a = $name;
        $name = explode('\\', $name);
        array_pop($name);
        $name = implode('\\', (array) $name);

        return str_replace('DummyClassNamespace', $name, $stub);
    }

    /**
     * [replaceClassName description]
     * @param  [type] $name [description]
     * @param  [type] $stub [description]
     * @return [type]       [description]
     */
    protected function replaceClassName($name, $stub)
    {
        return str_replace('DummyClassName', $name, $stub);
    }

    /**
     * [replaceClass description]
     * @param  [type] $name [description]
     * @param  [type] $stub [description]
     * @return [type]       [description]
     */
    protected function replaceClass($name, $stub)
    {
        return str_replace('DummyClass', $name, $stub);
    }

    /**
     * [replaceRootNamespace description]
     * @param  [type] $name [description]
     * @param  [type] $stub [description]
     * @return [type]       [description]
     */
    protected function replaceRootNamespace($name, $stub)
    {
        return str_replace('DummyRootNamespace', $name, $stub);
    }

    /**
     * [replaceNamespace description]
     * @param  [type] $name [description]
     * @param  [type] $stub [description]
     * @return [type]       [description]
     */
    protected function replaceNamespace($name, $stub)
    {
        return str_replace('DummyNamespace', $name, $stub);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->name = preg_replace('/\//', '\\', $this->argument('name'));
        $this->path = $this->getPath($this->getDefaultNamespace($this->getRootNamespace()) . '/' . $this->name);
        $this->doHandle();

        $this->info($this->name . ' created successfully.');
    }

    /**
     * Determine if the class already exists.
     *
     * @param  string  $name
     * @return bool
     */
    protected function fileExists($path)
    {
        return $this->files->exists($path);
    }

    /**
     * Save file
     * @param  string $content
     */
    public function saveFile($content)
    {
        if (!$this->fileExists($this->path)) {
            $this->makeDirectory($this->path);
            $this->files->put($this->path, $content);
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function doHandle()
    {
        $stub = $this->files->get($this->getStub());

        $stub = $this->replaceClassNameSpace($this->name, $stub);
        $stub = $this->replaceClassName($this->buildClass($this->name), $stub);
        $stub = $this->replaceClass($this->name, $stub);
        $stub = $this->replaceRootNamespace($this->getRootNamespace(), $stub);
        $stub = $this->replaceNamespace($this->getDefaultNamespace($this->getRootNamespace()), $stub);
        $this->saveFile($stub);
    }
}
