<?php

namespace App\Services\Jobs;

use App\Core\BaseService;
use App\Enums\JobStatus;
use App\Models\Job;

class RetrieveJobService extends BaseService
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
      $job = $jobModel->getJob($this->model);
      
      if (!$job) {
        return null;
      }
  
      switch ($job['status']) {
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

      return [
        'id' => $job['id'],
        'scrap_info' => $job['scrap_info'],
        'scraped_data' => $job['scraped_data'],
        'status' => $status,
      ];
    }
}
