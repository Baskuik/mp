<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Category;
use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    public function home(Request $request)
    {
        $sort = $request->query('sort', 'newest');
        $activeLabel = $request->query('label');
        $labelCards = $this->listingLabels();
        $labels = collect($labelCards)->pluck('label')->all();
        $query = Listing::query()->with(['primaryImage', 'user']);

        if ($activeLabel && in_array($activeLabel, $labels, true)) {
            $query->where('label', $activeLabel);
        }

        if ($sort === 'label') {
            $query->orderBy('label')->orderByDesc('created_at');
        } elseif ($sort === 'price') {
            $query->orderBy('price')->orderByDesc('created_at');
        } else {
            $query->latest();
        }

        $listings = $query->take(12)->get();

        return view('welcome', [
            'labelCards' => $labelCards,
            'labels' => $labels,
            'activeLabel' => $activeLabel,
            'listings' => $listings,
            'sort' => $sort,
        ]);
    }

    public function profile(Request $request)
    {
        $sort = $request->query('sort', 'newest');
        $labels = $this->listingLabelNames();
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
            'labels' => $labels,
            'sort' => $sort,
        ]);
    }

    public function store(Request $request)
    {
        $labels = $this->listingLabelNames();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => [
                'required',
                'string',
                function (string $attribute, mixed $value, $fail): void {
                    $this->enforceDescriptionWordLimit($value, $fail);
                },
            ],
            'label' => ['nullable', 'string', Rule::in($labels)],
            'listing_type' => ['required', 'string', Rule::in(['fixed', 'bidding'])],
            'price' => [
                'nullable',
                'numeric',
                'min:0',
                Rule::requiredIf(fn () => $request->input('listing_type', 'fixed') === 'fixed'),
            ],
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
                'listing_type' => $validated['listing_type'],
                'price' => $validated['price'] ?? null,
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
        $labels = $this->listingLabelNames();

        return view('listings.edit', [
            'listing' => $listing->load(['images', 'primaryImage']),
            'categories' => $categories,
            'labels' => $labels,
        ]);
    }

    public function update(Request $request, Listing $listing)
    {
        $this->authorizeListing($request, $listing);

        $labels = $this->listingLabelNames();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => [
                'required',
                'string',
                function (string $attribute, mixed $value, $fail): void {
                    $this->enforceDescriptionWordLimit($value, $fail);
                },
            ],
            'label' => ['nullable', 'string', Rule::in($labels)],
            'listing_type' => ['required', 'string', Rule::in(['fixed', 'bidding'])],
            'price' => [
                'nullable',
                'numeric',
                'min:0',
                Rule::requiredIf(fn () => $request->input('listing_type', 'fixed') === 'fixed'),
            ],
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
                'listing_type' => $validated['listing_type'],
                'price' => $validated['price'] ?? null,
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

    public function show(Listing $listing)
    {
        $listing->load(['images', 'primaryImage', 'user', 'category']);
        $highestBid = Bid::where('listing_id', $listing->listing_id)->max('amount');
        $bidsCount = Bid::where('listing_id', $listing->listing_id)->count();
        $recentBids = Bid::where('listing_id', $listing->listing_id)
            ->with('buyer')
            ->latest()
            ->take(5)
            ->get();
        $sortedImages = $listing->images->sortBy('sort_order')->values();

        return view('listings.show', [
            'listing' => $listing,
            'images' => $sortedImages,
            'highestBid' => $highestBid,
            'bidsCount' => $bidsCount,
            'recentBids' => $recentBids,
        ]);
    }

    public function destroyImage(Request $request, Listing $listing, ListingImage $image)
    {
        $this->authorizeListing($request, $listing);

        if ($image->listing_id !== $listing->id) {
            abort(404);
        }

        $wasPrimary = $image->is_primary;
        Storage::disk('public')->delete($image->path);
        $image->delete();

        if ($wasPrimary) {
            $replacement = $listing->images()->orderBy('sort_order')->first();

            if ($replacement) {
                $replacement->update(['is_primary' => true]);
            }
        }

        return back()->with('status', 'Afbeelding verwijderd.');
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

    private function listingLabels(): array
    {
        return [
            ['label' => 'Elektronica', 'icon' => 'M7 3h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2zm2 14h6'],
            ['label' => 'Huis & Tuin', 'icon' => 'M3 11l9-7 9 7v9a2 2 0 01-2 2h-4v-6H9v6H5a2 2 0 01-2-2z'],
            ['label' => 'Mode', 'icon' => 'M9 4l-2 4v3h10V8l-2-4-3 2-3-2zm-1 7h8v9H8z'],
            ['label' => 'Voertuigen', 'icon' => 'M5 11l1-3h12l1 3v5a1 1 0 01-1 1h-1a2 2 0 01-4 0H9a2 2 0 01-4 0H4a1 1 0 01-1-1v-5zm3 7a1 1 0 102 0 1 1 0 00-2 0zm6 0a1 1 0 102 0 1 1 0 00-2 0z'],
            ['label' => 'Hobby', 'icon' => 'M12 6l2.2 4.5L19 11l-3.5 3.4.8 4.6L12 16.8 7.7 19l.8-4.6L5 11l4.8-.5z'],
            ['label' => 'Overig', 'icon' => 'M6 12a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm4.5 0a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm4.5 0a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z'],
        ];
    }

    private function listingLabelNames(): array
    {
        return collect($this->listingLabels())->pluck('label')->all();
    }

    private function enforceDescriptionWordLimit(mixed $value, callable $fail): void
    {
        $words = str_word_count(strip_tags((string) $value));

        if ($words > 400) {
            $fail('De beschrijving mag maximaal 400 woorden bevatten.');
        }
    }
}
