<?php
/**
 *  app/Repositories/Eloquent/ProductRepository.php
 *
 * Date-Time: 30.07.21
 * Time: 10:36
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Repositories\Eloquent;


use App\Models\Apartment;
use App\Models\File;
use App\Models\Floor;
use App\Models\Product;
use App\Repositories\ApartmentRepositoryInterface;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\FloorRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

/**
 * Class LanguageRepository
 * @package App\Repositories\Eloquent
 */
class FloorRepository extends BaseRepository implements FloorRepositoryInterface
{

    /**
     * @param Floor $model
     */
    public function __construct(Floor $model)
    {
        parent::__construct($model);
    }

    /**
     * Create new model
     *
     * @param int $id
     * @param $request
     *
     * @return Model
     * @throws \ReflectionException
     */
    public function saveFiles(int $id, $request): Model
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

        $oldPdf = $request->input("old_pdf");
        if (!$oldPdf && $this->model->pdf) {
            $this->model->pdf->delete();
        }

        if ($request->hasFile('pdf')) {
            if ($this->model->pdf()) {
                $this->model->pdf()->delete();
            }
            $filename = date('Ymhs') . str_replace(' ', '', $request->file('pdf')->getClientOriginalName());
            $destination = base_path() . '/storage/app/public/Document/' . $this->model->id;
            $request->file('pdf')->move($destination, $filename);
            $this->model->pdf()->create([
                'title' => $filename,
                'path' => 'storage/Document/' . $this->model->id,
                'format' => $request->file('pdf')->getClientOriginalExtension(),
                'type' => File::FILE_DEFAULT
            ]);
        }

        if ($request->hasFile('images')) {
            // Get Name Of model
            $reflection = new ReflectionClass(get_class($this->model));
            $modelName = $reflection->getShortName();

            foreach ($request->file('images') as $key => $file) {
                $imagename = date('Ymhs') . str_replace(' ', '', $file->getClientOriginalName());
                $destination = base_path() . '/storage/app/public/' . $modelName . '/' . $this->model->id;
                $request->file('images')[$key]->move($destination, $imagename);
                $this->model->files()->create([
                    'title' => $imagename,
                    'path' => 'storage/' . $modelName . '/' . $this->model->id,
                    'format' => $file->getClientOriginalExtension(),
                    'type' => File::FILE_DEFAULT
                ]);
            }
        }

        return $this->model;
    }

}
