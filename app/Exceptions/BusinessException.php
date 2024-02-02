<?php

namespace App\Exceptions;

use App\Core\BaseException;

class BusinessException extends BaseException
{
    protected $errorField = null;

    /**
     * Set error field
     *
     * @param string $field
     * @return self
     */
    public function setErrorField(string $field)
    {
        $this->errorField = $field;

        return $this;
    }

    /**
     * Get error field
     *
     * @return string|null
     */
    public function getErrorField()
    {
        return $this->errorField;
    }
}
