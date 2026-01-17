<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthorController extends Controller
{
    /**
     * Create a new author with user account
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|unique:users,email',
        ]);

        // Create user account for the author
        $user = User::create([
            'name' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make('password'), // Default password
        ]);

        // Create author
        $author = Author::create([
            'name' => $validated['name'],
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Author created successfully',
            'author' => $author->load('user'),
        ], 201);
    }

    /**
     * Get all articles of a specific author
     */
    public function articles($id)
    {
        $author = Author::findOrFail($id);
        $articles = $author->articles;

        return response()->json([
            'author' => $author->name,
            'articles' => $articles,
        ]);
    }

    /**
     * Get all audiences of a specific author (using Has Many Through)
     */
    public function audiences($id)
    {
        $author = Author::findOrFail($id);
        $audiences = $author->audiences()->with('user')->get();

        return response()->json([
            'author' => $author->name,
            'audiences' => $audiences,
            'count' => $audiences->count(),
        ]);
    }
}

