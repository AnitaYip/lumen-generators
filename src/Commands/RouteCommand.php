<?php namespace RealPage\Generators\Commands;


class RouteCommand extends BaseCommand {

	protected $signature = 'rp:route
		{name : Name of the resource/model.}';

	protected $description = 'Generates RESTful routes.';

    public function handle()
    {
        $name = ucwords(camel_case($this->argument('name')));

        $content = $this->getTemplate('routes')
            ->with([
                'model' => $name,
                'resource' => strtolower($name),
                'controller' => $name . 'Controller'
            ])
            ->get();

        $this->save($content, "./app/Http/Routes/{$name}Routes.php");

        $this->info("{$name}Routes generated !");
    }

}