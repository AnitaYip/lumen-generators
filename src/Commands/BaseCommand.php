<?php namespace RealPage\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
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
                'staticModel' => strtoupper(self::toSnakeCase($args['name'])),
                'functionName' => strtolower(self::toSnakeCase($args['name']))
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

    /**
     * Translates a camel case string into a string with underscores (e.g. firstName -&gt; first_name)
     *
     * @param    string   $str   String in camel case format
     * @return   string   $str   Translated into underscore format
     */
    public static function toSnakeCase($str)
    {
        $str[0] = strtolower($str[0]);
        $func = create_function('$c', 'return "_" . strtolower($c[1]);');
        return preg_replace_callback('/([A-Z,0-9])/', $func, $str);
    }

    /**
     * Translates a string with underscores into camel case (e.g. first_name -&gt; firstName)
     *
     * @param    string   $str                       String in underscore format
     * @param    bool     $capitalise_first_char     If true, capitalise the first char in $str
     * @return   string                              $str translated into camel caps
     */
    public static function toCamelCase($str, $capitalise_first_char = false)
    {
        if ($capitalise_first_char) {
            $str[0] = strtoupper($str[0]);
        }
        $func = create_function('$c', 'return strtoupper($c[1]);');
        return preg_replace_callback('/_([a-z,0-9])/', $func, $str);
    }
}