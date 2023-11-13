<?php

namespace App\Http\Controllers;

use App\Models\Post;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.posts.index', [
            "posts" => Post::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $description = $request->description;

        $dom = new DOMDocument();
        $dom->loadHTML($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {
            $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
            $image_name = "/upload/" . time() . $key . '.png';
            file_put_contents(public_path() . $image_name, $data);

            $img->removeAttribute('src');
            $img->setAttribute('src', $image_name);
        }

        $description = $dom->saveHTML();

        // Gunakan hasil validasi untuk membuat entri di database
        Post::create([
            'name' => $request->name,
            'description' => $description,
        ]);

        return redirect('/dashboard/posts');
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('dashboard.posts.show', [
            "post" => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', [
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        // Dapatkan daftar gambar yang terkait dengan deskripsi sebelumnya
        $oldImages = $this->getImagesFromDescription($post->description);

        $description = $request->description;

        $dom = new DOMDocument();
        $dom->loadHTML($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        // Array untuk menyimpan gambar yang ada di deskripsi baru
        $newImages = [];

        foreach ($images as $key => $img) {
            // check if new image
            if (strpos($img->getAttribute('src'), 'data:image/') === 0) {
                $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                $image_name = "/upload/" . time() . $key . '.png';
                file_put_contents(public_path() . $image_name, $data);

                $img->removeAttribute('src');
                $img->setAttribute('src', $image_name);

                // Tambahkan nama file gambar baru ke array
                $newImages[] = $image_name;
            } else {
                // Jika bukan gambar baru, tambahkan jalur gambar yang sudah ada ke array
                $newImages[] = $img->getAttribute('src');
            }
        }
        // Identifikasi gambar-gambar yang perlu dihapus
        $deleteImages = array_diff($oldImages, $newImages);

        // Hapus gambar-gambar yang perlu dihapus
        foreach ($deleteImages as $deleteImage) {
            if (File::exists(public_path($deleteImage))) {
                File::delete(public_path($deleteImage));
            }
        }

        // Simpan HTML ke dalam file sementara
        $tempFilePath = tempnam(sys_get_temp_dir(), 'temp_html');
        $dom->saveHTMLFile($tempFilePath);

        // Baca kembali HTML dari file sementara
        $updatedDescription = file_get_contents($tempFilePath);

        // Hapus file sementara
        unlink($tempFilePath);

        // Update deskripsi
        $post->update([
            'name' => $request->name,
            'description' => $updatedDescription
        ]);

        return redirect('/dashboard/posts');
    }

    // Fungsi untuk mendapatkan daftar nama file gambar dari deskripsi
    private function getImagesFromDescription($description)
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');
        $imagePaths = [];

        foreach ($images as $img) {
            $imagePaths[] = $img->getAttribute('src');
        }

        return $imagePaths;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $description = $post->description;

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {
            $relativePath = $img->getAttribute('src');
            $path = public_path($relativePath);

            if (File::exists($path)) {
                File::delete($path);
            }
        }
        $post->delete();
        return redirect('/dashboard/posts');
    }
}
