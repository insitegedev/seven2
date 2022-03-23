<?php
/**
 *  app/Repositories/Eloquent/ProductRepository.php
 *
 * Date-Time: 30.07.21
 * Time: 10:36
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Repositories\Eloquent;


use App\Models\File;
use App\Models\PageSection;
use App\Models\Product;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use ReflectionClass;

/**
 * Class LanguageRepository
 * @package App\Repositories\Eloquent
 */
class PageSectionRepository extends BaseRepository implements ProductRepositoryInterface
{
    /**
     * @param \App\Models\Product $model
     */
    public function __construct(PageSection $model)
    {
        parent::__construct($model);
    }


    public function saveFile(int $id, $request): Model
    {
        //dd($this->model->file);

        foreach ($request->file('image') as $key => $file){
            $model = $this->model->where('id',$key)->first();

            if ($model->file){
                Storage::delete($model->file->getFileUrlAttribute());
                $model->file->delete();
            }


        }

        // Delete old files if exist
        /*if (count($this->model->files)) {
            foreach ($this->model->files as $file) {
                if (!$request->old_images) {
                    $file->delete();
                    continue;
                }
                if (!in_array((string)$file->id, $request->old_images, true)) {
                    $file->delete();
                }
            }
        }*/

        if ($request->hasFile('image')) {
            // Get Name Of model
            $reflection = new ReflectionClass(get_class($this->model));
            $modelName = $reflection->getShortName();

            //dd($modelName);

            foreach ($request->file('image') as $key => $file) {
                $imagename = date('Ymhs') . str_replace(' ', '', $file->getClientOriginalName());
                $destination = base_path() . '/storage/app/public/' . $modelName . '/' . $key;
                $request->file('image')[$key]->move($destination, $imagename);
                $model = $this->model->where('id',$key)->first();
                $model->file()->create([
                    'title' => $imagename,
                    'path' => 'storage/' . $modelName . '/' . $key,
                    'format' => $file->getClientOriginalExtension(),
                    'type' => File::FILE_DEFAULT
                ]);
            }
        }

        return $this->model;
    }

}
