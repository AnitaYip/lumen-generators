<?php namespace RealPage\Generators\Commands;


class ResourceCommand extends BaseCommand {

    protected $signature = 'wn:resource
        {name : Name of the resource.}
        {fields : fields description.}
        {--has-many= : hasMany relationships.}
        {--has-one= : hasOne relationships.}
        {--belongs-to= : belongsTo relationships.}
        {--belongs-to-many= : belongsToMany relationships.}
        {--migration-file= : the migration file name.}
        {--parsed : tells the command that arguments have been already parsed. To use when calling the command from an other command and passing the parsed arguments and options}
        ';

    protected $description = 'Generates a model, migration, controller and routes for RESTful resource';

    protected $fields;

    public function handle()
    {
        $this->parseFields();

        $resourceName = $this->argument('name');
        $modelName = ucwords(camel_case($resourceName));
        $tableName = str_plural($resourceName);

        // generating the model
        $this->call('wn:model', [
            'name' => $modelName,
            '--fillable' => $this->fieldsHavingTag('fillable'),
            '--dates' => $this->fieldsHavingTag('date'),
            '--has-many' => $this->option('has-many'),
            '--has-one' => $this->option('has-one'),
            '--belongs-to' => $this->option('belongs-to'),
            '--belongs-to-many' => $this->option('belongs-to-many'),
            '--rules' => $this->rules(),
            '--path' => 'app',
            '--parsed' => true
        ]);
        
        
        // generating the controller and routes
        $this->call('wn:controller', [
            'model' => $modelName,
            '--no-routes' => false
        ]);


    }

    protected function parseFields()
    {
        $fields = $this->argument('fields');
        if($this->option('parsed')){
            $this->fields = $fields;
        } else {
            if(! $fields){
                $this->fields = [];
            } else {
                $this->fields = $this->getArgumentParser('fields')
                    ->parse($fields);
            }
            $this->fields = array_merge($this->fields, array_map(function($name) {
                return [
                    'name' => $name,
                    'schema' => [
                        ['name' => 'integer', 'args' => []],
                        ['name' => 'unsigned', 'args' => []]
                    ],
                    'rules' => 'required|numeric',
                    'tags' => ['fillable', 'key'],
                    'factory' => 'key' 
                ];
            }, $this->foreignKeys()));
        } 

    }
    
    protected function fieldsHavingTag($tag)
    {
        return array_map(function($field){
            return $field['name'];
        }, array_filter($this->fields, function($field) use($tag){
            return in_array($tag, $field['tags']);
        }));
    }

    protected function rules()
    {
        return array_map(function($field){
            return [
                'name' => $field['name'],
                'rule' => $field['rules']
            ];
        }, array_filter($this->fields, function($field){
            return !empty($field['rules']);
        }));
    }

    protected function schema()
    {
        return array_map(function($field){
            return array_merge([[
                'name' => $field['name'],
                'args' => []
            ]], $field['schema']);
        }, $this->fields);
    }

    protected function foreignKeys()
    {
        $belongsTo = $this->option('belongs-to');
        if(! $belongsTo) {
            return [];
        }
        $relations = $this->getArgumentParser('relations')->parse($belongsTo);
        return array_map(function($relation){
            $name = $relation['model'] ? $relation['model'] : $relation['name'];
            $index = strrpos($name, "\\");
            if($index) {
                $name = substr($name, $index + 1);
            }
            return snake_case(str_singular($name)) . '_id';
        }, $relations);
    }

    protected function migrationKeys() {
        return array_map(function($name) {
            return [
                'name' => $name,
                'column' => '',
                'table' => '',
                'on_delete' => '',
                'on_update' => ''
            ];
        }, $this->foreignKeys());
    }

    protected function factoryFields()
    {
        return array_map(function($field){
            return [
                'name' => $field['name'],
                'type' => $field['factory']
            ];
        }, array_filter($this->fields, function($field){
            return isset($field['factory']) && $field['factory'];
        }));
    }

}
