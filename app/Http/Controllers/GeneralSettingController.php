<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\FileHandler;


class GeneralSettingController extends Controller
{
    use FileHandler;
    function index()
    {
        $settings = GeneralSetting::latest()->first();

        return view('admin.settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->getRules($request->type));

        if ($request->type === 'logo') {

            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                $validated['logo'] = $this->storeFile($request->file('logo'), 'settings/logo');
            }

            if ($request->hasFile('favicon') && $request->file('favicon')->isValid()) {
                $validated['favicon'] = $this->storeFile($request->file('favicon'), 'settings/logo');
            }
        }
        GeneralSetting::create($validated);
        toastr()->success('General Setting created successfully!');
        return back();
    }



    public function update(Request $request, GeneralSetting $generalSetting)
    {

            $validated = $request->validate($this->getRules($request->type));

            if ($request->type === 'logo') {
                if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                    
                    $validated['logo'] = $this->updateFile($request->file('logo'),$generalSetting->logo, 'settings/logo');
                    
                }
                if ($request->hasFile('favicon') && $request->file('favicon')->isValid()) {
                    $validated['favicon'] =  $this->updateFile($request->file('favicon'),$generalSetting->favicon, 'settings/logo');   
                }
            }
    
            $generalSetting->update($validated);
    
            toastr()->success('General Setting updated successfully!');
        
       return back();
 

    }



    private function getRules($type)
    {
        if ($type === 'basic_info') {
            return [
                'site_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'alternate_phone' => 'nullable|string|max:20',
                'email' => 'required|email|max:255',
                'copyright' => 'nullable|string|max:255',
            ];
        }
        if ($type === 'logo') {
            return [
                'logo' => 'nullable|image|max:2048',
                'favicon' => 'nullable|image|max:2048',
            ];
        }
        if ($type === 'company_info') {
            return [
                'company_name' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
            ];
        }
        if ($type === 'bank_details') {
            return [
                'bank_details' => 'nullable|array',
                'bank_details.account_title' => 'nullable|string|max:255',
                'bank_details.account_number' => 'nullable|string|max:255',
                'bank_details.bank_name' => 'nullable|string|max:255',
                'bank_details.bank_code' => 'nullable|string|max:50',
            ];
        }
        if ($type === 'social_links') {
            return [
                'social_links' => 'required|array',
                'social_links.facebook' => 'nullable|url',
                'social_links.twitter' => 'nullable|url',
                'social_links.instagram' => 'nullable|url',
                'social_links.pinterest' => 'nullable|url',
                'social_links.youtube' => 'nullable|url',
                'social_links.tiktok' => 'nullable|url',
            ];
        }
        if ($type == 'about' || $type == 'terms' || $type == 'privacy') {
            return [
                'about' => 'sometimes|string',
                'terms' => 'sometimes|string',
                'privacy' => 'sometimes|string',
            ];
        }
        return [];
    }
}
