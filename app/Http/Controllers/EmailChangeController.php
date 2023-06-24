<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailChangeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmailChangeController extends Controller
{
    public function edit()
    {
        $admin = Auth::user();
        return view('admin.email.edit', compact('admin'));
    }

    public function update(EmailChangeRequest $request)
    {
        $admin = Auth::user();

        // 現在のメールアドレスが一致するかを確認
        if ($request->current_email !== $admin->email) {
            return redirect()->back()->withErrors(['flash_delete' => '現在のメールアドレスが一致しません。'])->withInput();
        }

        // 新しいメールアドレスを保存
        $admin->email = $request->new_email;
        $admin->save();

        return redirect()->back()->with('flash_message', 'メールアドレスが変更されました。');
    }
}
