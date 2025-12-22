<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class DataTableHelpers
{
    public static function build(Request $request, $query, $columns = [])
    {
        $draw = $request->get('draw');
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $searchValue = $request->input('search.value');

        $totalRecords = $query->count();

        if ($searchValue) {
            $query->where(function ($q) use ($columns, $searchValue) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', '%' . $searchValue . '%');
                }
            });
        }

        $filteredRecords = $query->count();

        $data = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }
}
