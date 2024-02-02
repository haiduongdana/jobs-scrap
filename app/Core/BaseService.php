<?php

namespace App\Core;

use App\Traits\HasAlertAfterAction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

abstract class BaseService
{
    use HasAlertAfterAction;

    /**
     * @var boolean
     */
    protected $collectsData = false;

    /**
     * @var \Ecs\L8Core\Contracts\RepositoryInterface
     */
    protected $repository;

    /**
     * @var \Illuminate\Database\Eloquent\Model|int
     */
    protected $model;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $handler;

    /**
     * Set the data
     *
     * @param mixed $data
     * @return self
     */
    public function setData($data)
    {
        $this->data = ($data instanceof Collection || ! $this->collectsData) ? $data : new Collection($data);

        return $this;
    }

    /**
     * Set the handler
     *
     * @param \Illuminate\Database\Eloquent\Model $handler
     * @return self
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Set the handler
     *
     * @param \Illuminate\Database\Eloquent\Model|int $model
     * @return self
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Set the request to service
     *
     * @param FormRequest $request
     * @return self
     */
    public function setRequest(FormRequest $request)
    {
        $this->setHandler($request->user());
        $this->setData($request->validated());

        return $this;
    }

    abstract public function handle();

    /**
     * Get default pagination limit
     *
     * @return integer
     */
    protected function getPerPage()
    {
        return $this->data['per_page'] ?? 15;
    }

    /**
     * Initialize all the bootable traits on the model.
     *
     * @return void
     */
    protected function initializeTraits()
    {
        $class = static::class;

        foreach (\class_uses_recursive($class) as $trait) {
            if (method_exists($class, $method = 'initialize'.class_basename($trait))) {
                $this->$method();
            }
        }
    }
}
