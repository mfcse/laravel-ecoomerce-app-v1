<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function setSuccess($message): void
    {
        session()->flash('message', $message);
        session()->flash('type', 'success');
    }
    protected function setError($message): void
    {
        session()->flash('message', $message);
        session()->flash('type', 'warning');
    }
    protected function setDanger($message): void
    {
        session()->flash('message', $message);
        session()->flash('type', 'danger');
    }
}