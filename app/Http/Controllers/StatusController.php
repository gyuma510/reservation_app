<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function update(Request $request, Contact $contact)
    {
        if ($request->isMethod('post')) {
            $contact->status()->create([
                'contact_id' => $contact->id,
            ]);

            return back()->with('flash_message', '対応済にしました');
        } elseif ($request->isMethod('delete')) {
            $contact->status()->where('contact_id', $contact->id)->delete();

            return back()->with('flash_delete', '未対応にしました');
        }
    }
}
