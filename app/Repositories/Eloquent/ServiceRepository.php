<?php
/**
 *  app/Repositories/Eloquent/ServiceRepository.php
 *
 * Date-Time: 06.08.21
 * Time: 14:58
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Repositories\Eloquent;


use App\Models\File;
use App\Models\Service;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\ServiceRepositoryInterface;
use Illuminate\Http\Request;

class ServiceRepository extends BaseRepository implements ServiceRepositoryInterface
{
    /**
     * @param Service $model
     */
    public function __construct(Service $model)
    {
        parent::__construct($model);
    }

    public function saveFile(int $id, Request $request): Service
    {

        $this->model = $this->findOrFail($id);

        // Delete old files if exist
        if (count($this->model->files)) {
            foreach ($this->model->files as $file) {
                if (!$request->old_images) {
                    $file->delete();
                    continue;
                }
                if (!in_array((string)$file->id, $request->old_images, true)) {
                    $file->delete();
                }
            }
        }

        $oldMain = $request->input("old_main_image_1");
        if (!$oldMain && $this->model->mainFile_1) {
            $this->model->mainFile_1->delete();
        }

        $oldMain = $request->input("old_main_image_2");
//        dd($oldMain);

        if (!$oldMain && $this->model->mainFIle_2) {
            $this->model->mainFile_2->delete();
        }


        if ($request->hasFile('main-image-1')) {
            // Get Name Of model
            $image = $request->file('main-image-1');
            $imagename = date('Ymhs') . str_replace(' ', '', $image->getClientOriginalName());
            $destination = base_path() . '/storage/app/public/' . 'Gallery' . '/' . $this->model->id;
            $image->move($destination, $imagename);
            $this->model->files()->create([
                'title' => $imagename,
                'path' => 'storage/' . 'Gallery' . '/' . $this->model->id,
                'format' => $image->getClientOriginalExtension(),
                'type' => File::FILE_MAIN_1
            ]);
        }

        if ($request->hasFile('main-image-2')) {
            // Get Name Of model
            $image = $request->file('main-image-2');
            $imagename = date('Ymhs') . str_replace(' ', '', $image->getClientOriginalName());
            $destination = base_path() . '/storage/app/public/' . 'Gallery' . '/' . $this->model->id;
            $image->move($destination, $imagename);
            $this->model->files()->create([
                'title' => $imagename,
                'path' => 'storage/' . 'Gallery' . '/' . $this->model->id,
                'format' => $image->getClientOriginalExtension(),
                'type' => File::FILE_MAIN_2
            ]);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $file) {
                $imagename = date('Ymhs') . str_replace(' ', '', $file->getClientOriginalName());
                $destination = base_path() . '/storage/app/public/' . 'Gallery' . '/' . $this->model->id;
                $request->file('images')[$key]->move($destination, $imagename);
                $this->model->files()->create([
                    'title' => $imagename,
                    'path' => 'storage/' . 'Gallery' . '/' . $this->model->id,
                    'format' => $file->getClientOriginalExtension(),
                    'type' => File::FILE_DEFAULT
                ]);
            }
        }


        return $this->model;
    }


}
