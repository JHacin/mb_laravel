<?php

namespace App\Http\Controllers\Admin\Traits;

trait ClearsModelGlobalScopes
{
    /**
     * @return void
     */
    public function clearModelGlobalScopes()
    {
        $this->crud->query = $this->crud->query->withoutGlobalScopes();
        $this->crud->model->clearGlobalScopes();
    }
}
