<?php

namespace App\Http\Controllers;

use App\User;
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
        //delete image file from the server
        $this->deleteFileFromServer($request->iconImage, true);

        $this->validate($request, [
            'id' => 'required',
        ]);

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
        $this->deleteFileFromServer($fileName, false);
        return 'done';
    }
    public function deleteFileFromServer($fileName, $hasFullPath = false)
    {
        if (!$hasFullPath) {
            $filePath = public_path() . '/uploads/' . $fileName;
        } else {
            $filePath = public_path() . $fileName;
        }
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        return;
    }
    public function addUser(Request $request)
    {
        $this->validate($request, [
            'fullName' => 'required',
            'email' => 'bail|required|email', //bail : required에서 실패할경우 email validation을 생략하고 바로 에러를 반환
            'password' => 'required|min:6',
            'userType' => 'required'
        ]);

        $password = bcrypt($request->password);

        $user = User::create([
            'fullName' => $request->fullName,
            'email' => $request->email, //bail : required에서 실패할경우 email validation을 생략하고 바로 에러를 반환
            'password' => $password,
            'userType' =>  $request->userType,
        ]);

        return $user;
    }
    public function getUser()
    {
        return User::where('userType', '!=', 'User')->get();
    }
}
