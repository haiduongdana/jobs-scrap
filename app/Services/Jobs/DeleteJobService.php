<?php

namespace App\Services\Jobs;

use App\Core\BaseService;
use App\Models\Job;

class DeleteJobService extends BaseService
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

      $jobModel->deleteJob($this->model);

      return true;
    }
}
