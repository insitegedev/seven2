<?php
/**
 *  app/Http/Controllers/Admin/ProductController.php
 *
 * Date-Time: 30.07.21
 * Time: 10:37
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use ReflectionException;

class ProductController extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryRepositoryInterface $categoryRepository
     */

    private $categories;
    public function __construct(
        ProductRepositoryInterface  $productRepository,
        CategoryRepositoryInterface $categoryRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->categories = $this->categoryRepository->getCategoryTree();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(ProductRequest $request)
    {
        /*return view('admin.pages.product.index', [
            'products' => $this->productRepository->getData($request, ['translations', 'categories'])
        ]);*/

        return view('admin.nowa.views.products.index', [
            'data' => $this->productRepository->getData($request, ['translations', 'categories']),
            'categories' => $this->categoryRepository->model->leftJoin('category_translations',function ($join){
                $join->on('category_translations.category_id','categories.id')->where('category_translations.locale',app()->getLocale());
            })->orderBy('title')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $product = $this->productRepository->model;





        $url = locale_route('product.store', [], false);
        $method = 'POST';

        /*return view('admin.pages.product.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories
        ]);*/

        return view('admin.nowa.views.products.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     * @throws ReflectionException
     */
    public function store(ProductRequest $request)
    {

        //dd($request->all());
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        $saveData['stock'] = isset($saveData['stock']) && (bool)$saveData['stock'];
        $saveData['popular'] = isset($saveData['popular']) && (bool)$saveData['popular'];

        //dd($saveData);
        $product = $this->productRepository->create($saveData);
        $product->categories()->sync($saveData['categories']);

        // Save Files
        if ($request->hasFile('images')) {
            $product = $this->productRepository->saveFiles($product->id, $request);
        }

        return redirect(locale_route('product.index', $product->id))->with('success', __('admin.create_successfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param string $locale
     * @param Product $product
     *
     * @return Application|Factory|View
     */
    public function show(string $locale, Product $product)
    {
        return view('admin.pages.product.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $locale
     * @param Category $category
     *
     * @return Application|Factory|View
     */
    public function edit(string $locale, Product $product)
    {
        $url = locale_route('product.update', $product->id, false);
        $method = 'PUT';

        /*return view('admin.pages.product.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories
        ]);*/

        return view('admin.nowa.views.products.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param string $locale
     * @param Product $product
     * @return Application|RedirectResponse|Redirector
     * @throws ReflectionException
     */
    public function update(ProductRequest $request, string $locale, Product $product)
    {
        //dd($request->all());
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        $saveData['popular'] = isset($saveData['popular']) && (bool)$saveData['popular'];
        $saveData['stock'] = isset($saveData['stock']) && (bool)$saveData['stock'];

        //dd($saveData);

        $this->productRepository->update($product->id, $saveData);

        $this->productRepository->saveFiles($product->id, $request);

        $product->categories()->sync($saveData['categories'] ?? []);


        return redirect(locale_route('product.index', $product->id))->with('success', __('admin.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $locale
     * @param Product $product
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(string $locale, Product $product)
    {
        if (!$this->productRepository->delete($product->id)) {
            return redirect(locale_route('product.show', $product->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('product.index'))->with('success', __('admin.delete_message'));
    }
}
