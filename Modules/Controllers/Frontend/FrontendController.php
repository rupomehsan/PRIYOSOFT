<?php

namespace Modules\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Inertia\Inertia;

class FrontendController extends Controller
{

    public function HomePage()
    {
        return Inertia::render('HomePage/Index', [
            'event' => [
                'title' => 'Home Page',
            ]
        ]);
    }
    public function VocabularyPage()
    {
        return Inertia::render('Words/Index', [
            'event' => [
                'title' => 'Words Page',
            ]
        ]);
    }
    public function VocabularyTestPage()
    {
        return Inertia::render('VocabularyTest/Index', [
            'event' => [
                'title' => 'Words Page',
            ]
        ]);
    }
    public function StoryPage()
    {
        return Inertia::render('Story/Index', [
            'event' => [
                'title' => 'Story Page',
            ]
        ]);
    }
    public function StoryTestPage()
    {
        return Inertia::render('Story/StoryTest', [
            'event' => [
                'title' => 'Story Test Page',
            ]
        ]);
    }
    public function ProfilePage()
    {
        return Inertia::render('Profile/Index', [
            'event' => [
                'title' => 'Profile Page',
            ]
        ]);
    }
    public function TodoPage()
    {
        return Inertia::render('TodoList/Index', [
            'event' => [
                'title' => 'Todo List',
            ]
        ]);
    }

    public function ProductsPage()
    {
        return Inertia::render('Products/Index');
    }

    public function ProductDetailsPage(string $slug)
    {
        return Inertia::render('Products/Details', [
            'slug' => $slug,
        ]);
    }

    public function ProductPaymentPage(string $slug)
    {
        return Inertia::render('Products/Payment', [
            'slug' => $slug,
        ]);
    }
}