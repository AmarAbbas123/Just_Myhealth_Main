<?php

namespace App\Http\Controllers\Modules\Mod01SystemAdministration\FAQ;

use App\Http\Controllers\Controller;
use App\Models\FAQ;

class PublicFAQController extends Controller
{
    // GET /mod-ps/general/faq
    public function index()
    {
        $faqs = FAQ::active()->ordered()->get();

        return view('modules.mod-ps.general.faq', compact('faqs'));
    }
}