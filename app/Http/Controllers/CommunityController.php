<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class CommunityController extends Controller
{
    public function index()
    {
        $posts = Community::latest()->get();
        return view('community.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'foto' => 'required|file|mimes:jpeg,jpg,png|image',
            'pesan' => 'required|string',
            'user_id' => 'nullable',
            'judul' => 'required|string|max:100',
        ]);

        $data['user_id'] = auth()->id();

        $data['foto'] = $request->file('foto')->store('communities-image');

        Community::create($data);

        return back()->with('message', 'Post berhasil dibuat!');
    }

    public function create()
    {
        return view('community.create');
    }

    public function usersCommunity()
    {
        $posts = Community::query()
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('community.my-posts', compact('posts'));
    }

    public function edit(Community $post)
    {

        return view('community.edit', compact('post'));
    }

    public function destroy($id)
    {
        $posts = Community::find($id);
        $posts->delete();
        return view('community.index');
    }

    public function update(Request $request, Community $post)
    {
        $data = $request->validate([
            'foto' => 'file|mimes:jpeg,jpg,png|image',
            'pesan' => 'required|string',
            'user_id' => 'nullable',
            'judul' => 'required|string|max:100',
        ]);

        if ($request->hasFile('foto')) {
            if($post->foto){
                Storage::delete('communities-image/'.$post->foto);
            }
            $data['foto'] = $request->file('foto')->store('communities-image');
        }

        $post->update($data);

        return redirect()->route('my-communities')->with('message', 'Post berhasil di update!');

    }
}
