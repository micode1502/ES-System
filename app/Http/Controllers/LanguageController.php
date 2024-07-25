<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLang(Request $request)
    {
        //$lang = $request->input('lang');

        $messages = [
            'lang.in' => __('The selected language is invalid. Please choose a valid language.'),
        ];

        $validated = $request->validateWithBag('updatePreferences', [
            'lang' => ['required', 'string', 'in:' . implode(',', array_keys(__('actions.lang')))],
        ], $messages);

        session()->put('lang', $validated['lang']);

        $request->user()->update([
            'lang' => $validated['lang']
        ]);

        return redirect()->back()->with('status', 'preferences-updated');
    }
}