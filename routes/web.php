<?php
/**
 *  routes/web.php
 *
 * Date-Time: 03.06.21
 * Time: 15:41
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\FloorController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TranslationController;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\AboutUsController;
use App\Http\Controllers\Client\ServiceController;
use Illuminate\Support\Facades\Route;

Route::post('ckeditor/image_upload', [CKEditorController::class, 'upload'])->name('upload');

Route::redirect('', config('translatable.fallback_locale'));
Route::prefix('{locale?}')
    ->middleware(['setlocale'])
    ->group(function () {
        Route::prefix('adminpanel')->group(function () {
            Route::get('login', [LoginController::class, 'loginView'])->name('loginView');
            Route::post('login', [LoginController::class, 'login'])->name('login');


            Route::middleware('auth')->group(function () {
                Route::get('logout', [LoginController::class, 'logout'])->name('logout');

                Route::redirect('', '/adminpanel/apartment',);

                // Language
                Route::resource('language', LanguageController::class);
                Route::get('language/{language}/destroy', [LanguageController::class, 'destroy'])->name('language.destroy');

                // Translation
                Route::resource('translation', TranslationController::class);

                // Category
                Route::resource('category', \App\Http\Controllers\Admin\CategoryController::class);
                Route::get('category/{category}/destroy', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('category.destroy');
//
                // Product
                Route::resource('product', \App\Http\Controllers\Admin\ProductController::class);
                Route::get('product/{product}/destroy', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('product.destroy');
//                // Gallery
                Route::resource('gallery', GalleryController::class);
                Route::get('gallery/{gallery}/destroy', [GalleryController::class, 'destroy'])->name('gallery.destroy');

                // Project
//                Route::resource('project', ProjectController::class);
//                Route::get('project/{project}/destroy', [ProjectController::class, 'destroy'])->name('project.destroy');

                // Slider
                Route::resource('slider', SliderController::class);
                Route::get('slider/{slider}/destroy', [SliderController::class, 'destroy'])->name('slider.destroy');

                // Page
                Route::resource('page', PageController::class);
                Route::get('page/{page}/destroy', [PageController::class, 'destroy'])->name('page.destroy');

                // Setting
                Route::resource('setting', SettingController::class);
                Route::get('setting/{setting}/destroy', [SettingController::class, 'destroy'])->name('setting.destroy');


                // Service
                Route::resource('service', \App\Http\Controllers\Admin\ServiceController::class);
                Route::get('service/{service}/destroy', [\App\Http\Controllers\Admin\ServiceController::class, 'destroy'])->name('service.destroy');

                // Certificate
//                Route::resource('certificate', CertificateController::class);
//                Route::get('certificate/{certificate}/destroy', [CertificateController::class, 'destroy'])->name('certificate.destroy');


                // Apartment
                Route::resource('apartment', ApartmentController::class);
                Route::get('apartment/{apartment}/destroy', [ApartmentController::class, 'destroy'])->name('apartment.destroy');

                // Floor
                Route::resource('floor', FloorController::class);
                Route::get('floor/{floor}/destroy', [FloorController::class, 'destroy'])->name('floor.destroy');

                Route::get('categories/autocomplete',[\App\Http\Controllers\Admin\CategoryController::class,'autocomplete'])->name('autocomplete');

            });
        });
        Route::middleware(['active'])->group(function () {

            // Home Page
            Route::get('', [HomeController::class, 'index'])->name('client.home.index');
            Route::get('/gallery', [\App\Http\Controllers\Client\GalleryController::class, 'index'])->name('client.gallery.index');
//            Route::get('/doctors', [HomeController::class, 'doctors'])->name('client.doctors.index');
//            Route::get('/choosefloor', [HomeController::class, 'choosefloor'])->name('client.choosefloor.index');
            Route::get('/apartment/{apartment?}', [\App\Http\Controllers\Client\ApartmentController::class, 'show'])->name('client.apartment.index');
            Route::get('/choose-floor', [\App\Http\Controllers\Client\ApartmentController::class, 'index'])->name('client.choosefloor.index');

            // Floor Plan
            Route::get('/choose-apartment/{floor?}', [\App\Http\Controllers\Client\ApartmentController::class, 'showFloor'])->name('client.showFloor.index');


            // Contact Page
            Route::get('/contact', [ContactController::class, 'index'])->name('client.contact.index');
            Route::post('/contact-us', [ContactController::class, 'mail'])->name('client.contact.mail');


            // About Page
            Route::get('about', [AboutUsController::class, 'index'])->name('client.about.index');

            // Product Page
            Route::get('products', [\App\Http\Controllers\Client\ProductController::class, 'index'])->name('client.product.index');
           Route::get('product/{product}', [\App\Http\Controllers\Client\ProductController::class, 'show'])->name('client.product.show');

           Route::get('category/{category}',[\App\Http\Controllers\Client\CategoryController::class,'show'])->name('client.category.show');

            // Project Page
//            Route::get('/project', [\App\Http\Controllers\Client\ProjectController::class, 'index'])->name('client.project.index');
//            Route::get('/project/{project}', [\App\Http\Controllers\Client\ProjectController::class, "show"])->name('client.project.show');
            // Search Page
//            Route::get('/search', [\App\Http\Controllers\Client\SearchController::class, 'index'])->name('client.search.index');

            // Project Page
//            Route::get('/project', [\App\Http\Controllers\Client\ProjectController::class, 'index'])->name('client.project.index');
//            Route::get('/project/{project}', [\App\Http\Controllers\Client\ProjectController::class, "show"])->name('client.project.show');

            // Service Page
            Route::get('/service', [ServiceController::class, "index"])->name('client.service.index');
            Route::get('/service/{service?}', [ServiceController::class, "show"])->name('client.service.show');
        });
    });


