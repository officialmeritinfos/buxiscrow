<?php

namespace App\Http\Controllers;

use App\Models\Businesses;
use App\Models\GeneralSettings;
use App\Models\Testimonials;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $generalSettings = GeneralSettings::where('id',1)->first();
        $businesses = Businesses::where('status',1)->where('isVerified',1)->inRandomOrder()->limit(5)->get();
        $testimonials = Testimonials::where('status',1)->inRandomOrder()->get();
        $dataView=['web'=>$generalSettings,'pageName'=>$generalSettings->siteName,'slogan'=>'- Preventing Fraud in Transactions',
            'businesses'=>$businesses,'testimonials'=>$testimonials];
        return view('home',$dataView);
    }
}
