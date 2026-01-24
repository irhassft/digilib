<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Display welcome page with public documents and search
     */
    public function index(Request $request)
    {
        $query = Document::public()->with(['category', 'uploader']);
        
        // Handle search by title, category, or year
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('year', 'like', "%{$search}%")
                  ->orWhereHas('category', function($categoryQuery) use ($search) {
                      $categoryQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $documents = $query->latest()->paginate(9);
        $searchQuery = $request->search;
        
        return view('welcome', compact('documents', 'searchQuery'));
    }
}