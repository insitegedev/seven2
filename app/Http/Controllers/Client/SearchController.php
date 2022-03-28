<?php
/**
 *  app/Http/Controllers/Client/SearchController.php
 *
 * Date-Time: 09.08.21
 * Time: 13:53
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Http\Request;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;


class SearchController extends Controller
{


    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $items = [];

        if ($keyword) {
            $items = (new Search())
                ->registerModel(Product::class, function (ModelSearchAspect $modelSearchAspect) use ($keyword) {
                    $modelSearchAspect
                        ->addSearchableAttribute('created_at')
                        ->orWhereHas('translations', function ($query) use ($keyword) {
                            return $query->where('title', 'like', '%' . $keyword . '%');
                        });
                })
                /*->registerModel(Project::class, function (ModelSearchAspect $modelSearchAspect) use ($keyword) {
                    $modelSearchAspect
                        ->addSearchableAttribute('created_at')
                        ->orWhereHas('translations', function ($query) use ($keyword) {
                            return $query->where('title', 'like', '%' . $keyword . '%');
                        });
                })*/
                ->search($keyword);
        }
        return view('client.pages.search.index', [
            'items' => $items
        ]);
    }
}
