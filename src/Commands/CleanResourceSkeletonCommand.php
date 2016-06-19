<?php
/**
 * Created by PhpStorm.
 * User: ayip
 * Date: 6/18/16
 * Time: 10:25 PM
 */

namespace RealPage\Generators\Commands;

use Illuminate\Filesystem\Filesystem;

class CleanResourceSkeletonCommand extends BaseCommand
{
    protected $signature = 'rp:clean-skeleton {name : Name of the model} {--f|force}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleans the resource template files out of the project';
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $resource = ucwords(camel_case($this->argument('name')));
        if ($this->option('force')) {
            $controller = true;
            $model = true;
            $schema = true;
            $repointf = true;
            $repo = true;
            $validator = true;
            $route = true;
        } else {
            $controller = $this->confirm('Remove Controller?', true);
            $model = $this->confirm('Remove example Model?', true);
            $schema = $this->confirm('Remove Schema?', true);
            $repointf = $repo = $this->confirm(
                'Remove Repositories?',
                true
            );
            $validator = $this->confirm('Remove Validator?', true);
            $route = $this->confirm('Remove example route?', true);
        }

        $filesTobeDeleted = [];
        $dirsTobeDeleted = [];

        if ($controller) {
            $filesTobeDeleted[] = "./app/Http/Controllers/{$resource}/{$resource}Controller.php";
            $dirsTobeDeleted[] =  "./app/Http/Controllers/{$resource}";
        }
        if ($model) {
            $filesTobeDeleted[] = "./app/Models/{$resource}/{$resource}.php";
            $dirsTobeDeleted[] = "./app/Models/{$resource}";
        }
        if ($schema) {
            $filesTobeDeleted[] = "./app/Schemas/{$resource}/{$resource}Schema.php";
            $dirsTobeDeleted[] = "./app/Schemas/{$resource}";
        }
        if ($repointf || $repo) {
            $filesTobeDeleted[] = "./app/Repositories/{$resource}/{$resource}RepositoryInterface.php";
            $filesTobeDeleted[] = "./app/Repositories/{$resource}/{$resource}Repository.php";
        }
        if ($validator) {
            $filesTobeDeleted[] = "./app/Http/Middleware/Validators/{$resource}/{$resource}Validator.php";
            $dirsTobeDeleted[] = "./app/Http/Middleware/Validators/{$resource}";
        }
        if ($route) {
            $filesTobeDeleted[] = "./app/Http/Routes/{$resource}Routes.php";
        }

        foreach ($filesTobeDeleted as $file) {
            $this->deleteFile($file);
        }

        foreach ($dirsTobeDeleted as $dir) {
            $this->deleteDirectory($dir);
        }
    }

    private function deleteFile($file)
    {
        $fs = new Filesystem();
        if ($fs->exists($file)) {
            $fs->delete($file);
        }
        return true;
    }
    private function deleteDirectory($dir)
    {
        $fs = new Filesystem();
        if ($fs->exists($dir)) {
            $fs->deleteDirectory($dir);
        }
        return true;
    }
}