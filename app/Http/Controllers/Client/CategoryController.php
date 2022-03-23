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

class ProjectController extends Controller
{

    /**
     * @param string $locale
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(string $locale, Request $request)
    {
        $projectPage = Page::where('key', 'project')->firstOrFail();
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
//        dd($slug);
//        return 1;

        $project = Project::where(['status' => true, 'slug' => $slug])->whereHas('category', function (Builder $query) {
            $query->where('status', 1);
        })->firstOrFail();

        return view('client.pages.project.show', [
            'project' => $project
        ]);
    }
}
