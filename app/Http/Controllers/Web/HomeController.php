<?php

namespace App\Http\Controllers\Web;

use App\DataTables\SubscriptionDataTable;
use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Cdc;
use App\Models\Faq;
use App\Models\Blog;
use App\Models\Page;
use App\Models\Role;
use App\Models\User;
use App\Models\Boost;
use App\Models\Brand;
use App\Models\Forum;
use App\Models\Action;
use App\Models\Banner;
use App\Mail\SendEmail;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Medicine;
use App\Models\CdcComment;
use App\Models\Transaction;
use App\Traits\HelperTrait;
use Illuminate\Support\Str;
use App\Models\ForumComment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\ClinicalTrial;
use App\Models\EmailTemplate;
use Illuminate\Support\Carbon;
use App\Models\ProductCategory;
use App\Models\BoostTransaction;
use App\Models\EmailVerification;
use App\Models\ProductSubCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\SubscriptionFeature;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use App\Models\SubscriptionUserDetail;
use App\DataTables\Web\TransactionDataTable;
use Illuminate\Support\Facades\Mail as Email;
use Illuminate\Pagination\LengthAwarePaginator;
use App\DataTables\Web\BoostTransactionDataTable;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\Coupon;
use Illuminate\Support\Facades\Http;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\RateLimiter;
use Barryvdh\DomPDF\Facade\Pdf;

class HomeController extends Controller
{

  use HelperTrait;
  public function __construct() {}



  public function indexPage(Request $request)
  {
    $banners   = Banner::where(['banner_type' => 'working-partner', 'page_name' => 'home'])->get();
    $sections  = Page::where('status', 1)->get();
    $settings  = Setting::where('is_visible', 1)->get();
    $home      = $sections->where('section_name', 'home')->first();

    $cdc       = $sections->where('section_name', 'cdc_media')->first();
    $cdcs      = Cdc::where('status', 1)->orderBy('id', 'DESC')->take(3)->get();

    $faqSection  = $sections->where('section_name', 'faqs')->first();
    $faqs        = Faq::where('status', 1)->orderBy('id', 'DESC')->take(3)->get();

    $forum  = $sections->where('section_name', 'forum')->first();



    //return $faqs;
    return view('web.index', compact('banners', 'forum', 'cdc', 'cdcs', 'faqSection', 'faqs', 'home','settings'));
  }


  public function dashboard(Request $request)
  {
    $forum = Forum::where(['status' => 1])->orderBy('id', 'DESC')->first();
    $cdc = Cdc::where(['status' => 1])->orderBy('id', 'DESC')->first();
    $faqs = Faq::where(['status' => 1])->orderBy('id', 'DESC')->take(4)->get();

    return view('web.dashboard', compact('forum', 'faqs', 'cdc'));
  }


  public function subscription(Request $request, SubscriptionDataTable $dataTable)
  {

    return $dataTable->render('web.subscription');
  }

  public function faq(Request $request)
  {
    $faqs = Faq::where('status', 1)->get();
    return view('web.faq', compact('faqs'));
  }

  public function askAI(Request $request)
  {

    return view('web.askai');
  }
//   public function ask(Request $request)
//   {
//     $request->validate([
//       'message' => 'required|string|max:500',
//     ]);

//     $response = OpenAI::chat()->create([
//       'model' => 'gpt-4o-mini',
//       'messages' => [
//         ['role' => 'system', 'content' => 'You are a helpful assistant.'],
//         ['role' => 'user', 'content' => $request->input('message')],
//       ],
//     ]);
// dd( $response);
//     return response()->json([
//       'reply' => $response->choices[0]->message->content,
//     ]);
//   }




//     public function ask(Request $request)
//     {
//         // Rate limit: 3 requests per minute per IP
//         $key = 'chat-' . $request->ip();
        
//         if (RateLimiter::tooManyAttempts($key, 3)) {
//             $seconds = RateLimiter::availableIn($key);
            
//             return response()->json([
//                 'error' => true,
//                 'reply' => "Woof! Duke needs a quick break. Please wait {$seconds} seconds before asking again. 🐕"
//             ], 429);
//         }

//         $request->validate([
//             'message' => 'required|string|max:500',
//         ]);

//         try {
//             // Record this attempt
//             RateLimiter::hit($key, 60); // 60 seconds = 1 minute

//             $response = OpenAI::chat()->create([
//     'model' => 'gpt-5-nano',
//     'messages' => [
//         ['role' => 'system', 'content' => 'You are Duke, a helpful golden retriever assistant for iPharmacy. Provide brief health information and remind users to consult a doctor.'],
//         ['role' => 'user', 'content' => $request->input('message')],
//     ],
//     'max_completion_tokens' => 200,
// ]);
// dd($response);
//             return response()->json([
//                 'reply' => $response->choices[0]->message->content,
//             ]);

//         } 
//         catch (\OpenAI\Exceptions\RateLimitException $e) {
//             \Log::error('OpenAI Rate Limit: ' . $e->getMessage());
            
//             return response()->json([
//                 'error' => true,
//                 'reply' => '🐕 Woof! Duke is getting too many questions right now. Please wait a minute and try again!'
//             ], 429);
            
//         } 
//         catch (\Exception $e) {
//             \Log::error('Chat error: ' . $e->getMessage());
            
//             return response()->json([
//                 'error' => true,
//                 'reply' => $e->getMessage()
//             ], 500);
//         }
//     }
public function ask(Request $request)
{
    $key = 'chat-' . $request->ip();

    if (RateLimiter::tooManyAttempts($key, 3)) {
        $seconds = RateLimiter::availableIn($key);

        return response()->json([
            'error' => true,
            'reply' => "Woof! Duke needs a quick break. Please wait {$seconds} seconds before asking again. 🐕"
        ], 429);
    }

    $request->validate([
        'message' => 'required|string|max:500',
    ]);

    try {

        RateLimiter::hit($key, 60);

        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are Duke, a friendly golden retriever assistant for iPharmacy. Provide short health information and remind users to consult a doctor.'
                ],
                [
                    'role' => 'user',
                    'content' => $request->input('message')
                ],
            ],
            'max_completion_tokens' => 300
        ]);

        $reply = '';

        if (!empty($response->choices[0]->message->content)) {
            if (is_array($response->choices[0]->message->content)) {
                $reply = $response->choices[0]->message->content[0]->text ?? '';
            } else {
                $reply = $response->choices[0]->message->content;
            }
        }

        if ($reply == '') {
            $reply = "Woof! Duke couldn't respond right now. Please try again. 🐕";
        }

        return response()->json([
            'reply' => $reply
        ]);

    } catch (\Exception $e) {

        \Log::error('Chat error: ' . $e->getMessage());

        return response()->json([
            'error' => true,
            'reply' => 'Something went wrong. Please try again later.'
        ], 500);
    }
}
  public function media(Request $request)
  {
    //$cdcs = Cdc::where('status', 1)->get();
    $cdcs_media = [];
    return view('web.media', compact('cdcs_media'));
  }

  public function mediaLetter(Request $request, $letter)
    {

        $cdcs = Cdc::where('title', 'ILIKE', "{$letter}%")->where('status', 1)->orderBy('title', 'asc')->paginate(10);
        //dd( $medicines);
        $letter = strtoupper($letter);
        return view('web.media', compact('cdcs', 'letter'));
    }

  public function mediaDetail(Request $request, $slug)
  {
    $cdc = Cdc::where('slug', $slug)->first();
    if (!$cdc || $cdc->status != 1) {
      abort(404);
    }
    $cdcs = Cdc::where('status', 1)
      ->where('slug', '<>', $slug)
      ->orderBy('created_at', 'desc')
      ->take(3)
      ->get();
    return view('web.media-detail', compact('cdc', 'cdcs'));
  }

  public function cdcStore(Request $request)
  {


    $request->validate([
      'cdc_id' => 'required|exists:cdcs,id',
      'name' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'website' => 'nullable|url|max:255',
      'message' => 'required|string',
      'g-recaptcha-response' => 'required'
    ]);
    $response = Http::withOptions(['verify' => false])->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
      'secret' => env('NOCAPTCHA_SECRET'),
      'response' => $request->input('g-recaptcha-response'),
      'remoteip' => $request->ip(),
    ]);

    $result = $response->json();

    if (!($result['success'] ?? false)) {
      return back()->withErrors(['g-recaptcha-response' => 'Captcha verification failed.'])->withInput();
    }
    CdcComment::create([
      'cdc_id' => $request->cdc_id,
      'name' => $request->name,
      'email' => $request->email,
      'website' => $request->website,
      'message' => $request->message,

    ]);

    return back()->with('success', 'Your comment has been submitted.');
  }

  public function forum(Request $request)
  {
    $forums = Forum::with(['comments.user'])->where(['status' => 1])
      ->orderBy('id', 'DESC')->paginate(19);

    foreach ($forums as $forum) {
      $forum->latest_comment_users = $forum->comments->take(8)->pluck('user.name')->unique();
      $forum->extra_users_count = max(0, $forum->comments->pluck('user_id')->unique()->count() - 8);
    }

    // return $forums ;

    return view('web.forum', compact('forums'));
  }

  public function forumLike(Request $request, $id)
  {
    if (\Auth::user()) {
      $action =  Action::where(['user_id' => \Auth::user()->id, 'action_type' => 'like', 'table_id' => $id, 'table' => 'forums'])->first();

      if (empty($action)) {
        $action = Action::create(['user_id' => \Auth::user()->id, 'action_type' => 'like', 'status' => 1, 'table_id' => $id, 'table' => 'forums']);
        $actionCount = Action::where(['user_id' => \Auth::user()->id, 'action_type' => 'like', 'status' => 1, 'table_id' => $id, 'table' => 'forums'])->count();
        return response()->json(['status' => true, 'likes_count' =>  $actionCount], 200);
      } else {
        // Toggle like/unlike
        $action->update(['status' => $action->status == 1 ? 0 : 1]);
      }
      $actionCount = Action::where(['action_type' => 'like', 'status' => 1, 'table_id' => $id, 'table' => 'forums'])->count();
      return response()->json(['status' => true, 'likes_count' =>  $actionCount], 200);
    }

    return response()->json(['status' => false, 'message' =>  "Kindly login."], 200);
  }

  public function forumComment(Request $request, $id)
  {
    $request->validate([
      'comment' => 'required|string|max:2000',
    ]);

    $comment = ForumComment::create([
      'forum_id' => $id,
      'user_id' => \Auth::id(),
      'comment' => $request->comment,
      'status' => 1,
    ]);

    // Load user relationship for returning in JSON
    $comment->load('user');

    return response()->json([
      'status' => true,
      'message' => 'Comment added successfully.',
      'comment' => [
        'id' => $comment->id,
        'comment' => $comment->comment,
        'user_name' => $comment->user->name,
        'user_avatar' => is_file(public_path('storage/' . $comment?->user?->image)) ? url('storage/' . $comment?->user?->image) : url('default-profile.jpg'),
        'created_at' => $comment->created_at->diffForHumans(),
      ]
    ]);
  }
  public function loadComments($forumId, Request $request)
  {
    $offset = $request->input('offset', 0);
    $limit = 2;

    $forum = Forum::findOrFail($forumId);
    $comments = $forum->comments()->skip($offset)->take($limit)->get();

    return view('web.forum-comments', compact('comments'))->render();
  }
  public function sponsor(Request $request)
  {
    $sponsors   = Banner::where(['banner_type' => 'working-partner', 'page_name' => 'home'])->orderBy('name')->get();

    //$faqs=Faq::where('status',1)->get();
    return view('web.sponsor', compact('sponsors'));
  }
  public function clinicalTrails(Request $request)
  {
    //$faqs=Faq::where('status',1)->get();
    return view('web.clinical-trails');
  }

  public function coupons(Request $request)
  {
    
    // $coupons = Coupon::where('status', 1)->orderBy('title','ASC')->get();
    $coupons_list_pre =[];
    return view('web.coupons', compact('coupons_list_pre'));
  }

  public function couponsLetter(Request $request, $letter)
  {

      $coupons = Coupon::where('discount', 'ILIKE', "{$letter}%")->where('status', 1)->orderBy('discount', 'asc')->paginate(10);
      //dd( $medicines);
      $letter = strtoupper($letter);
      return view('web.coupons', compact('coupons', 'letter'));
  }

  public function downloadPdf($id)
  {
    $coupon = Coupon::findOrFail($id);

    $pdf = PDF::loadView('web.coupon-pdf', compact('coupon'));

    // Download as file
    return $pdf->download($coupon->title . '.pdf');
  }

  public function donation(Request $request)
  {
    //$faqs=Faq::where('status',1)->get();
    return view('web.donation');
  }
  public function otp(Request $request)
  {
    //$faqs=Faq::where('status',1)->get();
    return view('web.auth.otp');
  }


  public function incrementVideoWatch($id)
  {
    $medicine = Medicine::findOrFail($id);
    $medicine->increment('video_watch_count');
    return response()->json(['success' => true, 'count' => $medicine->video_watch_count]);
  }

  public function incrementPdfDownload($id)
  {
    $medicine = Medicine::findOrFail($id);
    $medicine->increment('pdf_download_count');
    return response()->json(['success' => true, 'count' => $medicine->pdf_download_count]);
  }

  public function profile(Request $request)
  {
    //   $forum = Forum::where(['status'=> 1])->orderBy('id', 'DESC')->first();
    //  $cdc = Cdc::where(['status'=> 1])->orderBy('id', 'DESC')->first();
    //  $faqs = Faq::where(['status'=> 1])->orderBy('id', 'DESC')->take(4)->get();

    return view('web.profile');
  }

  // public function trialSave(Request $request)
  // {
  //   // dd($request->all());
  //   $response = Http::withOptions(['verify' => false])->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
  //     'secret' => env('NOCAPTCHA_SECRET'),
  //     'response' => $request->input('g-recaptcha-response'),
  //     'remoteip' => $request->ip(),
  //   ]);

  //   $result = $response->json();

  //   if (!($result['success'] ?? false)) {
  //     return back()->withErrors(['g-recaptcha-response' => 'Captcha verification failed.'])->withInput();
  //   }
  //   $user = \Auth::user();
  //   if (empty($user) || $user->role_id != Role::USER) {
  //     session([
  //       'redirect_url' => route('clinical-trails'),
  //     ]);
  //     return redirect(route('login'));
  //   }
  //   session()->forget('redirect_url');

  //   $input = $request->except(['g-recaptcha-response', 'question1', 'question2','question3']);
  //   $input['user_id'] = $user->id;
  //    if (isset($input['pain_description']) && is_array($input['pain_description'])) {
  //       $input['pain_description'] = json_encode($input['pain_description']);
  //   }
  //   $clicnicalTrial = ClinicalTrial::create($input);
  //   return redirect()->back()->with('success', 'Your query is saved successfully.');
  // }


  public function trialSave(Request $request)
{
   if (!\Auth::check()) {
        return redirect()->back()->with('error', 'Please login to submit this form.');
    }
    //   dd($request->all());
    $validated = $request->validate([
        'condition' => 'required|string|max:255',
        'other_items' => 'required|string|max:255',
        'treatment' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        
        'allergy1' => 'nullable|string|max:255',
        'reaction1' => 'nullable|string|max:255',
        'allergy2' => 'nullable|string|max:255',
        'reaction2' => 'nullable|string|max:255',
        'allergy3' => 'nullable|string|max:255',
        'reaction3' => 'nullable|string|max:255',
        'allergy4' => 'nullable|string|max:255',
        'reaction4' => 'nullable|string|max:255',
        
       
        'medication1' => 'nullable|string|max:255',
        'dose1' => 'nullable|string|max:255',
        'medication2' => 'nullable|string|max:255',
        'dose2' => 'nullable|string|max:255',
        'medication3' => 'nullable|string|max:255',
        'dose3' => 'nullable|string|max:255',
        'medication4' => 'nullable|string|max:255',
        'dose4' => 'nullable|string|max:255',
        
     
        'mother_condition' => 'nullable|string|max:255',
        'mother_living' => 'nullable|boolean',
        'mother_deceased_age' => 'nullable|string|max:255',
        'father_condition' => 'nullable|string|max:255',
        'father_living' => 'nullable|boolean',
        'father_deceased_age' => 'nullable|string|max:255',
        'sibling_condition' => 'nullable|string|max:255',
        'sibling_living' => 'nullable|boolean',
        'sibling_deceased_age' => 'nullable|string|max:255',
        'other_condition' => 'nullable|string|max:255',
        'other_living' => 'nullable|boolean',
        'other_deceased_age' => 'nullable|string|max:255',
        
       
        'description1' => 'nullable|string|max:255',
        'doctor1' => 'nullable|string|max:255',
        'location1' => 'nullable|string|max:255',
        'year1' => 'nullable|string|max:255',
        'description2' => 'nullable|string|max:255',
        'doctor2' => 'nullable|string|max:255',
        'location2' => 'nullable|string|max:255',
        'year2' => 'nullable|string|max:255',
        'description3' => 'nullable|string|max:255',
        'doctor3' => 'nullable|string|max:255',
        'location3' => 'nullable|string|max:255',
        'year3' => 'nullable|string|max:255',
        'description4' => 'nullable|string|max:255',
        'doctor4' => 'nullable|string|max:255',
        'location4' => 'nullable|string|max:255',
        'year4' => 'nullable|string|max:255',
        
       
        'asthma' => 'nullable|boolean',
        'hypothyroidism' => 'nullable|boolean',
        'atrial_fibrillation' => 'nullable|boolean',
        'infection_problems' => 'nullable|boolean',
        'bleeding_problems' => 'nullable|boolean',
        'insomnia' => 'nullable|boolean',
        'benign_prostatic_hyperplasia' => 'nullable|boolean',
        'irritable_bowel_syndrome' => 'nullable|boolean',
        'coronary_artery_disease' => 'nullable|boolean',
        'kidney_problems' => 'nullable|boolean',
        'cancer' => 'nullable|boolean',
        'menopause' => 'nullable|boolean',
        'cardiac_arrest' => 'nullable|boolean',
        'migrainesheadaches' => 'nullable|boolean',
        'celiac_disease' => 'nullable|boolean',
        'neuropathy' => 'nullable|boolean',
        'chest_pain' => 'nullable|boolean',
        'onychomycosis' => 'nullable|boolean',
        'congestive_heart_failure' => 'nullable|boolean',
        'organ_injury' => 'nullable|boolean',
        'chronic_fatigue_syndrome' => 'nullable|boolean',
        'osteoporosis' => 'nullable|boolean',
        'depression' => 'nullable|boolean',
        'pulmonary_embolism' => 'nullable|boolean',
        'diabetes' => 'nullable|boolean',
        'seizure_disorders' => 'nullable|boolean',
        'drugalcohol_abuse' => 'nullable|boolean',
        'shortness_of_breath' => 'nullable|boolean',
        'erectile_dysfunction' => 'nullable|boolean',
        'sinus_conditions' => 'nullable|boolean',
        'fibromyalgia' => 'nullable|boolean',
        'stroke' => 'nullable|boolean',
        'gerd' => 'nullable|boolean',
        'syndrome_x' => 'nullable|boolean',
        'heart_disease' => 'nullable|boolean',
        'tremors' => 'nullable|boolean',
        'hyperinsulinemia' => 'nullable|boolean',
        'wheat_allergy' => 'nullable|boolean',
        'hyperlipidemia' => 'nullable|boolean',
        
       
        'medical_problem' => 'nullable|string',
        
        
        'health_concern' => 'nullable|string|max:255',
        'issue_begin' => 'nullable|string|max:255',
        'cause_pain' => 'nullable|boolean',
        'pain_position' => 'nullable|string|max:255',
        'pain_change_since_it_began' => 'nullable|string|in:increased,decreased,unchanged',
        'how_quickly_did_you_current_pain_begin' => 'nullable|string|in:gradually,suddenly',
        'how_often_does_your_pain_occur' => 'nullable|string|in:constantly,occasionally,rarely',
        'when_is_your_pain_at_its_worst' => 'nullable|string|in:morning,afternoon,evening,night',
        'current_symptomps' => 'nullable|string|max:255',
        'pain_description' => 'nullable|array',
        'pain_description.*' => 'string',
        'other_health_concern' => 'nullable|string',
        
      
        'consume_alcohol' => 'nullable|boolean',
        'drinks_per_week' => 'nullable|string|max:255',
        'smoke' => 'nullable|boolean',
        'smoke_type' => 'nullable|string|in:tobacco,marijuana,other',
        'smoke_per_day' => 'nullable|string|max:255',
        'take_other_drug' => 'nullable|boolean',
        'other_drug' => 'nullable|string|max:255',
        'how_often' => 'nullable|string|in:daily,weekly,occasionally,rarely',
        'caffeine' => 'nullable|boolean',
        'cups_per_day' => 'nullable|string|max:255',
        'sexually_active' => 'nullable|boolean',
        'STI' => 'nullable|boolean',
        'exercise' => 'nullable|string|in:daily,weekly,occasionally,rarely',
        'special_diet' => 'nullable|boolean',
        'diet' => 'nullable|string|max:255',
        
        
        'planning_pregnancy' => 'nullable|boolean',
        'pregnant_now' => 'nullable|boolean',
        'contraception' => 'nullable|string|max:255',
        'last_menstrual_cycle' => 'nullable|string|max:255',
        
        
        'question1' => 'required|accepted',
        'question2' => 'required|accepted',
        'question3' => 'required|accepted',
        
     
        'g-recaptcha-response' => 'required|captcha',
    ]);

   
    $data = $validated;
    
    
    if (isset($data['pain_description'])) {
        $data['pain_description'] = json_encode($data['pain_description']);
    }
    
   
    if (auth()->check()) {
        $data['user_id'] = auth()->id();
    }
    
   
    $booleanFields = [
        'mother_living', 'father_living', 'sibling_living', 'other_living',
        'asthma', 'hypothyroidism', 'atrial_fibrillation', 'infection_problems',
        'bleeding_problems', 'insomnia', 'benign_prostatic_hyperplasia',
        'irritable_bowel_syndrome', 'coronary_artery_disease', 'kidney_problems',
        'cancer', 'menopause', 'cardiac_arrest', 'migrainesheadaches',
        'celiac_disease', 'neuropathy', 'chest_pain', 'onychomycosis',
        'congestive_heart_failure', 'organ_injury', 'chronic_fatigue_syndrome',
        'osteoporosis', 'depression', 'pulmonary_embolism', 'diabetes',
        'seizure_disorders', 'drugalcohol_abuse', 'shortness_of_breath',
        'erectile_dysfunction', 'sinus_conditions', 'fibromyalgia', 'stroke',
        'gerd', 'syndrome_x', 'heart_disease', 'tremors', 'hyperinsulinemia',
        'wheat_allergy', 'hyperlipidemia', 'cause_pain', 'consume_alcohol',
        'smoke', 'take_other_drug', 'caffeine', 'sexually_active', 'STI',
        'special_diet', 'planning_pregnancy', 'pregnant_now'
    ];
    
    foreach ($booleanFields as $field) {
        if (isset($data[$field])) {
            $data[$field] = (bool) $data[$field];
        } else {
            $data[$field] = null; 
        }
    }
    
    
    unset($data['question1'], $data['question2'], $data['question3']);
    unset($data['g-recaptcha-response']);
    
    try {
        
        $clinicalTrial = ClinicalTrial::create($data);
        
        return redirect()->back()->with('success', 'Clinical trial registration submitted successfully!');
    } catch (\Exception $e) {
        \Log::error('Clinical Trial Save Error: ' . $e->getMessage());
        
        return redirect()->back()
            ->withInput()
            ->with('error',  $e->getMessage().'There was an error submitting your registration. Please try again.');
    }
}
  public function search(Request $request)
  {

    $letter = $request->input('query');

    $medicines = Medicine::where('status', 1)
      ->where(function ($query) use ($letter) {
        $query->where('name', 'ILIKE', "%{$letter}%");
      })
      ->paginate(20);
    // dd($medicines);
    return view('web.search', compact('medicines', 'letter'));
  }
  public function privacy(Request $request)
  {
    $page = Page::where('page_name', 'Privacy Policy')->first();
    return view('web.privacy', compact('page'));
  }

  public function terms(Request $request)
  {
    $page = Page::where('page_name', 'Terms of Use')->first();
    return view('web.terms', compact('page'));
  }
  
  public function changePasswordForm()
{
    return view('web.change-password');
}



public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => ['required'],
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
            //'regex:/^(?=.*[A-Z])(?=.*\d).+$/'
            'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*#?&])?[A-Za-z\d@$!%*#?&]+$/'
        ],
    ]);

    if (!\Hash::check($request->current_password, auth()->user()->password)) {
        return back()->withErrors([
            'current_password' => 'Current password is incorrect'
        ]);
    }

    auth()->user()->update([
        'password' => \Hash::make($request->password),
    ]);

    return back()->with('success', 'Password updated successfully');
}
}
