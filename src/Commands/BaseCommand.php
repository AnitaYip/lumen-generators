<?php namespace RealPage\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use RealPage\EnterpriseServices\Helpers\StringFormat;
use RealPage\Generators\Template\TemplateLoader;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class BaseCommand extends Command {

    protected $fs;
    protected $templates;

    public function __construct(Filesystem $fs)
    {
        parent::__construct();

        $this->fs = $fs;
        $this->templates = new TemplateLoader($fs);
    }

    protected function handle()
    {
        $resourceName = $this->argument('name');
        $name = ucwords(camel_case($resourceName));
        $dir = $this->argument('dir') ?? $name;
        $module = $this->argument('module');

        return compact('name', 'dir', 'module');
    }

    protected function getTemplate($name)
    {
        return $this->templates->load($name);
    }

    protected function save($content, $path)
    {
        $this->makeDirectory($path);
        $this->fs->put($path, $content);
    }

    protected function makeDirectory($path)
    {
        if (!$this->fs->isDirectory(dirname($path))) {
            $this->fs->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    public function writeToTemplate($templateName, $args, $pathPrefix, $classSuffix)
    {
        $content = $this->getTemplate($templateName)
            ->with([
                'model' => $args['name'],
                'dir'   => $args['dir'],
                'modelObj' => camel_case($args['name']),
                'resource' => strtolower($args['name']),
                'controller' => $args['name'] . 'Controller',
                'staticModel' => strtoupper(StringFormat::toSnakeCase($args['name'])),
                'functionName' => strtolower(StringFormat::toSnakeCase($args['name']))
            ])
            ->get();

        $path = $this->buildPath($args);

        $this->save($content, $path . $pathPrefix . "/{$args['dir']}/{$args['name']}$classSuffix.php");

        $this->info("{$args['name']}$classSuffix generated !");
    }

    public function buildPath($args)
    {
        $path = explode("/", base_path());
        array_pop($path);
        $path = implode("/", $path) . "/" . $args['module'];
        return $path;
    }

    public function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the Entity.'],
            ['module', InputArgument::REQUIRED, 'Module to store the files'],
            ['dir', InputArgument::OPTIONAL, 'Directory to store the files'],
        ];
    }

    public function getOptions()
    {
        return [
            ['--f|force', null, InputOption::VALUE_OPTIONAL, 'To skip the prompting before deletion.', null],
        ];
    }
}