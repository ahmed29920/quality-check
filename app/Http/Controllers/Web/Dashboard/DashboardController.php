<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Services\ProviderService;
use App\Services\ProviderServiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


class DashboardController extends Controller
{
    protected $userService;
    protected $providerService;
    protected $providerServiceService;
    public function __construct(UserService $userService, ProviderService $providerService, ProviderServiceService $providerServiceService)
    {
        $this->userService = $userService;
        $this->providerService = $providerService;
        $this->providerServiceService = $providerServiceService;
    }
    public function index()
    {
        $user_statistics = $this->userService->getStatistics();
        $provider_statistics = $this->providerService->getStatistics();
        $provider_services_statistics = $this->providerServiceService->getStatistics();
        return view('dashboard.index', compact('user_statistics', 'provider_statistics', 'provider_services_statistics'));
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
