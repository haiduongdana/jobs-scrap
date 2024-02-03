<?php

namespace App\Services;

use App\Core\BaseService;
use App\Enums\JobStatus;
use App\Jobs\ScrapDataJob;
use App\Models\Job;

class CreateJobService extends BaseService
{
    protected $collectsData = true;

    public function __construct()
    {
        //
    }

    /**
     * Logic to handle the data
     */
    public function handle()
    {
      $jobModel = new Job();

      $createJob = $jobModel->addJob([
        'status' => JobStatus::PENDING->value,
        'scrap_info' => $this->data->get('scrap_info'),
        'scraped_data' => null,
      ]);
  
      ScrapDataJob::dispatch($createJob);

      return $createJob;
    }
}
