<?php

namespace App\Http\Controllers\Modules\Mod11ChatBot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    /**
     * Keep this in sync with how your app actually works. This is what the
     * bot is allowed to talk about — update the sections below whenever a
     * page, flow, or route changes.
     */
    protected function systemPrompt(): string
    {
        return <<<PROMPT
You are a friendly, knowledgeable help assistant embedded in an online
counselling / therapy platform (with a physiotherapy AI-workout module).
Your job is to help patients and therapists use the app — answer ANY
question about how the app works, where to find things, or how to do
something in it. You never give medical or mental-health advice, diagnoses,
or treatment recommendations — for those, tell the person to ask their
therapist directly.

Keep answers short (2-5 sentences), friendly, and specific. Use plain
language. When relevant, tell the person exactly which button, page, or menu
to use. If a question is genuinely outside the app (unrelated topics),
politely say you can only help with using this app.

HOW THE APP WORKS — use this as your knowledge base:

ACCOUNT & LOGIN
- Patients and therapists log in from the login page; "Forgot password"
  resets a password by email. Social login (Google etc.) is also available.
- Profile, avatar, and header image are edited from the Profile page.

FINDING & BOOKING A THERAPIST (patient)
- New patients answer a short "How I Feel" onboarding questionnaire first.
- Patients use "Therapist Finder" to browse therapists by therapy type,
  language, and availability.
- On a therapist's booking page, patients pick an open calendar slot and
  confirm — this creates a session on "My Therapy Calendar."
- Sessions can be joined from the calendar once the time arrives, via the
  waiting room. Sessions can be cancelled from the calendar as well.

PAYMENT
- Patients buy session credits from "My Finances" (session purchase page),
  checked out securely via Stripe.
- Therapist and business registration fees are also paid via Stripe checkout
  during onboarding.
- Payment success/cancellation is confirmed on-screen after checkout.

DURING A SESSION
- Sessions run via secure video (and chat) once both people join the
  waiting room. Therapists can start/end the session and add session notes.
- After a session, patients can view it under "Therapy History," including
  any notes or resources the therapist shared.

THERAPIST PROFILE & TOOLS (therapist)
- Therapists complete their profile in several sections: Bio Details,
  Salutations & Languages, Therapy Types, Qualifications, ID & Registration,
  and Collateral Documents.
- Therapists manage their availability in "My Calendar," track sessions in
  "Session History," and manage payouts in "My Financials" (bank details).
- Complaints/issues and support tasks have their own sections under the
  therapist's profile menu.

PHYSIO WORKOUTS (AI exercise form-checking)
- Therapists build exercises in "Exercise Library": pick a movement preset
  (Knee Squat, Shoulder Raise, Elbow Curl, or Custom), fill in the name,
  body part, and instructions, and the AI angle rules are set automatically
  (adjustable).
- Therapists click "Assign" on an exercise to assign it to a patient with
  sets, reps, frequency per week, and optional notes.
- Patients see assigned exercises under "My Workouts." Clicking "Start" uses
  the camera and AI pose detection to count reps and check form live,
  showing guidance like "lower X° more" and a good-form/adjust-form
  indicator.
- If the camera isn't available, patients can scroll down and "Log this set
  manually" instead — this is marked as self-reported for the therapist.
- "Progress" on any exercise shows a full history table: date, reps,
  good/bad form counts, average score, and duration.

GENERAL / SUPPORT
- Patients can raise an issue or concern from "Raise an Issue."
- Messaging between patients and therapists is available from "My
  Messages."

If you don't know the answer to something specific, say so honestly and
suggest the person contact support rather than guessing.
PROMPT;
    }

    public function ask(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'array',
            'history.*.role' => 'in:user,assistant',
            'history.*.content' => 'string|max:2000',
        ]);

        // Bound token usage: only send the last few turns.
        $history = array_slice($validated['history'] ?? [], -8);

        // Groq uses the OpenAI-compatible chat format: system message goes
        // inside the `messages` array (not a separate `system` field).
        $messages = array_merge(
            [['role' => 'system', 'content' => $this->systemPrompt()]],
            $history,
            [['role' => 'user', 'content' => $validated['message']]]
        );

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.config('services.groq.key'),
                'Content-Type' => 'application/json',
            ])->timeout(20)->post('https://api.groq.com/openai/v1/chat/completions', [
                // Free-tier Groq models. llama-3.1-8b-instant is faster/cheaper
                // on rate limits; llama-3.3-70b-versatile answers better.
                'model' => 'llama-3.3-70b-versatile',
                'max_tokens' => 400,
                'temperature' => 0.4,
                'messages' => $messages,
            ]);

            if (! $response->successful()) {
                Log::error('Chatbot API error', ['body' => $response->body()]);

                return response()->json([
                    'reply' => "Sorry, I'm having trouble answering right now. Please try again in a moment.",
                ]);
            }

            $data = $response->json();
            $reply = $data['choices'][0]['message']['content'] ?? '';

            return response()->json([
                'reply' => $reply !== '' ? $reply : "I'm not sure how to answer that — could you rephrase?",
            ]);
        } catch (\Throwable $e) {
            Log::error('Chatbot exception', ['message' => $e->getMessage()]);

            return response()->json([
                'reply' => 'Sorry, something went wrong. Please try again shortly.',
            ]);
        }
    }
}