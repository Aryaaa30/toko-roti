<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class BirthdayController extends Controller
{
    /**
     * Show the form for creating a new birthday cake.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('birthday.create');
    }
    
    /**
     * Display the birthday page based on user role
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->check()) {
            if (auth()->user()->is_admin) {
                // Redirect admin to admin birthday page
                return redirect()->route('birthday.admin');
            } else {
                // Redirect regular user to user birthday page
                return redirect()->route('birthday.user');
            }
        }
        
        // Guest view (redirect to user view)
        return view('birthday.birthday_user');
    }
    
    /**
     * Admin-only birthday page
     *
     * @return \Illuminate\Http\Response
     */
    public function adminPage()
    {
        $birthdayCakes = Menu::where('kategori', 'birthday')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.birthday_admin', compact('birthdayCakes'));
    }
    
    /**
     * User-only birthday page
     *
     * @return \Illuminate\Http\Response
     */
    public function userPage()
    {
        // Check if user is admin, if so redirect to admin page
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect()->route('birthday.admin');
        }
        
        // Get available birthday cakes
        $birthdayCakes = Menu::where('kategori', 'birthday')
            ->where('available', 1)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('birthday.birthday_user', compact('birthdayCakes'));
    }
}