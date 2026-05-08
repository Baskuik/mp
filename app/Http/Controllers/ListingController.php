<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ListingController extends Controller
{
    public function home(Request $request)
    {
        $sort = $request->query('sort', 'newest');
        $query = Listing::query()->with(['primaryImage', 'user']);

        if ($sort === 'label') {
            $query->orderBy('label')->orderByDesc('created_at');
        } elseif ($sort === 'price') {
            $query->orderBy('price')->orderByDesc('created_at');
        } else {
            $query->latest();
        }

        $listings = $query->take(12)->get();

        return view('welcome', [
            'listings' => $listings,
            'sort' => $sort,
        ]);
    }

    public function profile(Request $request)
    {
        $sort = $request->query('sort', 'newest');
        $query = $request->user()->listings()->with(['primaryImage', 'images']);

        if ($sort === 'label') {
            $query->orderBy('label')->orderByDesc('created_at');
        } elseif ($sort === 'price') {
            $query->orderBy('price')->orderByDesc('created_at');
        } else {
            $query->latest();
        }

        $categories = Category::orderBy('name')->get();

        return view('listings.profile', [
            'listings' => $query->get(),
            'categories' => $categories,
            'sort' => $sort,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'label' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'images' => 'nullable|array|max:8',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $categoryId = $validated['category_id'] ?? $this->getDefaultCategoryId();

        $listing = DB::transaction(function () use ($request, $validated, $categoryId) {
            $listing = Listing::create([
                'user_id' => $request->user()->user_id,
                'category_id' => $categoryId,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'label' => $validated['label'] ?? null,
                'price' => $validated['price'],
                'status' => 'active',
            ]);

            $this->storeImages($listing, $request->file('images', []));

            return $listing;
        });

        return redirect()
            ->route('profile')
            ->with('status', 'Item toegevoegd.');
    }

    public function edit(Request $request, Listing $listing)
    {
        $this->authorizeListing($request, $listing);

        $categories = Category::orderBy('name')->get();

        return view('listings.edit', [
            'listing' => $listing->load(['images', 'primaryImage']),
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Listing $listing)
    {
        $this->authorizeListing($request, $listing);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'label' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'images' => 'nullable|array|max:8',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $newImages = $request->file('images', []);
        $existingCount = $listing->images()->count();
        $newCount = count($newImages);

        if ($existingCount + $newCount > 8) {
            return back()->withErrors([
                'images' => 'Je mag maximaal 8 afbeeldingen uploaden.',
            ])->withInput();
        }

        $categoryId = $validated['category_id'] ?? $this->getDefaultCategoryId();

        DB::transaction(function () use ($listing, $validated, $categoryId, $newImages) {
            $listing->update([
                'category_id' => $categoryId,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'label' => $validated['label'] ?? null,
                'price' => $validated['price'],
            ]);

            $this->storeImages($listing, $newImages);
        });

        return redirect()
            ->route('profile')
            ->with('status', 'Item bijgewerkt.');
    }

    public function destroy(Request $request, Listing $listing)
    {
        $this->authorizeListing($request, $listing);

        $paths = $listing->images()->pluck('path')->all();
        if (count($paths) > 0) {
            Storage::disk('public')->delete($paths);
        }

        $listing->delete();

        return redirect()
            ->route('profile')
            ->with('status', 'Item verwijderd.');
    }

    private function authorizeListing(Request $request, Listing $listing): void
    {
        if ($listing->user_id !== $request->user()->user_id) {
            abort(403);
        }
    }

    private function storeImages(Listing $listing, array $images): void
    {
        $sortOrder = $listing->images()->max('sort_order') ?? 0;
        $hasPrimary = $listing->images()->where('is_primary', true)->exists();

        foreach ($images as $index => $image) {
            $path = $image->store('listings', 'public');

            ListingImage::create([
                'listing_id' => $listing->id,
                'path' => $path,
                'is_primary' => !$hasPrimary && $index === 0,
                'sort_order' => $sortOrder + $index + 1,
            ]);
        }
    }

    private function getDefaultCategoryId(): int
    {
        $category = Category::first();

        if ($category) {
            return $category->id;
        }

        $name = 'General';
        $slug = Str::slug($name);

        if (Category::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . Str::random(5);
        }

        $category = Category::create([
            'name' => $name,
            'slug' => $slug,
        ]);

        return $category->id;
    }
}
