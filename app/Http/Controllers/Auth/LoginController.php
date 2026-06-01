<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        // Get active listings count
        $listingsCount = Listing::where('status', 'active')->count();

        // Get active users count
        $usersCount = User::where('is_active', true)->count();

        // Calculate customer satisfaction (average rating from reviews)
        $averageRating = Review::avg('rating') ?? 0;
        // Convert to percentage (assuming 5-star system: rating/5 * 100)
        $satisfactionPercentage = round(($averageRating / 5) * 100);

        return view('auth.login', [
            'listingsCount' => $listingsCount,
            'usersCount' => $usersCount,
            'satisfactionPercentage' => $satisfactionPercentage,
        ]);
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        // Login logic will go here
    }

    /**
     * Handle user logout.
     */
    public function logout()
    {
        // Logout logic will go here
    }
}
