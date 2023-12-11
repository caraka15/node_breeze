<?php

namespace App\Http\Controllers;

use Spatie\Sitemap\SitemapGenerator;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
    // SitemapController.php
    public function generate()
    {

        $urlToBeCrawled = "https://crxanode.com/";

        SitemapGenerator::create($urlToBeCrawled)->writeToFile(public_path('sitemap.xml'));
        return response()->json(['message' => 'Sitemap generated successfully.']);
    }
}
