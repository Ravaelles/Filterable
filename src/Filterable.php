<?php

namespace Ravaelles\Filterable;

use Illuminate\Support\Facades\Input;

/**
 * Attach this trait to any model and then use ->filter($filters) to be able to filter records easily.
 */
trait Filterable {

    /**
     * Returns only those records, which match all conditions in url GET params.
     * @param       $query
     * @param array $filters Example: [ 'db_field_name' => ['Label name' => ['0' => 'No', '1' => 'Yes']], ... ]
     */
    public function scopeFilterable($query, array $filters) {
        foreach ($filters as $fieldName => $foo) {
            if (Input::has($fieldName)) {
                $query = $query->where($fieldName, Input::get($fieldName));
            }
        }

        return $query;
    }

}
