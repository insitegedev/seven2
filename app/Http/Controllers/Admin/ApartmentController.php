<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApartmentRequest;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Apartment;
use App\Models\Setting;
use App\Repositories\ApartmentRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;

class ApartmentController extends Controller
{

    private $apartmentRepository;


    public function __construct(
        ApartmentRepositoryInterface  $apartmentRepository
    )
    {
        $this->apartmentRepository = $apartmentRepository;
    }


    /**
     * @param ApartmentRequest $request
     * @return Application|Factory|View
     */
    public function index(ApartmentRequest $request)
    {
        /*return view('admin.pages.apartment.index', [
            'apartments' => $this->apartmentRepository->getData($request, ['translations'])
        ]);*/

        return view('admin.nowa.views.apartments.index',[
            'data' => $this->apartmentRepository->getData($request, ['translations'])
        ]);
    }


    /**
     * @param string $locale
     * @param Setting $setting
     * @return Application|Factory|View
     */
    public function show(string $locale, Apartment $apartment)
    {
        return view('admin.pages.apartment.show', [
            'apartment' => $apartment,
        ]);
    }


    /**
     * @param string $locale
     * @param Setting $setting
     * @return Application|Factory|View
     */
    public function edit(string $locale, Apartment $apartment)
    {
        $url = locale_route('apartment.update', $apartment->id, false);
        $method = 'PUT';

        return view('admin.nowa.views.apartments.form', [
            'data' => $apartment,
            'url' => $url,
            'method' => $method,
        ]);
    }


    /**
     * @param SettingRequest $request
     * @param string $locale
     * @param Setting $setting
     * @return Application|RedirectResponse|Redirector
     */
    public function update(ApartmentRequest $request, string $locale, Apartment $apartment)
    {
        $saveData = Arr::except($request->except('_token'), []);
        $this->apartmentRepository->update($apartment->id,$saveData);


        return redirect(locale_route('apartment.show', $apartment->id))->with('success', __('admin.update_successfully'));
    }
}
