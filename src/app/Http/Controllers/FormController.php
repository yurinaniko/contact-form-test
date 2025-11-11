<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;

class FormController extends Controller
{
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
    }
    public function index()
    {
        $categories = Category::all();
        return view('contact.index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $inputs = $request->validated();

        $genderText = match ($inputs['gender']) {
        '1' => '男性',
        '2' => '女性',
        '3' => 'その他',
        default => '未選択',
    };

        $inputs['tel'] = $request->input('tel1') . '-' . $request->input('tel2') . '-' . $request->input('tel3');

        $category = Category::find($request->category_id);
        $category_name = $category ? $category->content : '未選択';

        $pageTitle = 'お問い合わせ内容の確認';

        return view('contact.confirm', compact('inputs', 'genderText', 'category_name', 'pageTitle'));
    }

    public function thanks(ContactRequest $request)
    {
        if ($request->has('back')) {
            return redirect()->route('contact.index')->withInput();
        }

        $genderValue = 0;
        if ($request->gender === '男性' || $request->gender == 1) {
            $genderValue = 1;
        } elseif ($request->gender === '女性' || $request->gender == 2) {
            $genderValue = 2;
        } else {
            $genderValue = 3;
        }

        Contact::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'tel' => $request->tel,
            'address' => $request->address,
            'building' => $request->building,
            'category_id' => $request->category_id,
            'detail' => $request->detail,
        ]);

        $pageTitle = '送信完了';
        return view('contact.thanks', compact('pageTitle'));
    }
}