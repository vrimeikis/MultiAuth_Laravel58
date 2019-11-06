<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Class HomeController
 *
 * @package App\Http\Controllers\Admin
 */
class HomeController extends Controller
{
    /**
     * @return View
     */
    public function index(): View {
        return view('admin.home');
    }
}
