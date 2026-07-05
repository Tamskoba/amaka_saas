<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserForm;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $forms = UserForm::with('form')
            ->where('user_id', $user->id)
            ->get();

        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'forms',
            'notifications'
        ));
    }
}