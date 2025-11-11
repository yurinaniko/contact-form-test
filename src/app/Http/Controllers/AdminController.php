<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;
use App\Models\Category;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{

    public function __construct()
    {
    $this->middleware('auth');
    }

    public function index()
    {
        $contacts = Contact::with('category')->paginate(7);
        $categories = Category::all();
        return view('admin.index', compact('contacts', 'categories'));
    }

        public function search(Request $request)
    {
        $query = Contact::query();
        $query = Contact::with('category');

        if ($request->filled('keyword')) {
        $keyword = trim(mb_convert_kana($request->keyword, 's'));
        $escaped = addcslashes($keyword, '%_');

        $query->where(function ($q) use ($escaped) {
        $q->where('first_name', 'like', "%{$escaped}%")
            ->orWhere('last_name',  'like', "%{$escaped}%")
            ->orWhere('email',      'like', "%{$escaped}%")
            ->orWhere(DB::raw("REPLACE(CONCAT(last_name, first_name), ' ', '')"), 'like', "%".str_replace(' ', '', $escaped)."%")
            ->orWhere(DB::raw("CONCAT(last_name, ' ', first_name)"), 'like', "%{$escaped}%");
        });
        }
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }


        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->paginate(7);


        $categories = Category::all();


        return view('admin.index', compact('contacts', 'categories'));
    }

    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return redirect()->route('admin.index')->with('success', '削除しました');
    }
    public function export()
{
    $contacts = Contact::with('category')->orderBy('created_at', 'desc')->get();

    $response = new StreamedResponse(function () use ($contacts) {
        $handle = fopen('php://output', 'w');

        // ヘッダー行
        fputcsv($handle, [
            '名前',
            '性別',
            'メール',
            '電話番号',
            '住所',
            '建物名',
            'お問い合わせ種類',
            'お問い合わせ内容',
            '作成日'
        ]);

        foreach ($contacts as $contact) {
            fputcsv($handle, [
                $contact->last_name . ' ' . $contact->first_name,
                $contact->gender,
                $contact->email,
                $contact->tel,
                $contact->address,
                $contact->building,
                $contact->category->content ?? '',
                $contact->detail,
                $contact->created_at->format('Y-m-d'),
            ]);
        }

        fclose($handle);
    });

    $response->headers->set('Content-Type', 'text/csv');
    $response->headers->set('Content-Disposition', 'attachment; filename="contacts.csv"');

    return $response;
}
}

