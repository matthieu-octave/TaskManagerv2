<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        // 2. Appliquer la Policy à toutes les méthodes du contrôleur
        $this->authorizeResource(Category::class, 'category');
    }

    public function index() {
        return view('categories.index', ['categories' => Category::all()]);
    }
    public function create() {
        return view('categories.create');
    }
    public function store(Request $request) {
        $validated = $request->validate(['name' => 'required|string|max:255|unique:categories,name']);
        Category::create($validated);
        return redirect()->route('categories.index')->with('success', 'Catégorie créée !');
    }
    public function edit(Category $category) {
        return view('categories.edit', ['category' => $category]);
    }
    public function update(Request $request, Category $category) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)]
        ]);
        $category->update($validated);
        return redirect()->route('categories.index')->with('success', 'Catégorie mise à jour !');
    }
    public function destroy(Category $category) {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée !');
    }

    // La méthode show() n'est pas utilisée dans cet atelier
    public function show(Category $category) {
        return redirect()->route('categories.index');
    }
}
