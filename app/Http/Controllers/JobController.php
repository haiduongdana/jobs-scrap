<?php

namespace App\Http\Controllers;

use App\Enums\JobStatus;
use App\Http\Requests\CreateJobRequest;
use App\Http\Traits\ApiResponses;
use App\Jobs\ScrapData;
use App\Models\ScrapJob;

class JobController extends Controller
{
  use ApiResponses;
  
  public function create(CreateJobRequest $request)
  {
    $job = ScrapJob::create([
      'scrap_info' => json_encode($request->get('scrap_info')),
      'status' => JobStatus::PENDING->value,
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
