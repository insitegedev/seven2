<?php
/**
 *  app/Http/Controllers/Admin/ProjectController.php
 *
 * Date-Time: 30.07.21
 * Time: 10:37
 * @author Insite LLC <hello@insite.international>
 */


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Project;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ProjectRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use ReflectionException;

class ProjectController extends Controller
{
    /**
     * @var ProjectRepositoryInterface
     */
    private $projectRepository;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @param ProjectRepositoryInterface $projectRepository
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        ProjectRepositoryInterface  $projectRepository,
        CategoryRepositoryInterface $categoryRepository
    )
    {
        $this->projectRepository = $projectRepository;
        $this->categoryRepository = $categoryRepository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(ProjectRequest $request)
    {

        return view('admin.pages.project.index', [
            'projects' => $this->projectRepository->getData($request, ['translations', 'category'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $project = $this->projectRepository->model;

        $url = locale_route('project.store', [], false);
        $method = 'POST';

        return view('admin.pages.project.form', [
            'project' => $project,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categoryRepository->all(['*'], ['translations'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     * @throws ReflectionException
     */
    public function store(ProjectRequest $request)
    {
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];

        $project = $this->projectRepository->create($saveData);

        // Save Files
        if ($request->hasFile('images')) {
            $project = $this->projectRepository->saveFiles($project->id, $request);
        }

        return redirect(locale_route('project.show', $project->id))->with('success', __('admin.create_successfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param string $locale
     * @param Project $project
     *
     * @return Application|Factory|View
     */
    public function show(string $locale, Project $project)
    {
        return view('admin.pages.project.show', [
            'project' => $project,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $locale
     * @param Project $project
     * @return Application|Factory|View
     */
    public function edit(string $locale, Project $project)
    {
        $url = locale_route('project.update', $project->id, false);
        $method = 'PUT';

        return view('admin.pages.project.form', [
            'project' => $project,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categoryRepository->all(['*'], ['translations'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectRequest $request
     * @param string $locale
     * @param Project $project
     * @return Application|RedirectResponse|Redirector
     * @throws ReflectionException
     */
    public function update(ProjectRequest $request, string $locale, Project $project)
    {
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];

        $this->projectRepository->update($project->id, $saveData);


        $this->projectRepository->saveFiles($project->id, $request);


        return redirect(locale_route('project.show', $project->id))->with('success', __('admin.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $locale
     * @param Project $project
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(string $locale, Project $project)
    {
        if (!$this->projectRepository->delete($project->id)) {
            return redirect(locale_route('project.show', $project->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('project.index'))->with('success', __('admin.delete_message'));
    }
}
