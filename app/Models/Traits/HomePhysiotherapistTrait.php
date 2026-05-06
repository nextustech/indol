<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Patient;
use App\Models\Collection;
use App\Models\Expense;
use App\Models\Schedule;
use App\Models\Payment;

trait HomePhysiotherapistTrait
{
    public function isHomePhysiotherapist(): bool
    {
        return $this->roles->pluck('name')->first() === 'HomePhysiotherapist';
    }

    public function isAdmin(): bool
    {
        $adminRoles = ['Super-Admin', 'Admin', 'owner', 'DIRECTOR'];
        return $this->roles->pluck('name')->intersect($adminRoles)->isNotEmpty();
    }

    public function scopeHomePhysiotherapist(Builder $query): Builder
    {
        if ($this->isHomePhysiotherapist()) {
            return $query->where('user_id', $this->id);
        }
        return $query;
    }

    public function scopeOwnData(Builder $query, string $foreignKey = 'user_id'): Builder
    {
        if ($this->isHomePhysiotherapist()) {
            return $query->where($foreignKey, $this->id);
        }
        return $query;
    }

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class, 'created_by');
    }

    public function collections(): HasMany
    {
        return $this->hasMany(Collection::class, 'user_id');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'user_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'user_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Branch::class);
    }

    public function getOwnPatientsQuery(): Builder
    {
        if ($this->isHomePhysiotherapist()) {
            return Patient::where('created_by', $this->id);
        }
        return Patient::query();
    }

    public function getOwnCollectionsQuery(): Builder
    {
        if ($this->isHomePhysiotherapist()) {
            return Collection::where('user_id', $this->id);
        }
        return Collection::query();
    }

    public function getOwnExpensesQuery(): Builder
    {
        if ($this->isHomePhysiotherapist()) {
            return Expense::where('user_id', $this->id);
        }
        return Expense::query();
    }

    public function getOwnSchedulesQuery(): Builder
    {
        if ($this->isHomePhysiotherapist()) {
            return Schedule::where('user_id', $this->id);
        }
        return Schedule::query();
    }

    public function getOwnPaymentsQuery(): Builder
    {
        if ($this->isHomePhysiotherapist()) {
            return Payment::where('user_id', $this->id);
        }
        return Payment::query();
    }

    public function canAccessPatient(Patient $patient): bool
    {
        if ($this->isAdmin()) {
            return true;
        }
        
        if ($this->isHomePhysiotherapist()) {
            return $patient->created_by === $this->id;
        }
        
        return false;
    }

    public function canAccessCollection(Collection $collection): bool
    {
        if ($this->isAdmin()) {
            return true;
        }
        
        if ($this->isHomePhysiotherapist()) {
            return $collection->user_id === $this->id;
        }
        
        return false;
    }

    public function canAccessExpense(Expense $expense): bool
    {
        if ($this->isAdmin()) {
            return true;
        }
        
        if ($this->isHomePhysiotherapist()) {
            return $expense->user_id === $this->id;
        }
        
        return false;
    }

    public function canAccessSchedule(Schedule $schedule): bool
    {
        if ($this->isAdmin()) {
            return true;
        }
        
        if ($this->isHomePhysiotherapist()) {
            return $schedule->user_id === $this->id;
        }
        
        return false;
    }
}