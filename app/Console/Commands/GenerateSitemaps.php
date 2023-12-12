<?php

// app/Console/Commands/GenerateSitemap.php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemaps extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap for the website';

    public function handle()
    {
        try {
            $this->info('Start generating sitemap...');

            $urlToBeCrawled = config('app.url'); // Ganti dengan URL Anda
            $outputPath = public_path('sitemap.xml');

            $this->info('URL to be crawled: ' . $urlToBeCrawled);

            SitemapGenerator::create($urlToBeCrawled)
                ->writeToFile($outputPath);

            $this->info('Sitemap generated successfully.');
        } catch (\Exception $e) {
            // Log error messages
            $this->error('Error generating sitemap: ' . $e->getMessage());
        }
    }
}