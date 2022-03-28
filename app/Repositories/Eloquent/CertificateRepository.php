<?php
/**
 *  app/Repositories/Eloquent/CategoryRepository.php
 *
 * Date-Time: 07.06.21
 * Time: 17:02
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Repositories\Eloquent;


use App\Models\Certificate;
use App\Repositories\CertificateRepositoryInterface;
use App\Repositories\Eloquent\Base\BaseRepository;



class CertificateRepository extends BaseRepository implements CertificateRepositoryInterface
{

    /**
     * @param Certificate $model
     */
    public function __construct(Certificate $model)
    {
        parent::__construct($model);
    }

}
