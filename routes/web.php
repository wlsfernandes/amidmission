<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookRecommendationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\CollaboratorImageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\GalleryImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MediaTypeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PagePublicController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectImageController;
use App\Http\Controllers\PublishController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionCardController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SocialLinkController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\SystemLogController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WikipediaController;
/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Language Switcher
|--------------------------------------------------------------------------
*/

Route::get('lang/{locale}', function ($locale) {

    if (in_array($locale, ['en', 'es', 'pt'])) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    }

    return redirect()->back();

})->name('lang.switch');

/* |--------------------------------------------------------------------------
Public web routes
|-------------------------------------------------------------------------- */
Route::get('/', [HomeController::class, 'index'])->name('index');

/* About */
Route::get('/about-us', [AboutController::class, 'indexPublic'])->name('about.index.public');

/* pulpit-fellows */
Route::get('/pulpit-fellows', [HomeController::class, 'pulpitFellows'])->name('pulpit-fellows');

/* Blogs */
Route::get('/blog/{blog:slug}', [BlogController::class, 'display'])->name('blogs.display');
Route::get('/our-blogs', [BlogController::class, 'indexPublic'])->name('blogs.index.public');
/* Book Recommendations */
Route::get('/our-book-recommendations', [BookRecommendationController::class, 'indexPublic'])->name('book-recommendations.index.public');

/* Contact */
Route::post('/send-message', [ContactController::class, 'send'])->name('contact.send')->middleware('throttle:5,1');
/* Events */
Route::get('/event/{event:slug}', [EventController::class, 'display'])->name('events.display');
Route::get('/our-events', [EventController::class, 'indexPublic'])->name('events.index.public');

/* Files & Images */
Route::get('/images/{model}/{id}/preview', [ImageUploadController::class, 'preview'])->name('admin.images.preview');
Route::get('/files/{model}/{id}/{lang}/download', [FileUploadController::class, 'download'])->name('admin.files.download');
Route::delete('/images/{model}/{id}', [ImageUploadController::class, 'destroy'])->name('admin.images.destroy');

/* Projects */
Route::get('/our-projects/{slug}', [ProjectController::class, 'display'])->name('projects.display');

Route::get('/our-collaborators/{slug}', [CollaboratorController::class, 'display'])->name('collaborators.display');

/* positions */
Route::get('/join-our-team', [PositionController::class, 'indexPublic'])->name('positions.index.public');
Route::get('/position/{slug}', [PositionController::class, 'display'])->name('positions.display');
/* Services */
Route::get('/our-services', [ServiceController::class, 'indexPublic'])->name('services.index.public');
Route::get('/service/{service:slug}', [ServiceController::class, 'display'])->name('services.display');
/* Teams */
Route::get('/our-team', [TeamController::class, 'indexPublic'])->name('teams.index.public');
Route::get('/team/{slug}', [TeamController::class, 'profile'])->name('team.profile');

/* Media */
Route::get('/insights', [MediaController::class, 'indexPublic'])->name('media.index.public');
Route::get('/insights/{type:slug}', [MediaController::class, 'byType'])->name('media.byType');

/* Resources */
Route::get('/our-resources', [ResourceController::class, 'indexPublic'])->name('resources.index.public');

/* Donations */
Route::get('/donate-now', [DonationController::class, 'indexPublic'])->name('donation.index.public');
Route::post('/donate/checkout', [DonationController::class, 'startCheckout'])->name('donations.start');
Route::get('/donate/success', [DonationController::class, 'successPage'])->name('donations.success');


/* Store */
Route::get('/store', [StoreController::class, 'indexPublic'])->name('stores.index.public');
Route::get('/store/{slug}', [StoreController::class, 'show'])->name('store.products.show');

/* Cart */
Route::get('/cart/show', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/checkout/success', [CartController::class, 'success'])->name('cart.success');

/* Stripe Webhooks */
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);
/*
|--------------------------------------------------------------------------
| Authentication (Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Breeze compatibility
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');

});

/*
|--------------------------------------------------------------------------
| ADMIN MODULES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'can:access-website-admin'])->group(function () {

    Route::resource('pages', PageController::class)->except(['show']);
    Route::resource('pages.sections', SectionController::class)->scoped();
    Route::resource('pages.sections.cards', SectionCardController::class)->scoped();

    Route::resource('menus', MenuController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('products', ProductController::class);
    Route::resource('stores', StoreController::class);
    Route::resource('wikipedias', WikipediaController::class);

});
Route::middleware(['auth', 'verified'])->group(function () {

    // Files
    Route::get('/files/{model}/{id}/{lang}', [FileUploadController::class, 'edit'])->name('admin.files.edit');
    Route::post('/files/{model}/{id}/{lang}', [FileUploadController::class, 'update'])->name('admin.files.update');

    // Images
    Route::get('/images/{model}/{id}', [ImageUploadController::class, 'edit'])->name('admin.images.edit');
    Route::post('/images/{model}/{id}', [ImageUploadController::class, 'update'])->name('admin.images.update');

    // Publish toggle
    Route::patch('/publish/{model}/{id}', [PublishController::class, 'toggle'])->name('admin.publish.toggle');

});
/*
|--------------------------------------------------------------------------
| Administration
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'can:access-admin'])->group(function () {

    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('roles', RoleController::class)->except(['show']);

    Route::get('audits', [AuditController::class, 'index'])->name('audits.index');
    Route::get('system-logs', [SystemLogController::class, 'index'])->name('system-logs.index');

});
/*
|--------------------------------------------------------------------------
| Website-admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'can:access-website-admin'])->group(function () {

    Route::get('payments', [PaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('admin.payments.show');
    // Site Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/edit', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::patch('/collaborators/{collaborator}/images/{image}/link', [CollaboratorImageController::class, 'updateLink'])->name('collaborators.images.updateLink');
    Route::delete('pages/{page}/sections/{section}/images/{image}', [SectionController::class, 'destroyImage'])->name('pages.sections.images.destroy');
    Route::delete('pages/{page}/sections/{section}/image', [SectionController::class, 'destroySectionImage'])->name('pages.sections.image.destroy');
    // Content
    Route::resource('abouts', AboutController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('book-recommendations', BookRecommendationController::class);
    Route::resource('donations', DonationController::class);
    Route::resource('events', EventController::class);
    Route::resource('gallery-images', GalleryImageController::class);
    Route::resource('media', MediaController::class)->parameters(['media' => 'media']);
    Route::resource('media-types', MediaTypeController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('pages', PageController::class)->except(['show']);
    Route::resource('pages.sections', SectionController::class)->scoped();
    Route::resource('pages.sections.cards', SectionCardController::class)->scoped();
    Route::resource('partners', PartnerController::class);
    Route::resource('positions', PositionController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('collaborators', CollaboratorController::class);
    Route::resource('projects.images', ProjectImageController::class);
    Route::resource('collaborators.images', CollaboratorImageController::class);
    Route::resource('resources', ResourceController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('stores', StoreController::class);
    Route::resource('products', ProductController::class);
    Route::resource('teams', TeamController::class);
    Route::resource('testimonials', TestimonialController::class);

    // Navigation & Social
    Route::resource('menus', MenuController::class)->names('menus');
    Route::resource('social-links', SocialLinkController::class);

});
/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| CMS PAGES (KEEP LAST)
|--------------------------------------------------------------------------
|
| This allows dynamic pages like:
| /about-us
| /vision
| /mission
|
| without breaking admin routes.
|
*/

Route::fallback([PagePublicController::class, 'show'])->name('public.page.show');
