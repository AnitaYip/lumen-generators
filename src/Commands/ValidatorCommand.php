<?php
/**
 * Created by PhpStorm.
 * User: ayip
 * Date: 6/18/16
 * Time: 9:52 PM
 */

namespace RealPage\Generators\Commands;


class ValidatorCommand extends BaseCommand
{
    protected $signature = 'rp:validator {name : Name of the model.}';

    protected $description = 'Generates a Validator interface for a RESTful resource';

    public function handle()
    {
        $name = ucwords(camel_case($this->argument('name')));

        $content = $this->getTemplate('validator')
            ->with(['model' => $name, 'modelObj' => strtolower($name)])
            ->get();

        $this->save($content, "./app/Http/Middleware/Validators/{$name}/{$name}Validator.php");

        $this->info("{$name}Validator generated !");
    }

}