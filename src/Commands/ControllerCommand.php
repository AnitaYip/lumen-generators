<?php namespace RealPage\Generators\Commands;


class ControllerCommand extends BaseCommand {

	protected $signature = 'rp:controller
        {name : Name of the model}';

	protected $description = 'Generates RESTful controller using the ApiController trait';

    public function handle()
    {
    	$name = ucwords(camel_case($this->argument('name')));

        $controller = $name . 'Controller';
        $content = $this->getTemplate('controller')
        	->with([
        		'model' => $name
        	])
        	->get();

        $this->save($content, "./app/Http/Controllers/{$name}/{$controller}.php");

        $this->info("{$controller} generated !");

    }

}