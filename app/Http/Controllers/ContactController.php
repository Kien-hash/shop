<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Exception;

class ContactController extends Controller
{
    public function getConfig()
    {
        $contact = Contact::all()->first();
        if ($contact)
            return view('admin.contact.edit', ['contact' => $contact]);
        else
            return view('admin.contact.edit', ['contact' => null]);
    }

    public function postConfig(Request $request)
    {
        $this->validate($request, [
            'contact' => 'required',
            'map' => 'required',
            'fanpage' => 'required',
            // 'image' => 'required',
        ], [
            'contact.required' => 'Contact can not be empty',
            'map.required' => 'Map can not be empty',
            'fanpage.required' => 'Fanpage can not be empty',
        ]);
        $contact = Contact::all()->first();
        if ($contact) {
            $contact->contact = $request->contact;
            $contact->map = $request->map;
            $contact->fanpage = $request->fanpage;
        } else {
            $contact = new Contact();
            $contact->contact = $request->contact;
            $contact->map = $request->map;
            $contact->fanpage = $request->fanpage;
        }

        $get_image = $request->file('image');
        if ($get_image) {
            if ($contact->image) {
                try {
                    unlink('public/uploads/contact/' . $contact->image);
                } catch (Exception $e) {
                }
            }
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/contact', $new_image);
            $contact->image = $new_image;
        } else {
            $contact->image = '';
        }

        $contact->save();
        return redirect()->back()->with('Notice', 'Website contact infomation edit successfully');
    }
}
