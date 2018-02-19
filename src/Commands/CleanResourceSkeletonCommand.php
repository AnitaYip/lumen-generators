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
    protected $name = 'rp:clean-skeleton';
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
        $args = parent::handle();
        $name = $args['name'];
        $dir = $args['dir'];

        if ($this->option('force')) {
            $controller = $model = $schema = $repointf = $repo = $validator = $route = true;
        } else {
            $controller = $this->confirm('Remove Controller?', true);
            $model = $this->confirm('Remove example Model?', true);
            $schema = $this->confirm('Remove Schema?', true);
            $repointf = $repo = $this->confirm(
                'Remove Repositories?',
                true
            );
            $validator = $this->confirm('Remove Validator?', true);
            $route = $this->confirm('Remove Route?', true);
        }

        $filesTobeDeleted = [];
        $dirsTobeDeleted = [];

        $path = parent::buildPath($args);

        if ($controller) {
            $filesTobeDeleted[] = $path . "/src/Http/Controllers/{$dir}/{$name}Controller.php";
            $dirsTobeDeleted[] =  $path . "/src/Http/Controllers/{$dir}";
        }
        if ($model) {
            $filesTobeDeleted[] = $path . "/src/Models/{$dir}/{$name}.php";
            $dirsTobeDeleted[] = $path . "/src/Models/{$dir}";
        }
        if ($schema) {
            $filesTobeDeleted[] = $path . "/src/Schemas/{$dir}/{$name}Schema.php";
            $dirsTobeDeleted[] = $path . "/src/Schemas/{$dir}";
        }
        if ($repointf || $repo) {
            $filesTobeDeleted[] = $path . "/src/Repositories/{$dir}/{$name}RepositoryInterface.php";
            $filesTobeDeleted[] = $path . "/src/Repositories/{$dir}/{$name}Repository.php";
            $dirsTobeDeleted[] = $path . "/src/Repositories/{$dir}";
        }
        if ($validator) {
            $filesTobeDeleted[] = $path . "/src/Http/Middleware/Validators/{$dir}/{$name}Validator.php";
            $dirsTobeDeleted[] = $path . "/src/Http/Middleware/Validators/{$dir}";
        }
        if ($route) {
            $filesTobeDeleted[] = $path . "/src/Http/Routes/{$name}Routes.php";
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