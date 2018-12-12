<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class FileStorageController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function getPostImage($postId, $filename)
    {

        $path = storage_path('app\public\images\post\\'.$postId.'\\'.$filename);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
