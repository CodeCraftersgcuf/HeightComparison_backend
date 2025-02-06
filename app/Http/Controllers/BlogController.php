<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('Blog.index',compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'required|string|max:255',
            'description' => 'required|string',
            'meta_description' => 'required|string',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tags' => 'required|array',
        ]);
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '.' . $image->getClientOriginalName();

            $image->storeAs('images', $imageName, 'public');
        } else {
            $imageName = null;
        }
        $tagsString = implode(',', $request->tags);
        Blog::create([
            'title' => $request->title,
            'meta_title' => $request->meta_title,
            'description' => $request->description,
            'meta_description' => $request->meta_description,
            'featured_image' => $imageName,
            'tags' => $tagsString,
        ]);

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = Blog::findOrFail($id);
        // return $blogs;
        return view('blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::find($id);
        $existingTags = explode(',', $blog->tags);
        return view('blog.edit', compact('blog','existingTags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'required|string|max:255',
            'description' => 'required|string',
            'meta_description' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tags' => 'required|array',
        ]);
        $tagsString = implode(',', $request->tags);
        
        $blog = Blog::findOrFail($id);
        $blog->title = $request->title;
        $blog->meta_title = $request->meta_title;
        $blog->description = $request->description;
        $blog->meta_description = $request->meta_description;
        $blog->tags = $tagsString;


        // Handle file upload for featured image (if new image is uploaded)
        if ($request->hasFile('featured_image')) {
            // Delete the old image if it exists
            if (!empty($blog->featured_image)) {
                File::delete(public_path('storage/images/'.$blog->featured_image));
            }
    
            // Store the new image
            $image = $request->file('featured_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('images', $imageName, 'public');
            
            // Update the image path in the category
            $blog->featured_image = $imageName;
        }

        $blog->save();
    
        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        if (!empty($blog->featured_image)) {
            File::delete(public_path('storage/images/'.$blog->featured_image));
        }
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }
}
