<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


class DashboardController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        $statistics = $this->userService->getStatistics();
        return view('dashboard.index', compact('statistics'));
    }

    public function toggleLanguage(Request $request)
    {
        $current = Session::get('locale', config('app.locale'));
        $new = $current === 'en' ? 'ar' : 'en';

        Session::put('locale', $new);
        App::setLocale($new);
        return back();
    }
}
