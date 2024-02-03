<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobRequest;
use App\Http\Traits\ApiResponses;
use App\Services\CreateJobService;
use App\Services\Jobs\DeleteJobService;
use App\Services\Jobs\RetrieveJobService;

class JobController extends Controller
{
  use ApiResponses;

  public function create(CreateJobRequest $request)
  {
    $result = resolve(CreateJobService::class)->setRequest($request)->handle();

    return $this->successResponse([
      'id' => $result['id'],
    ], 'Create job successful!');
  }

  public function retrieve($id)
  {
    $result = resolve(RetrieveJobService::class)->setModel($id)->handle();
    
    if (!$result) {
      return $this->notFoundResponse('', 'Job not found!');
    }

    return $this->successResponse($result);
  }

  public function delete($id)
  {
    $result = resolve(DeleteJobService::class)->setModel($id)->handle();
    
    if (!$result) {
      return $this->notFoundResponse('', 'Job not found!');
    }

    return $this->successResponse('', 'Delete job successful');
  }
}
