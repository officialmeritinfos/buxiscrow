<?php

namespace App\Http\Controllers;

use App\Models\Businesses;
use App\Models\CurrencyAccepted;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\GeneralSettings;
use App\Models\Testimonials;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $generalSettings = GeneralSettings::where('id',1)->first();
        $businesses = Businesses::where('status',1)->where('isVerified',1)->inRandomOrder()->limit(5)->get();
        $testimonials = Testimonials::where('status',1)->inRandomOrder()->get();
        $dataView=['web'=>$generalSettings,'pageName'=>$generalSettings->siteName,'slogan'=>'Preventing Fraud in Transactions',
            'businesses'=>$businesses,'testimonials'=>$testimonials];
        return view('home',$dataView);
    }
    public function about(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $businesses = Businesses::where('status',1)->where('isVerified',1)->inRandomOrder()->limit(5)->get();
        $testimonials = Testimonials::where('status',1)->inRandomOrder()->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'About '.$generalSettings->siteName,'slogan'=>'The '.$generalSettings->siteName.' Story' ,
            'businesses'=>$businesses,'testimonials'=>$testimonials];
        return view('about',$dataView);
    }
    public function career(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $businesses = Businesses::where('status',1)->where('isVerified',1)->inRandomOrder()->limit(5)->get();
        $testimonials = Testimonials::where('status',1)->inRandomOrder()->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Work With '.$generalSettings->siteName,'slogan'=>' Available Openings' ,
            'businesses'=>$businesses,'testimonials'=>$testimonials];
        return view('career',$dataView);
    }
    public function team(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $businesses = Businesses::where('status',1)->where('isVerified',1)->inRandomOrder()->limit(5)->get();
        $testimonials = Testimonials::where('status',1)->inRandomOrder()->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Team '.$generalSettings->siteName,'slogan'=>'The '.$generalSettings->siteName.' Team' ,
            'businesses'=>$businesses,'testimonials'=>$testimonials];
        return view('team',$dataView);
    }
    public function faq(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $businesses = Businesses::where('status',1)->where('isVerified',1)->inRandomOrder()->limit(5)->get();
        $faqs = FaqCategory::where('status',1)->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Frequently Asked Questions','slogan'=>' Answers that follow' ,
            'businesses'=>$businesses,'categories'=>$faqs];
        return view('faq',$dataView);
    }
    public function faqDetails($id){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $businesses = Businesses::where('status',1)->where('isVerified',1)->inRandomOrder()->limit(5)->get();
        $faq_category = FaqCategory::where('id',$id)->first();
        $faqs = Faq::where('category_id',$id)->get();
        $dataView=['web'=>$generalSettings,'pageName'=>$faq_category->category_name.' Related Questions',
            'slogan'=>' Answers that follow' ,
            'businesses'=>$businesses,'faqs'=>$faqs];
        return view('faq_details',$dataView);
    }
    public function community(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $businesses = Businesses::where('status',1)->where('isVerified',1)->inRandomOrder()->limit(5)->get();
        $dataView=['web'=>$generalSettings,'pageName'=>$generalSettings->siteName.' Community',
            'slogan'=>'A community of safeguarded traders' ,];
        return view('community',$dataView);
    }
    public function stores(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $businesses = Businesses::where('status',1)->where('isVerified',1)->inRandomOrder()->limit(5)->get();
        $testimonials = Testimonials::where('status',1)->inRandomOrder()->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Start selling online now with '.$generalSettings->siteName.' marketplace.',
            'slogan'=>'Create an manage unlimited sales on '.$generalSettings->siteName,
            'businesses'=>$businesses,'testimonials'=>$testimonials];
        return view('stores',$dataView);
    }
    public function paymentLink(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $businesses = Businesses::where('status',1)->where('isVerified',1)->inRandomOrder()->limit(5)->get();
        $testimonials = Testimonials::where('status',1)->inRandomOrder()->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Payment Links','slogan'=>'Accept Payment from Users with zero coding knowledge',
            'businesses'=>$businesses,'testimonials'=>$testimonials];
        return view('payment-link',$dataView);
    }
    public function plugins(){

    }
    public function contact(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $businesses = Businesses::where('status',1)->where('isVerified',1)->inRandomOrder()->limit(5)->get();
        $dataView=['web'=>$generalSettings,'pageName'=>$generalSettings->siteName.' Contact page',
            'slogan'=>'A Quick Help Desk' ,];
        return view('contact',$dataView);
    }
    public function pricing(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $businesses = Businesses::where('status',1)->where('isVerified',1)->inRandomOrder()->limit(5)->get();
        $currencies = CurrencyAccepted::where('status',1)->get();
        $dataView=['web'=>$generalSettings,'pageName'=>$generalSettings->siteName.' Pricing page',
            'slogan'=>'Pricing','currencies'=>$currencies];
        return view('pricing',$dataView);
    }
    public function terms(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $businesses = Businesses::where('status',1)->where('isVerified',1)->inRandomOrder()->limit(5)->get();
        $dataView=['web'=>$generalSettings,'pageName'=>$generalSettings->siteName.' Terms and Conditions',
            'slogan'=>'Merchants and Buyers' ,];
        return view('terms',$dataView);
    }
    public function privacy(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $businesses = Businesses::where('status',1)->where('isVerified',1)->inRandomOrder()->limit(5)->get();
        $dataView=['web'=>$generalSettings,'pageName'=>$generalSettings->siteName.' Privacy Policy',
            'slogan'=>'How we store your data' ,];
        return view('privacy',$dataView);
    }
}
