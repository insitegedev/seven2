<?php
/**
 *  app/Http/Controllers/Client/ServiceController.php
 *
 * Date-Time: 06.08.21
 * Time: 15:25
 * @author Insite LLC <hello@insite.international>
 */
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function index($locale, Request $request) {
        $page = Page::where('key', 'service')->firstOrFail();
        $services = Service::where('status',true)->with(['mainFile_1','translations'])->get();

        return Inertia::render("Services/Services", ["services"=> $services,
            "page" => $page,
            "state" => $request->input('state'),
            "seo" => [
                "title"=>$page->meta_title,
                "description"=>$page->meta_description,
                "keywords"=>$page->meta_keyword,
                "og_title"=>$page->meta_og_title,
                "og_description"=>$page->meta_og_description,
//            "image" => "imgg",
//            "locale" => App::getLocale()
            ]])
            ->withViewData([
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'meta_keyword' => $page->meta_keyword,
            "image" => $page->file,
            'og_title' => $page->meta_og_title,
            'og_description' => $page->meta_og_description
        ]);

    }

    public function show(string $locale, $id) {
        $page = Page::where('key', 'service')->firstOrFail();
        $service = Service::where('status', 1)->where("id", $id)->with(['files','mainFile_1','mainFile_2','translations', ])->firstOrFail();
        $nextService = Service::where("status", 1)->with(['mainFile_1','translations'])->inRandomOrder()->first();

        return Inertia::render("SingleService/SingleService", ["service"=> $service, "nextService" => $nextService, "seo" => [
            "title"=>$service->meta_title??$page->meta_title,
            "description"=>$service->meta_description??$page->meta_description,
            "keywords"=>$service->meta_keyword??$page->meta_keyword,
            "og_title"=>$page->meta_og_title,
            "og_description"=>$page->meta_og_description,
//            "image" => "imgg",
//            "locale" => App::getLocale()
        ]])->withViewData([
            'meta_title' => $service->meta_title??$page->meta_title,
            'meta_description' => $service->meta_description??$page->meta_description,
            'meta_keyword' => $service->meta_keyword??$page->meta_keyword,
            "image" => $service->mainFile_1,
            'og_title' => $page->meta_og_title,
            'og_description' => $page->meta_og_description
        ]);

    }
}
