<?php
/**
 *  app/Http/Controllers/Admin/CategoryController.php
 *
 * Date-Time: 30.07.21
 * Time: 09:18
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Models\Language;
use App\Models\Translations\CategoryTranslation;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\Eloquent\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{


    /**
     * @var \App\Repositories\CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @param \App\Repositories\CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(CategoryRequest $request)
    {
//        dd($languages = Language::where('status' ,true)->pluck('title', 'locale'));
        return view('admin.nowa.views.categories.index', [
            'data' => $this->categoryRepository->getData($request, ['translations'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $category = $this->categoryRepository->model;

        $url = locale_route('category.store', [], false);
        $method = 'POST';

        return view('admin.nowa.views.categories.form', [
            'data' => $category,
            'url' => $url,
            'method' => $method,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(CategoryRequest $request)
    {
       // dd($request->all());
        $saveData = Arr::except($request->except('_token','path'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        $saveData['parent_id'] = $saveData['parent_id'] ? $saveData['parent_id'] : null;

        //dd($saveData);
        $category = $this->categoryRepository->create($saveData);

        $level = 0;

        $data = DB::table('category_path')->select('*')
            ->where('category_id',$request->post('parent_id'))->orderBy('level','asc')->get();
        //$query = $this->db->query("SELECT * FROM `category_path` WHERE category_id = '" . (int)$this->input->post('parent_id') . "' ORDER BY `level` ASC");

        foreach ($data as $result) {
            DB::table('category_path')
                ->insert(['category_id' => $category->id,'path_id' => $result->path_id,'level' => $level]);
            //$this->db->query("INSERT INTO `category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

            $level++;
        }

        DB::table('category_path')
            ->insert(['category_id' => $category->id,'path_id' => $category->id,'level' => $level]);
        //$this->db->query("INSERT INTO `category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', `level` = '" . (int)$level . "'");

        return redirect(locale_route('category.show', $category->id))->with('success', __('admin.create_successfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(string $locale, Category $category)
    {
        return view('admin.pages.category.show', [
            'category' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(string $locale, Category $category, CategoryRepository $categoryRepository)
    {
        $url = locale_route('category.update', $category->id, false);
        $method = 'PUT';

        $cat = $categoryRepository->getCategory($category->id);
        //dd($cat);
        $category['path'] = $cat->path;

        return view('admin.nowa.views.categories.form', [
            'data' => $category,
            'url' => $url,
            'method' => $method,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Admin\CategoryRequest $request
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(CategoryRequest $request, string $locale, Category $category)
    {
        //dd($request->all());
        DB::enableQueryLog();
        $saveData = Arr::except($request->except('_token','path'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];

        $this->categoryRepository->update($category->id, $saveData);

        $data = DB::table('category_path')->select('*')
            ->where('path_id',$category->id)
            ->orderBy('level','asc')->get();

        //dd(count($data));
        if(count($data)){
            foreach ($data as $category_path){
                DB::table('category_path')->where('category_id', $category_path->category_id)->where('level', '<',$category_path->level)->delete();

                $path = [];

                $_data = DB::table('category_path')->select('*')
                    ->where('path_id',$request->post('parent_id'))
                    ->orderBy('level','asc')->get();

                foreach ($_data as $result) {
                    $path[] = $result->path_id;
                }
                $_data = DB::table('category_path')->select('*')
                    ->where('path_id',$category_path->category_id)
                    ->orderBy('level','asc')->get();

                foreach ($_data as $result) {
                    $path[] = $result->path_id;
                }


                // Combine the paths with a new level
                $level = 0;

                //dd($path);

                foreach ($path as $path_id) {
                    DB::insert("REPLACE INTO `category_path` SET category_id = '" . (int)$category_path->category_id . "', `path_id` = '" . (int)$path_id . "', level = " . $level);
                    //DB::table('category_path')->updateOrInsert(['category_id' => $category_path->category_id,'path_id' => $path_id],['level' => $level]);
                    //DB::table('category_path')->where('category_id',$category_path->category_id)->where('path_id',$path_id)->delete();
                    //DB::table('category_path')->insert(['category_id' => $category_path->category_id,'path_id' => $path_id,'level' => $level]);
                    $level++;
                }
            }

        } else {
            DB::table('category_path')->where('category_id', $category->id)->delete();

            // Fix for records with no paths
            $level = 0;

            //$query = $this->db->query("SELECT * FROM `category_path` WHERE category_id = '" . (int)$this->input->post('parent_id') . "' ORDER BY level ASC");

            $data = DB::table('category_path')->select('*')
                ->where('path_id',$request->post('parent_id'))
                ->orderBy('level','asc')->get();

            foreach ($data as $result) {
                //$this->db->query("INSERT INTO `category_path` SET category_id = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");
                DB::table('category_path')
                    ->insert(['category_id' => $category->id,'path_id' => $result->path_id,'level' => $level]);
                $level++;
            }

            //$this->db->query("REPLACE INTO `category_path` SET category_id = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', level = '" . (int)$level . "'");
            DB::insert("REPLACE INTO `category_path` SET category_id = '" . $category->id . "', `path_id` = '" . $category->id . "', level = ". $level);
            //DB::table('category_path')->where('category_id',$category->id)->where('path_id',$category->id)->delete();
            //DB::table('category_path')->insert(['category_id' => $category->id,'path_id' => $category->id,'level' => $level]);

        }
        dd(DB::getQueryLog());
        return redirect(locale_route('category.show', $category->id))->with('success', __('admin.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $locale
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(string $locale, Category $category)
    {
        $this->deleteCategoryPath($category->id);
        if (!$this->categoryRepository->delete($category->id)) {
            return redirect(locale_route('category.show', $category->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('category.index'))->with('success', __('admin.delete_message'));
    }

    private function deleteCategoryPath($category_id) {
        //$this->db->query("DELETE FROM category_path WHERE category_id = '" . (int)$category_id . "'");

        DB::table('category_path')->where('category_id', $category_id)->delete();

        //$query = $this->db->query("SELECT * FROM category_path WHERE path_id = '" . (int)$category_id . "'");

        $data = DB::table('category_path')->select('*')
            ->where('path_id',$category_id)->get();

        foreach ($data as $result) {
            $this->deleteCategoryPath($result['category_id']);
        }


    }


    public function autocomplete(Request $request, CategoryRepository $categoryRepository) {
        $json = array();

        if ($request->get('filter_name') !== null) {

            $filter_data = array(
                'filter_name' => $request->get('filter_name'),
                'sort'        => 'name',
                'order'       => 'ASC',
                'start'       => 0,
                'limit'       => 5
            );

            $results = $this->categoryRepository->getCategories($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'category_id' => $result['category_id'],
                    'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
                );
            }
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        header('Content-Type: application/json');
        echo json_encode($json);
    }
}
