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
use App\Models\Product;
use App\Repositories\ApartmentRepositoryInterface;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\ProductRepositoryInterface;

/**
 * Class LanguageRepository
 * @package App\Repositories\Eloquent
 */
class ApartmentRepository extends BaseRepository implements ApartmentRepositoryInterface
{

    /**
     * @param Apartment $model
     */
    public function __construct(Apartment $model)
    {
        parent::__construct($model);
    }

}
