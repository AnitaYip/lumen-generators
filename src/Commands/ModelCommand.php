<?php namespace RealPage\Generators\Commands;


class ModelCommand extends BaseCommand {

	protected $signature = 'rp:model {name : Name of the model.}';

	protected $description = 'Generates a model class for a RESTful resource';

    public function handle()
    {
        $name = ucwords(camel_case($this->argument('name')));

        $content = $this->getTemplate('model')
            ->with(['name' => $name])
            ->get();

        $this->save($content, "app/Models/{$name}/{$name}.php");

        $this->info("{$name} model generated !");
    }
}
