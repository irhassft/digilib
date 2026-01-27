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

    /**
     * Display full catalogue with all public documents
     */
    public function catalogue(Request $request)
    {
        $query = Document::public()->with(['category', 'uploader']);
        
        // Handle search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('year', 'like', "%{$search}%")
                  ->orWhereHas('category', function($categoryQuery) use ($search) {
                      $categoryQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Handle category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $documents = $query->latest()->paginate(12);
        // Exclude "Dokumen Privat" category
        $categories = \App\Models\Category::where('name', '!=', 'Dokumen Privat')
            ->orderBy('name')->get();
        $searchQuery = $request->search;
        $selectedCategory = $request->category;
        
        return view('catalogue', compact('documents', 'categories', 'searchQuery', 'selectedCategory'));
    }
}