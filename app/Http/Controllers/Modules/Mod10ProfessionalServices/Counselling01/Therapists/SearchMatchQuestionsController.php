<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use App\Models\SysUserType30TherapistOnboardQuestions;
use App\Models\SysUserType30TherapistOnboardQuestionsAnswers;
use Illuminate\Http\Request;

class SearchMatchQuestionsController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $answers = SysUserType30TherapistOnboardQuestionsAnswers::firstOrCreate(
            ['TherapistUserID' => $userId],
            ['QuestionCompletionStatus' => 0]
        );

        $totalQuestions = SysUserType30TherapistOnboardQuestions::where('QuestionStatus', 1)->count();

        if ($answers->QuestionCompletionStatus == 1) {
            $questions = SysUserType30TherapistOnboardQuestions::where('QuestionStatus', 1)
                ->orderBy('ID')
                ->get();

            return view('modules.mod-10.01-counselling.therapists.search-match-questions', [
                'mode' => 'summary',
                'questions' => $questions,
                'answers' => $answers,
                'totalQuestions' => $totalQuestions,
            ]);
        }

        $nextQuestionNumber = $this->getNextQuestionNumber($answers, $totalQuestions);

        $question = SysUserType30TherapistOnboardQuestions::find($nextQuestionNumber);

        return view('modules.mod-10.01-counselling.therapists.search-match-questions', [
            'mode' => 'wizard',
            'question' => $question,
            'nextQuestion' => $nextQuestionNumber,
            'totalQuestions' => $totalQuestions,
        ]);
    }

    public function saveAnswer(Request $request)
    {
        $request->validate([
            'question_id' => 'required|integer',
            'answer_text' => 'required|string',
            'answer_option_number' => 'required|integer',
        ]);

        $userId = auth()->id();

        $answers = SysUserType30TherapistOnboardQuestionsAnswers::firstOrCreate(
            ['TherapistUserID' => $userId],
            ['QuestionCompletionStatus' => 0]
        );

        $qid = $request->question_id;

        $textCol = "Id{$qid}_Answer_text";
        $optCol  = "Id{$qid}_AnswerOptionNumber";

        $answers->$textCol = $request->answer_text;
        $answers->$optCol  = $request->answer_option_number;
        $answers->save();

        $totalQuestions = SysUserType30TherapistOnboardQuestions::where('QuestionStatus', 1)->count();

        $nextQ = $this->getNextQuestionNumber($answers, $totalQuestions);

        if ($nextQ > $totalQuestions) {
            $answers->QuestionCompletionStatus = 1;
            $answers->save();

            return response()->json([
                'completed' => true,
            ]);
        }

        $question = SysUserType30TherapistOnboardQuestions::find($nextQ);

        return response()->json([
            'completed' => false,
            'next_question' => $question,
            'next_question_number' => $nextQ,
            'total_questions' => $totalQuestions,
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    public function updateAnswer(Request $request)
    {
        $request->validate([
            'question_id' => 'required|integer',
            'answer_text' => 'required|string',
            'answer_option_number' => 'required|integer',
        ]);

        $userId = auth()->id();

        $answers = SysUserType30TherapistOnboardQuestionsAnswers::where('TherapistUserID', $userId)->firstOrFail();

        $qid = $request->question_id;

        $textCol = "Id{$qid}_Answer_text";
        $optCol  = "Id{$qid}_AnswerOptionNumber";

        $answers->$textCol = $request->answer_text;
        $answers->$optCol  = $request->answer_option_number;
        $answers->save();

        return response()->json([
            'success' => true,
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    private function getNextQuestionNumber(SysUserType30TherapistOnboardQuestionsAnswers $answers, int $totalQuestions): int
    {
        for ($i = 1; $i <= $totalQuestions; $i++) {
            $col = "Id{$i}_Answer_text";
            if (empty($answers->$col)) {
                return $i;
            }
        }

        return $totalQuestions + 1;
    }
}