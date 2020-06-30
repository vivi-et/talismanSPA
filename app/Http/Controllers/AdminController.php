<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Tag;

class AdminController extends Controller
{
    public function addTag(Request $request)
    {

        //validate request
        $this->validate($request, [
            'tagName' => 'required'
        ]);

        return Tag::create([
            'tagName' => $request->tagName
        ]);
    }
    public function addCategory(Request $request)
    {

        //validate request
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required'
        ]);

        return Category::create([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage
        ]);
    }



    public function editTag(Request $request)
    {

        //validate request
        $this->validate($request, [
            'tagName' => 'required',
            'id' => 'required',
        ]);

        return Tag::where('id', $request->id)->update([
            'tagName' => $request->tagName
        ]);
    }

    public function editCategory(Request $request)
    {

        //validate request
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required',
        ]);

        return Category::where('id', $request->id)->update([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage
        ]);
    }




    public function deleteTag(Request $request)
    {
        return Tag::where('id', $request->id)->delete();
    }

    public function deleteCategory(Request $request)
    {
        return Category::where('id', $request->id)->delete();
    }


    public function getTag()
    {
        return Tag::orderBy('id', 'desc')->get();
    }
        public function getCategory()
    {
        return Category::orderBy('id', 'desc')->get();
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png'
        ]);
        $picName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }
    public function deleteImage(Request $request)
    {
        $fileName = $request->imageName;
        $this->deleteFileFromServer($fileName);
        return 'done';
    }
    public function deleteFileFromServer($fileName)
    {
        $filePath = public_path() . '/uploads/' . $fileName;
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        return;
    }
}
