<?php

namespace App\Http\Controllers;

use App\Enums\JobStatus;
use App\Http\Requests\CreateJobRequest;
use App\Http\Traits\ApiResponses;
use App\Jobs\ScrapData;
use App\Models\ScrapJob;
use App\Services\CreateJobService;

class JobController extends Controller
{
  use ApiResponses;

  protected $createJobService;
  public function __construct(CreateJobService $createJobService) 
  {
    $this->createJobService = $createJobService;
  }

  public function create(CreateJobRequest $request)
  {
    $job = ScrapJob::create([
      'scrap_info' => json_encode($request->get('scrap_info')),
      'status' => JobStatus::PENDING->value,
    ]);
    $jobData = $request->get('scrap_info');
    $scrapData = $this->createJobService->scrapeDataFromUrl_Url_SelectorArray($jobData['url'], $jobData['selector']);

    ScrapJob::updated([
      'scrap_data' => $scrapData,
    ]);
    return $this->successResponse('', 'Create job successful!');
  }

  public function retrieve($id)
  {
    $job = ScrapJob::find($id);
    
    if (!$job) {
      return $this->notFoundResponse('', 'Job not found!');
    }

    switch ($job->status) {
      case JobStatus::PENDING->value:
        $status = 'Pending';
        break;
      case JobStatus::COMPLETED->value:
        $status = 'Completed';
        break;
      case JobStatus::FAILED->value:
        $status = 'Failed';
        break;
    }

    return $this->successResponse([
      'scraped_data' => json_decode($job->scraped_data, true),
      'status' => $status,
    ]);
  }

  public function delete($id)
  {
    $job = ScrapJob::find($id);
    
    if (!$job) {
      return $this->notFoundResponse('', 'Job not found!');
    }

    $job->delete();

    return $this->successResponse('', 'Delete job successful');
  }
}
