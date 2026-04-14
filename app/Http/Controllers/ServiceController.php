<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{

    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('services.index', compact('services'));
    }


    public function create()
    {
        return view('services.create');
    }


    public function store(Request $request)
    {

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'banner_image' => 'nullable|string',
            'main_image' => 'nullable|string',
            'extraImageA' => 'nullable|string',
            'extraImageB' => 'nullable|string',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // generate slug if empty
        if(empty($data['slug'])){
            $data['slug'] = Str::slug($data['title']);
        }

        Service::create($data);

        return redirect()
            ->route('services.index')
            ->with('success','Service created successfully');

    }


    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }


    public function update(Request $request, Service $service)
    {

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'banner_image' => 'nullable|string',
            'main_image' => 'nullable|string',
            'extraImageA' => 'nullable|string',
            'extraImageB' => 'nullable|string',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        if(empty($data['slug'])){
            $data['slug'] = Str::slug($data['title']);
        }

        $service->update($data);

        return redirect()
            ->route('services.index')
            ->with('success','Service updated');

    }


    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()
            ->route('services.index')
            ->with('success','Service deleted');
    }

    public function frontServicePage()
    {
        $services = Service::latest()->paginate(10);
        return view('front.services.index', compact('services'));
    }

    public function frontServiceSingle($slug)
    {
        $services = Service::all();
        $service = Service::where('slug', $slug)->firstOrFail();
        return view('front.services.single', compact('service', 'services'));
    }
}
