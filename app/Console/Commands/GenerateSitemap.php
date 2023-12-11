<?php

// app/Console/Commands/GenerateSitemap.php

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap for the website';

    public function handle()
    {
        SitemapGenerator::create(config('https://crxanode.com/'))->writeToFile(public_path('sitemap.xml'));
        $this->info('Sitemap generated successfully.');
    }
}
