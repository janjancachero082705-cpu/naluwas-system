<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait ChurchScopeTrait
{
    protected function getCurrentChurchId()
    {
        // Session is always set by middleware
        $churchId = session('current_church_id');
        
        if (!$churchId && Auth::check()) {
            $churchId = Auth::user()->church_id;
        }
        
        return $churchId;
    }
}