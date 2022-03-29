<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{

    /**
     * @param string $locale
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(string $locale, Request $request)
    {
        $projectPage = Page::where('key', 'category')->firstOrFail();
        $categories = Category::whereHas('project', function (Builder $query) {
            $query->where('status', true);
        })->where('status', true)->get();

        $projects = Project::query()->with(['file', 'translations']);

        $projects = $projects->where('status', true);

        if ($request->has('category')) {
            $projects = $projects->where('category_id',$request['category']);
        }

        return view('client.pages.project.index', [
            'projectPage' => $projectPage,
            'categories' => $categories,
            'projects' => $projects->paginate(5)
        ]);
    }


    /**
     * @param string $locale
     * @param string $slug
     * @return Application|Factory|View
     */
    public function show(string $locale, string $slug)
    {

        $page = Page::where('key', 'products')->firstOrFail();
//        return 1;
        $category = Category::where(['status' => 1, 'slug' => $slug])->firstOrFail();
        //dd($category->getAncestors());
        $products = Product::where(['status' => 1, 'product_categories.category_id' => $category->id])
            ->leftJoin('product_categories', 'product_categories.product_id', '=', 'products.id')->with('files')
            ->paginate(16);

        $images = [];
        foreach ($page->sections as $sections){
            if($sections->file){
                $images[] = asset($sections->file->getFileUrlAttribute());
            } else {
                $images[] = null;
            }

        }

        //dd($products);

        //dd($products);
        return Inertia::render('Products/Products',[
            'products' => $products,
            'category' => $category,
            'images' => $images,
            "seo" => [
                "title"=>$page->meta_title,
                "description"=>$page->meta_description,
                "keywords"=>$page->meta_keyword,
                "og_title"=>$page->meta_og_title,
                "og_description"=>$page->meta_og_description,
//            "image" => "imgg",
//            "locale" => App::getLocale()
            ]
        ])->withViewData([
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'meta_keyword' => $page->meta_keyword,
            "image" => $page->file,
            'og_title' => $page->meta_og_title,
            'og_description' => $page->meta_og_description
        ]);
    }


    public function popular(){
        $page = Page::where('key', 'products')->firstOrFail();

        $images = [];
        foreach ($page->sections as $sections){
            if($sections->file){
                $images[] = asset($sections->file->getFileUrlAttribute());
            } else {
                $images[] = null;
            }

        }

        $products = Product::where(['products.status' => 1, 'products.popular' => 1])->with('files')
            ->paginate(16);

        return Inertia::render('Products/Products',[
            'products' => $products,
            'category' => null,
            'images' => $images,
            "seo" => [
                "title"=>$page->meta_title,
                "description"=>$page->meta_description,
                "keywords"=>$page->meta_keyword,
                "og_title"=>$page->meta_og_title,
                "og_description"=>$page->meta_og_description,
//            "image" => "imgg",
//            "locale" => App::getLocale()
            ]
        ])->withViewData([
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'meta_keyword' => $page->meta_keyword,
            "image" => $page->file,
            'og_title' => $page->meta_og_title,
            'og_description' => $page->meta_og_description
        ]);
    }
}
