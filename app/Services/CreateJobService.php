<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class CreateJobService
{
  private $urls;
  private $selectors;
  public function __construct($urls, $selectors = null)
  {
    $this->urls = $urls;
    $this->selectors = $selectors;
  }

  public function scrapeDataFromUrl_onlyUrl($url)
  {
    $client = new Client();
    $response = $client->get($url);
    $content = $response->getBody()->getContents();
    return $content;
  }

  public function scrapeDataFromUrlWithSelector($url, $selector)
  {
    $client = new Client();
    $response = $client->get($url);
    $content = $response->getBody()->getContents();

    $crawler = new Crawler($content);
    $data = $crawler->filter($selector)->text();

    return $data;
  }

  public function scrapeDataFromUrl_Url_SelectorArray($url, array $cases)
  {
    $client = new Client();
    $response = $client->get($url);
    $content = $response->getBody()->getContents();

    $crawler = new Crawler($content);

    $result = [];

    foreach ($cases as $key => $case) {
      $selector = $case['selector'];
      $multiple = $case['multiple'] ?? false;
      if ($multiple) {
        $result[$key] = $crawler->filter($selector)->each(function (Crawler $node) {
          return $node->text();
        });
      } else {
        $result[$key] = $crawler->filter($selector)->first()->text();
      }
    }

    return $result;
  }
}
