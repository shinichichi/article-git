<?php

namespace App\Http\Controllers;

use App\Models\ArticleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadControleer extends Controller
{
    // 記事でアップロードする画像を保蔵する
    public function upload(Request $request)
    {
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $image_name = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/uploads', $image_name);

            // データベースに保存
            $image = new ArticleImage();
            $image->image_name = $image_name;
            $image->save();

            return response()->json(['url' => Storage::url('public/uploads/'. $image_name)]);
        }
    }
}
