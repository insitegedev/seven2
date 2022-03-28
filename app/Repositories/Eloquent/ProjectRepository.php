<?php
/**
 *  app/Repositories/Eloquent/ProjectRepository.php
 *
 * Date-Time: 30.07.21
 * Time: 10:36
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Repositories\Eloquent;


use App\Models\Project;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\ProjectRepositoryInterface;

/**
 * Class LanguageRepository
 * @package App\Repositories\Eloquent
 */
class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
    /**
     * @param \App\Models\Project $model
     */
    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

}
