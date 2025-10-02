<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
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
