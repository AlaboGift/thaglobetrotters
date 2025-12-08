<?php

namespace App\Traits;

use App\Enums\Status;
use Carbon\Carbon;

/**
 * This trait allows models to be filtered by startDate and endDate
 * @author Gift
 */
trait Filter
{
    public function scopeDateFilter($query)
    {
        if (request()->filled('startDate') && request()->filled('endDate')) {
            $startDate = Carbon::parse(request()->startDate)->toDateTimeString();
            $endDate = Carbon::parse(request()->endDate)->endOfDay()->toDateTimeString();
            return $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        return $query;
    }


    public function setActive()
    {
        if ($this->status == Status::DEACTIVATED) {
            $this->update(['status' => Status::ACTIVE]);
        } else {
            $this->update(['status' => Status::DEACTIVATED]);
        }
    }

    public function scopeStatusFilter($query)
    {
        if (request()->filled('status')) {
            return $query->where('status', request()->status);
        }

        return $query;
    }

    public function scopeCategoryFilter($query)
    {
        if (request()->filled('category')) {
            return $query->where('category', request()->category);
        }

        return $query;
    }

    public function scopeNameFilter($query)
    {
        if (request()->filled('search')) {
            $queryString = "%".request()->search."%";
            return $query->where('name', 'like', $queryString);
        }
        
        return $query;
    }

    public function scopeNameOrEmailFilter($query)
    {
        if (request()->filled('search')) {
            $queryString = "%".request()->search."%";
            return $query->where('name', 'like', $queryString)->orWhere('email', 'like', $queryString);
        }
        
        return $query;
    }

    public function scopeNameOrEmailOrMemberIdFilter($query)
    {
        if (request()->filled('search')) {
            $queryString = "%".request()->search."%";
            return $query->where('name', 'like', $queryString)
                        ->orWhere('member_id', 'like', $queryString)
                        ->orWhere('email', 'like', $queryString);
        }
        
        return $query;
    }
}
