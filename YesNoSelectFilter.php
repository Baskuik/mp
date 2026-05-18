<?php

namespace App\Filament\Tables\Filters;

use App\Enums\YesNo;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;

class YesNoFilter extends TernaryFilter
{
    protected function setUp(): void
    {
        parent::setUp();

        // Zorg dat de placeholder vertaalbaar is
        $this->placeholder(__('Alle'));

        $this->queries(
            true: function (Builder $query): Builder {
                if ($this->queriesRelationships()) {
                    return $query->whereHas($this->getRelationshipName(), function (Builder $query) {
                        $query->where($this->getRelationshipTitleAttribute(), YesNo::JA);
                    });
                }
                
                return $query->where($this->getAttribute(), YesNo::JA);
            },
            false: function (Builder $query): Builder {
                if ($this->queriesRelationships()) {
                    return $query->whereHas($this->getRelationshipName(), function (Builder $query) {
                        $query->where($this->getRelationshipTitleAttribute(), YesNo::NEE);
                    });
                }

                return $query->where($this->getAttribute(), YesNo::NEE);
            },
            blank: function (Builder $query): Builder {
                return $query;
            }, // <-- Komma en juiste syntax
        ); // <-- Puntkomma toegevoegd
    }
}