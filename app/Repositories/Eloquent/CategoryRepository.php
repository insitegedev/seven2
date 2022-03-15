<?php
/**
 *  app/Repositories/Eloquent/CategoryRepository.php
 *
 * Date-Time: 07.06.21
 * Time: 17:02
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Repositories\Eloquent;


use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\Eloquent\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class LanguageRepository
 * @package App\Repositories\Eloquent
 */
class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * CategoryRepository constructor.
     *
     * @param \App\Models\Category $model
     */
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getCategory($category_id){
        return $this->model->distinct()->select(DB::raw("*, (SELECT GROUP_CONCAT(cd1.title ORDER BY `level` SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM category_path cp LEFT JOIN category_translations cd1 ON (cp.path_id = cd1.category_id AND cp.category_id != cp.path_id) WHERE cp.category_id = c.id AND cd1.locale = 'ge' GROUP BY cp.category_id) AS path"))
            ->from(DB::raw("categories c"))
            ->leftJoin(DB::raw('category_translations cd2'),'c.id','cd2.category_id')
            ->where('c.id',$category_id)
            ->where('cd2.locale','ge')->first();
    }

    public function getCategories($filter_data){

        //$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.title ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.position FROM category_path cp LEFT JOIN categories c1 ON (cp.category_id = c1.id) LEFT JOIN categories c2 ON (cp.path_id = c2.id) LEFT JOIN category_translations cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN category_translations cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.locale = 'ge' AND cd2.locale = 'ge'";

        $query = $this->model->select(DB::raw("cp.category_id AS category_id, GROUP_CONCAT(cd1.title ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.position"))
            ->from(DB::raw('category_path cp'))
            ->leftJoin(DB::raw('categories c1'),'cp.category_id','c1.id')
            ->leftJoin(DB::raw('categories c2'),'cp.path_id','c2.id')
            ->leftJoin(DB::raw('category_translations cd1'),'cp.path_id','cd1.category_id')
            ->leftJoin(DB::raw('category_translations cd2'),'cp.category_id','cd2.category_id');
            //->where('cd1.locale','ge')
            //->where('cd2.locale','ge');

        if (!empty($filter_data['filter_name'])) {

            $query->where('cd2.title','like','%'.$filter_data['filter_name'].'%');
            //$sql .= " AND cd2.title LIKE '%" . $filter_data['filter_name']. "%'";
        }

        $query->groupBy('cp.category_id');
        //$sql .= " GROUP BY cp.category_id";

        $sort_data = array(
            'title',
            'position'
        );

        if (isset($filter_data['order']) && ($filter_data['order'] == 'DESC')) {
            $ord = "desc";
        } else {
            $ord = "asc";
        }

        if (isset($filter_data['sort']) && in_array($filter_data['sort'], $sort_data)) {
            //$sql .= " ORDER BY " . $data['sort'];
            $query->orderBy($filter_data['sort'],$ord);
        } else {
            //$sql .= " ORDER BY position";
            $query->orderBy('position',$ord);
        }



        if (isset($filter_data['start']) || isset($filter_data['limit'])) {
            if ($filter_data['start'] < 0) {
                $filter_data['start'] = 0;
            }

            if ($filter_data['limit'] < 1) {
                $filter_data['limit'] = 20;
            }

            $query->limit($filter_data['limit']);
            $query->offset($filter_data['start']);
            //$sql .= " LIMIT " . (int)$filter_data['start'] . "," . (int)$filter_data['limit'];

        }



        $data = $query->get();

        //dd($query);

        return $data;
    }

}
