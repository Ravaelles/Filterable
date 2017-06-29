<?php

namespace Ravaelles\Filterable;

use Illuminate\Support\Facades\Input;

/**
 * Attach this trait to any model and then use ->filter($filters) to be able to 
 * filter records easily.<br />
 * You can also use ->searchable() to use the search field. Remember to define
 * public $searchable array of fields to search against.
 */
trait Filterable {

    /**
     * Returns only those records, which match all conditions in url GET params.
     * @param       $query
     * @param array $filters Example: [ 'db_field_name' => ['Label name' => ['0' => 'No', '1' => 'Yes']], ... ]
     */
    public function scopeFilterable($query, array $filters) {
        foreach ($filters as $fieldName => $foo) {

            // Convert field name to always be what the filters says, not the field name.
            // If we don't do this, we might miss some filters.
            $paramNameInGET = $filters[$fieldName];
            $paramNameInGET = strtolower(array_keys($paramNameInGET)[0]);
            $filterValue = Input::get($paramNameInGET);

            if (strlen($filterValue) > 0) {

                // Handle multiple params using OR statement
                if (str_contains($filterValue, ",and,")) {
                    $filterValues = explode(",and,", $filterValue);
                    $query = $query->where(function($query) use ($fieldName, $filterValues) {
                        foreach ($filterValues as $filterValue) {
                            $query->orWhere($fieldName, $filterValue);
                        }
                    });
                }

                // GET param is single value
                else {
                    $query = $query->where($fieldName, $filterValue);
                }
            }
        }

        return $query;
    }

    /**
     * Returns only those records, which have search value from 'searching' GET parameter.
     * Use the public $searchable to indicate fields list to search against.
     */
    public function scopeSearchable($query, $searchValue = -1)
    {

        // Validate
        $searchableFields = $this->searchable;
        if (!$searchableFields) {
            abort(500, "No searchable fields for " . $this->getTable() . ". "
                . "Please declare public \$searchable = [] var in the model.");
        }

        // === Define search value =================================================

        if ($searchValue === -1) {
            $searchValue = trim(\Illuminate\Support\Facades\Request::get('searching'));
        }

        // =========================================================================

        if (strlen($searchValue) > 0) {
            $searchableFields = $this->searchable;

            if (is_array($searchableFields)) {
                $query = $query->where(function($query) use ($searchValue, $searchableFields) {
                    foreach ($searchableFields as $fieldName) {
                        $query->orWhere($fieldName, 'regex', "/$searchValue/i");
                    }
                });
            }
        }

        return $query;
    }

}
