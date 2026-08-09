<?php

namespace App\Http\Controllers\web;

use App\Models\Medicine;
use App\Models\PatientQuery;
use Illuminate\Http\Request;
use App\Traits\UploaderTrait;
use App\Mail\PatientQueryMail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class DrugController extends Controller
{
    use UploaderTrait;

    public function info(Request $request)
    {
        return view('web.drug.information');
    }

    public function index(Request $request, $letter)
    {

        $medicines = Medicine::where('name', 'ILIKE', "{$letter}%")->where('status', 1)->orderBy('name', 'asc')->paginate(10);
        //dd( $medicines);
        $letter = strtoupper($letter);
        return view('web.drug.index', compact('medicines', 'letter'));
    }
    public function show(Request $request, $letter, $slug)
    {
        $medicine = Medicine::where(['slug' => $slug, 'status' => 1])->firstOrFail();
        $letter = strtoupper($letter);

        return view('web.drug.show', compact('medicine', 'letter'));
    }

    public function askDoctor(Request $request, $slug)
    {

        $medicine = Medicine::where(['slug' => $slug, 'status' => 1])->firstOrFail();
        $user = \Auth::user();
        return view('web.ask-doctor.index', compact('medicine', 'user'));
    }

    // public function store(Request $request, $slug)
    // {
    //     // dd($request->all());
    //     try {
    //         $medicine = Medicine::where('slug', $slug)->firstOrFail();


    //         $patient = $request->only([
    //             'first_name',
    //             'last_name',
    //             'email',
    //             'mobile',
    //             'age_group',
    //             'gender',
    //             'address_1',
    //             'address_2',
    //             'city',
    //             'state',
    //             'zip',
    //             'existing_medical_condition',
    //             'current_medications',
    //             'known_allergies',
    //             'previous_surgeries',
    //         ]);

    //         $doctor = $request->only(['doctor_name', 'doctor_email']);


    //         $pdf = Pdf::loadView('web.pdf-format.patient_medicine', compact('patient', 'medicine'));


    //         $fileName = 'pdfs/' . $this->getUniqueId() . '.pdf';
    //         \Storage::disk('public')->put($fileName, $pdf->output());
    //         $filePath = storage_path('app/public/' . $fileName);


    //         $query = PatientQuery::create([
    //             'user_id' => \Auth::user()->id,
    //             'path' => $fileName,
    //             'doctor_name' => $request->doctor_name,
    //             'doctor_email' => $request->doctor_email,
    //         ]);


    //         \Mail::to($doctor['doctor_email'])->send(
    //             new PatientQueryMail($patient, $medicine, $filePath, $doctor['doctor_name'])
    //         );

    //         return back()->with('success', 'PDF generated and sent to doctor successfully!');
    //     } catch (\Exception $e) {

    //         \Log::error('Patient PDF generation failed: ' . $e->getMessage(), [
    //             'stack' => $e->getTraceAsString()
    //         ]);

    //         return back()->with('error',  $e->getMessage());
    //     }
    // }

    public function store(Request $request, $slug)
{
    try {
        $medicine = Medicine::where('slug', $slug)->firstOrFail();

         if (!\Auth::check()) {
        return redirect()->back()->with('error', 'Please login to submit this form.');
    }
        $patient = $request->only([
            'first_name',
            'last_name',
            'email',
            'mobile',
            'age_group',
            'gender',
            'address_1',
            'address_2',
            'city',
            'state',
            'zip',
            'existing_medical_condition',
            'current_medications',
            'known_allergies',
            'previous_surgeries',
        ]);

        $doctor = $request->only(['doctor_name', 'doctor_email']);

        // Generate PDF
        $pdf = Pdf::loadView('web.pdf-format.patient_medicine', compact('patient', 'medicine', 'request'));

        $fileName = 'pdfs/' . $this->getUniqueId() . '.pdf';
        \Storage::disk('public')->put($fileName, $pdf->output());
        $filePath = storage_path('app/public/' . $fileName);

        // Prepare complete data for database insertion
        $queryData = [
            'user_id' => \Auth::user()->id,
            'path' => $fileName,
            'doctor_name' => $request->doctor_name,
            'doctor_email' => $request->doctor_email,
            
            // Basic Info
            //'first_name' => $request->first_name,
           // 'last_name' => $request->last_name,
           // 'email' => $request->email,
           // 'mobile' => $request->mobile,
            //'age_group' => $request->age_group,
            //'gender' => $request->gender,
            //'address_1' => $request->address_1,
          //  'address_2' => $request->address_2,
          //  'city' => $request->city,
           // 'state' => $request->state,
           // 'zip' => $request->zip,
            //'existing_medical_condition' => $request->existing_medical_condition,
            //'current_medications' => $request->current_medications,
            //'known_allergies' => $request->known_allergies,
           // 'previous_surgeries' => $request->previous_surgeries,
            
         
            'allergy1' => $request->allergy1,
            'allergy2' => $request->allergy2,
            'allergy3' => $request->allergy3,
            'allergy4' => $request->allergy4,
            'reaction1' => $request->reaction1,
            'reaction2' => $request->reaction2,
            'reaction3' => $request->reaction3,
            'reaction4' => $request->reaction4,
            
         
            'medication1' => $request->medication1,
            'medication2' => $request->medication2,
            'medication3' => $request->medication3,
            'medication4' => $request->medication4,
            'dose1' => $request->dose1,
            'dose2' => $request->dose2,
            'dose3' => $request->dose3,
            'dose4' => $request->dose4,
            
        
            'mother_condition' => $request->mother_condition,
            'mother_living' => $request->mother_living,
            'mother_deceased_age' => $request->mother_deceased_age,
            'father_condition' => $request->father_condition,
            'father_living' => $request->father_living,
            'father_deceased_age' => $request->father_deceased_age,
            'sibling_condition' => $request->sibling_condition,
            'sibling_living' => $request->sibling_living,
            'sibling_deceased_age' => $request->sibling_deceased_age,
            'other_condition' => $request->other_condition,
            'other_living' => $request->other_living,
            'other_deceased_age' => $request->other_deceased_age,
            
            // Surgical History
            'description1' => $request->description1,
            'description2' => $request->description2,
            'description3' => $request->description3,
            'description4' => $request->description4,
            'doctor1' => $request->doctor1,
            'doctor2' => $request->doctor2,
            'doctor3' => $request->doctor3,
            'doctor4' => $request->doctor4,
            'location1' => $request->location1,
            'location2' => $request->location2,
            'location3' => $request->location3,
            'location4' => $request->location4,
            'year1' => $request->year1,
            'year2' => $request->year2,
            'year3' => $request->year3,
            'year4' => $request->year4,
            
            // Medical History Conditions
            'asthma' => $request->asthma,
            'hypothyroidism' => $request->hypothyroidism,
            'atrial_fibrillation' => $request->atrial_fibrillation,
            'infection_problems' => $request->infection_problems,
            'bleeding_problems' => $request->bleeding_problems,
            'insomnia' => $request->insomnia,
            'benign_prostatic_hyperplasia' => $request->benign_prostatic_hyperplasia,
            'irritable_bowel_syndrome' => $request->irritable_bowel_syndrome,
            'coronary_artery_disease' => $request->coronary_artery_disease,
            'kidney_problems' => $request->kidney_problems,
            'cancer' => $request->cancer,
            'menopause' => $request->menopause,
            'cardiac_arrest' => $request->cardiac_arrest,
            'migraines_headaches' => $request->migraines_headaches,
            'celiac_disease' => $request->celiac_disease,
            'neuropathy' => $request->neuropathy,
            'chest_pain' => $request->chest_pain,
            'onychomycosis' => $request->onychomycosis,
            'congestive_heart_failure' => $request->congestive_heart_failure,
            'organ_injury' => $request->organ_injury,
            'chronic_fatigue_syndrome' => $request->chronic_fatigue_syndrome,
            'osteoporosis' => $request->osteoporosis,
            'depression' => $request->depression,
            'pulmonary_embolism' => $request->pulmonary_embolism,
            'diabetes' => $request->diabetes,
            'seizure_disorders' => $request->seizure_disorders,
            'drug_alcohol_abuse' => $request->drug_alcohol_abuse,
            'shortness_of_breath' => $request->shortness_of_breath,
            'erectile_dysfunction' => $request->erectile_dysfunction,
            'sinus_conditions' => $request->sinus_conditions,
            'fibromyalgia' => $request->fibromyalgia,
            'stroke' => $request->stroke,
            'gerd' => $request->gerd,
            'syndrome_x' => $request->syndrome_x,
            'heart_disease' => $request->heart_disease,
            'tremors' => $request->tremors,
            'hyperinsulinemia' => $request->hyperinsulinemia,
            'wheat_allergy' => $request->wheat_allergy,
            'hyperlipidemia' => $request->hyperlipidemia,
          
            'medical_problem' => $request->medical_problem,
            
           
            'health_concern' => $request->health_concern,
            'issue_begin' => $request->issue_begin,
            'cause_pain' => $request->cause_pain,
            'pain_position' => $request->pain_position,
            'pain_change_since_it_began' => $request->pain_change_since_it_began,
            'how_quickly_did_you_current_pain_begin' => $request->how_quickly_did_you_current_pain_begin,
            'how_often_does_your_pain_occur' => $request->how_often_does_your_pain_occur,
            'when_is_your_pain_at_its_worst' => $request->when_is_your_pain_at_its_worst,
            'current_symptomps' => $request->current_symptomps,
            'pain_description' => $request->has('pain_description') ? json_encode($request->pain_description) : null,
            'other_health_concern' => $request->other_health_concern,
            
          
            'consume_alcohol' => $request->consume_alcohol,
            'drinks_per_week' => $request->drinks_per_week,
            'smoke' => $request->smoke,
            'smoke_type' => $request->smoke_type,
            'smoke_per_day' => $request->smoke_per_day,
            'take_other_drug' => $request->take_other_drug,
            'other_drug' => $request->other_drug,
            'how_often' => $request->how_often,
            'caffeine' => $request->caffeine,
            'cups_per_day' => $request->cups_per_day,
            'sexually_active' => $request->sexually_active,
            'STI' => $request->STI,
            'exercise' => $request->exercise,
            'special_diet' => $request->special_diet,
            'diet' => $request->diet,
           
            'planning_pregnancy' => $request->planning_pregnancy,
            'pregnant_now' => $request->pregnant_now,
            'contraception' => $request->contraception,
            'last_menstrual_cycle' => $request->last_menstrual_cycle,
        ];

        
        $query = PatientQuery::create($queryData);

        // Send email to doctor
       $mail= \Mail::to($doctor['doctor_email'])->send(
            new PatientQueryMail($patient, $medicine, $filePath, $doctor['doctor_name'])
        );

        return back()->with('success', 'PDF generated and sent to doctor successfully!');
    } catch (\Exception $e) {
        \Log::error('Patient PDF generation failed: ' . $e->getMessage(), [
            'stack' => $e->getTraceAsString()
        ]);

        return back()->with('error', $e->getMessage());
    }
}
}
