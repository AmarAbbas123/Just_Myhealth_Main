{{--
    Anti-bot fields partial. Include this inside any <form> tag you want
    to protect (registration forms for Client / Therapist / Business), just
    before the closing </form> tag or submit button.

    Usage:
        @include('partials.anti-bot-fields')

    Pairs with:
        - App\Rules\Recaptcha        (validates the g-recaptcha-response field)
        - App\Traits\ProtectsAgainstBots  (validates honeypot + timing fields)
--}}

{{-- Honeypot field: real users never see this (visually hidden off-screen,
     not display:none — some bots skip display:none fields specifically).
     Any bot that blindly fills every input will fill this in, and the
     controller rejects the request when it's non-empty. --}}
<div style="position:absolute; left:-9999px; top:-9999px;" aria-hidden="true">
    <label for="website">Website</label>
    <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
</div>

{{-- Records when the form was rendered, so the controller can reject
     submissions that happen implausibly fast (bots) --}}
<input type="hidden" name="form_loaded_at" value="{{ time() }}">

{{-- Google reCAPTCHA v2 checkbox widget --}}
<div class="g-recaptcha mt-3" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
@error('g-recaptcha-response')
    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
@enderror

@once
    @push('scripts')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endpush
@endonce
