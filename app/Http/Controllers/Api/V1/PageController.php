<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\GeneralSetting;

class PageController
{

    public function index($page)
    {

        switch ($page) {
            case 'about':
                return $this->aboutPage();
            case 'privacy-policy':
                return $this->policyPage();
            case 'terms':
                return $this->termsPage();
            default:
                return response()->json(['error' => 'Page not found'], 404);
        }

        return response()->json([
            'message' => 'Welcome to the API',
            'version' => '1.0.0'
        ]);
    }

    private function aboutPage()
    {

        $aboutSetting = GeneralSetting::first()->about ?? 'No about information available.';

        return response()->json([
            'about' => $aboutSetting
        ]);
    }

    private function policyPage()
    {
        $policySetting = GeneralSetting::first()->privacy ?? 'No privacy information available.';

        return response()->json([
            'privacy' => $policySetting
        ]);
    }

    private function termsPage()
    {
        $policySetting = GeneralSetting::first()->terms ?? 'No Terms information available.';

        return response()->json([
            'terms' => $policySetting
        ]);
    }
}
