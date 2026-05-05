<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Patients;

use App\Http\Controllers\Controller;
use App\Models\SysUserType30OnboardQuestions;
use App\Models\SysUserType30OnboardQuestionsAnswers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PatientsOnboardingController extends Controller
{
    public function showonboardingquestions()
    {
        $userId = auth()->id();

        $answers = SysUserType30OnboardQuestionsAnswers::firstOrCreate(
            ['PatientUserID' => $userId],
            ['QuestionCompletionStatus' => 0]
        );

        $totalQuestions = 40;

        if ($answers->QuestionCompletionStatus == 1) {
            $questions = SysUserType30OnboardQuestions::where('QuestionStatus', 1)
                ->whereBetween('ID', [1, $totalQuestions])
                ->orderBy('ID')
                ->get();

            return view('modules.mod-10.01-counselling.patients.patients-onboarding', [
                'mode' => 'summary',
                'questions' => $questions,
                'answers' => $answers,
                'totalQuestions' => $totalQuestions,
            ]);
        }

        $nextQuestion = $this->getNextQuestionNumber($answers);

        if ($nextQuestion > $totalQuestions) {
            $answers->QuestionCompletionStatus = 1;
            $answers->save();

            $questions = SysUserType30OnboardQuestions::where('QuestionStatus', 1)
                ->whereBetween('ID', [1, $totalQuestions])
                ->orderBy('ID')
                ->get();

            return view('modules.mod-10.01-counselling.patients.patients-onboarding', [
                'mode' => 'summary',
                'questions' => $questions,
                'answers' => $answers,
                'totalQuestions' => $totalQuestions,
            ]);
        }

        $question = SysUserType30OnboardQuestions::find($nextQuestion);

        return view('modules.mod-10.01-counselling.patients.patients-onboarding', [
            'mode' => 'wizard',
            'question' => $question,
            'nextQuestion' => $nextQuestion,
            'totalQuestions' => $totalQuestions,
        ]);
    }


    public function saveonboardingAnswers(Request $request)
    {
        $request->validate([
            'question_id' => 'required|integer',
            'answer_text' => 'required|string|max:2028',
            'answer_option_number' => 'nullable|integer',
        ]);

        $userId = auth()->id();

        $answers = SysUserType30OnboardQuestionsAnswers::firstOrCreate(
            ['PatientUserID' => $userId]
        );

        $qid = $request->question_id;

        // dynamic column names
        $textCol = "Id{$qid}_Answer_text";
        $optCol  = "Id{$qid}_AnswerOptionNumber";

        $answers->$textCol = $request->answer_text;
        $answers->$optCol  = $request->input('answer_option_number', 0);
        $answers->save();

        // determine next question
        $nextQ = $this->getNextQuestionNumber($answers);

        // check if onboarding finished
        if ($nextQ > 40) {

            // generate SessionZegoCloudConnectID only once
            if (empty($answers->SessionZegoCloudConnectID)) {
                $answers->SessionZegoCloudConnectID = strtoupper(
                    Str::random(9)
                );
            }

            $answers->QuestionCompletionStatus = 1;
            $answers->save();

            return response()->json([
                'completed' => true
            ]);
        }

        // load next question
        $question = SysUserType30OnboardQuestions::find($nextQ);

        return response()->json(['completed' => false, 'next_question' => $question, 'next_question_number' => $nextQ])
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    public function updateonboardingAnswer(Request $request)
    {
        $request->validate([
            'question_id' => 'required|integer|min:1|max:40',
            'answer_text' => 'required|string|max:2028',
            'answer_option_number' => 'nullable|integer',
        ]);

        $userId = auth()->id();

        $answers = SysUserType30OnboardQuestionsAnswers::where('PatientUserID', $userId)->firstOrFail();

        $qid = (int) $request->question_id;

        $textCol = "Id{$qid}_Answer_text";
        $optCol  = "Id{$qid}_AnswerOptionNumber";

        $answers->$textCol = $request->answer_text;
        $answers->$optCol  = $request->input('answer_option_number', 0);
        $answers->save();

        return response()->json([
            'success' => true,
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }


    private function getNextQuestionNumber($answers)
    {
        for ($i = 1; $i <= 40; $i++) {
            $col = "Id{$i}_Answer_text";
            if (empty($answers->$col)) {
                return $i;
            }
        }
        return 41; // completed
    }
}
