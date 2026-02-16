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

        // load first unanswered question
        $answers = SysUserType30OnboardQuestionsAnswers::firstOrCreate(
            ['PatientUserID' => $userId],
            ['QuestionCompletionStatus' => 0]
        );

        // find first unanswered question number
        $nextQuestion = $this->getNextQuestionNumber($answers);

        // load question from questions table
        $question = SysUserType30OnboardQuestions::find($nextQuestion);

        return view('modules.mod-10.01-counselling.patients.patients-onboarding', compact('question', 'nextQuestion'));
    }


    public function saveonboardingAnswers(Request $request)
    {
        $request->validate([
            'question_id' => 'required|integer',
            'answer_text' => 'required|string',
            'answer_option_number' => 'required|integer'
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
        $answers->$optCol  = $request->answer_option_number;
        $answers->save();

        // determine next question
        $nextQ = $this->getNextQuestionNumber($answers);

        // check if onboarding finished
        if ($nextQ > 39) {

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


    private function getNextQuestionNumber($answers)
    {
        for ($i = 1; $i <= 39; $i++) {
            $col = "Id{$i}_Answer_text";
            if (empty($answers->$col)) {
                return $i;
            }
        }
        return 40; // completed
    }
}
