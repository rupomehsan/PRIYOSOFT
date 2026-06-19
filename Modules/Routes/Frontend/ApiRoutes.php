<?php

use Modules\Management\BlogManagement\Blog\Controller\Controller as BlogController;
use Modules\Management\ProjectManagement\Project\Controller\Controller as ProjectController;
use Modules\Management\ProductManagement\DigitalProduct\Controller\Controller as DigitalProductController;
use Illuminate\Support\Facades\Route;

// ─── Public Portfolio Routes (no auth required) ───────────────────────────────
use Modules\Management\WebsiteManagement\HeroSection\Controller\Controller as HeroSectionController;
use Modules\Management\WebsiteManagement\SiteSection\Controller\Controller as SiteSectionController;
use Modules\Management\WebsiteManagement\TeamMember\Controller\Controller as TeamMemberController;
use Modules\Management\WebsiteManagement\Testimonial\Controller\Controller as TestimonialController;
use Modules\Management\WebsiteManagement\BlogPost\Controller\Controller as BlogPostController;
use Modules\Management\WebsiteManagement\AboutUs\Controller\Controller as AboutUsController;
use Modules\Management\WebsiteManagement\Faq\Controller\Controller as FaqController;
use Modules\Management\WebsiteManagement\Subscriber\Controller\Controller as SubscriberController;
use Modules\Management\ProductManagement\Product\Controller\Controller as ProductController;
use Modules\Management\ProductManagement\ProductGroup\Controller\Controller as ProductGroupController;
use Modules\Management\WebsiteManagement\WhoWeAre\Controller\Controller as WhoWeAreController;
use Modules\Management\WebsiteManagement\ContactLead\Controller\Controller as ContactLeadController;

Route::prefix('public')->group(function () {
    Route::get('hero-sections',    [HeroSectionController::class, 'index']);
    Route::get('site-sections',    [SiteSectionController::class, 'index']);
    Route::get('team-members',     [TeamMemberController::class,  'index']);
    Route::get('testimonials',     [TestimonialController::class, 'index']);
    Route::get('blogs',            [BlogPostController::class,    'index']);
    Route::get('blogs/{slug}',     [BlogPostController::class,    'show']);
    Route::get('about-us',         [AboutUsController::class,     'index']);
    Route::get('faqs',             [FaqController::class,         'index']);
    Route::get('products',         [ProductController::class,     'index']);
    Route::get('products/{slug}',  [ProductController::class,     'show']);
    Route::get('product-groups',   [ProductGroupController::class,'index']);
    Route::post('subscribe',       [SubscriberController::class,  'store']);
    Route::get('who-we-are',       [WhoWeAreController::class,    'index']);
    Route::post('contact',         [ContactLeadController::class, 'publicStore']);
});

Route::get('get-all-projects', [ProjectController::class,'index']);
Route::get('get-single-projects/{slug}', [ProjectController::class,'getSingleProject']);
Route::get('get-projects-comments/{project_id}', [ProjectController::class,'getProjectComments']);
Route::post('submit-project-comment/{project_id}', [ProjectController::class,'submitProjectComment']);
Route::post('submit-project-like/{project_id}', [ProjectController::class,'submitProjectLike']);





Route::get('get-all-digital-products', [DigitalProductController::class, 'index']);
Route::get('get-single-digital-product/{slug}', [DigitalProductController::class, 'getSingleDigitalProduct']);
Route::get('get-digital-product-comments/{digital_product_id}', [DigitalProductController::class, 'getDigitalProductComments']);
Route::post('submit-digital-product-comment/{digital_product_id}', [DigitalProductController::class, 'submitDigitalProductComment']);
Route::post('submit-digital-product-like/{digital_product_id}', [DigitalProductController::class, 'submitDigitalProductLike']);
Route::post('submit-digital-product-order', [DigitalProductController::class, 'submitDigitalProductOrder']);




Route::get('get-all-blogs', [BlogController::class,'index']);
Route::get('get-single-blog/{slug}', [BlogController::class,'getSingleBlog']);
Route::get('get-blog-categories', [BlogController::class,'getBlogCategories']);
Route::post('post-blog-comment', [BlogController::class,'submitComment']);
Route::get('get-all-comments-by-blog/{slug}', [BlogController::class,'getBlogComments']);
Route::post('submit-blog-like/{blog_id}', [BlogController::class,'submitBlogLike']);
