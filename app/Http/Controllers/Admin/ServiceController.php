<?php
/**
 *  app/Http/Controllers/Admin/ServiceController.php
 *
 * Date-Time: 06.08.21
 * Time: 14:59
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Service;
use App\Repositories\ServiceRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use ReflectionException;

class ServiceController extends Controller
{
    /**
     * @var ServiceRepositoryInterface
     */
    private $serviceRepository;

    /**
     * @param ServiceRepositoryInterface $serviceRepository
     */
    public function __construct(
        ServiceRepositoryInterface  $serviceRepository
    )
    {
        $this->serviceRepository = $serviceRepository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(ServiceRequest $request)
    {
        return view('admin.pages.service.index', [
            'services' => $this->serviceRepository->getData($request, ['translations'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $service = $this->serviceRepository->model;

        $url = locale_route('service.store', [], false);
        $method = 'POST';

        return view('admin.pages.service.form', [
            'service' => $service,
            'url' => $url,
            'method' => $method,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ServiceRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(ServiceRequest $request)
    {
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];

        $service = $this->serviceRepository->create($saveData);

        // Save Files
        if ($request->hasFile('images') || $request->hasFile('main-image')) {
            $service = $this->serviceRepository->saveFile($service->id, $request);
        }

        return redirect(locale_route('service.show', $service->id))->with('success', __('admin.create_successfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param string $locale
     * @param Service $service
     * @return Application|Factory|View
     */
    public function show(string $locale, Service $service)
    {
        return view('admin.pages.service.show', [
            'service' => $service,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $locale
     * @param Service $service
     * @return Application|Factory|View
     */
    public function edit(string $locale, Service $service)
    {
        $url = locale_route('service.update', $service->id, false);
        $method = 'PUT';

        return view('admin.pages.service.form', [
            'service' => $service,
            'url' => $url,
            'method' => $method,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServiceRequest $request
     * @param string $locale
     * @param Service $service
     * @return Application|RedirectResponse|Redirector
     * @throws ReflectionException
     */
    public function update(ServiceRequest $request, string $locale, Service $service)
    {
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];

        $this->serviceRepository->update($service->id,$saveData);

        // Save Files
//        if ($request->hasFile('images')) {
            $this->serviceRepository->saveFile($service->id, $request);
//        }


        return redirect(locale_route('service.show', $service->id))->with('success', __('admin.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $locale
     * @param Service $service
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(string $locale, Service $service)
    {
        if (!$this->serviceRepository->delete($service->id)) {
            return redirect(locale_route('service.show', $service->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('service.index'))->with('success', __('admin.delete_message'));
    }
}
