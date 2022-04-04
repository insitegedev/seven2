<?php
/**
 *  app/Repositories/Eloquent/ProductRepository.php
 *
 * Date-Time: 30.07.21
 * Time: 10:36
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Repositories\Eloquent;


use App\Models\Product;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\ProductRepositoryInterface;

/**
 * Class LanguageRepository
 * @package App\Repositories\Eloquent
 */
class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    /**
     * @param \App\Models\Product $model
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getPopularProducts(){
        $products = $this->model->where('popular',1)->whereHas('categories',function ($query){
            $query->where('status',1);
        })->with(['latestImage'])->inRandomOrder()->get();

        //dd($products);
        return $products;
    }

}
