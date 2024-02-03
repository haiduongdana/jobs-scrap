<?php

namespace App\Jobs;

use App\Enums\JobStatus;
use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Throwable;

class ScrapDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $scrapJob;
    /**
     * Create a new job instance.
     */
    public function __construct($scrapJob)
    {
        $this->scrapJob = $scrapJob;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $jobModel = new Job();
        $scrapedData = [];

        $jobModel->updateJob([
            'status' => JobStatus::PROCESSING->value,
            'scrap_info' => $this->scrapJob['scrap_info'],
            'scraped_data' => null,
        ], $this->scrapJob['id']);

        foreach ($this->scrapJob['scrap_info'] as $info) {
            $scrapedData[$info['url']] = $this->scrapeDataFromUrlWithSelector($info['url'], $info['selector']);
        }

        $jobModel->updateJob([
            'status' => JobStatus::COMPLETED->value,
            'scrap_info' => $this->scrapJob['scrap_info'],
            'scraped_data' => $scrapedData,
        ], $this->scrapJob['id']);
    }

    public function failed(Throwable $exception): void
    {
        $jobModel = new Job();

        $jobModel->updateJob([
            'status' => JobStatus::FAILED->value,
            'scrap_info' => $this->scrapJob['scrap_info'],
            'scraped_data' => null,
        ], $this->scrapJob['id']);
    }

    private function scrapeDataFromUrl($url) {
        $client = new Client();
        $response = $client->get($url);
        $content = $response->getBody()->getContents();
    
        return $content;
    }

    private function scrapeDataFromUrlWithSelector($url, $selector) {
        $client = new Client();
        $response = $client->get($url);
        $content = $response->getBody()->getContents();

        $crawler = new Crawler($content);
        $data = $crawler->filter($selector)->text();
    
        return $data;
    }
    
    private function scrapeDataFromUrlWithSelectors($url, array $selectors) {
        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);
        $content = $response->getBody()->getContents();
    
        $crawler = new Crawler($content);
    
        $result = [];
        
        foreach ($selectors as $selector) {
            $data = $crawler->filter($selector)->text();
            $result[] = $data;
        }
    
        return $result;
    }
}
