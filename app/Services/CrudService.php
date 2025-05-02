<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Anturi\Larastarted\Helpers\ResponseService;

class CrudService extends ResponseService
{

    public static function index($model, $request)
    {
        $prefix = strtolower($request->input('prefix'));
        $field = $request->input('field');

        if ($prefix && $field) {
            $trie = new \App\Services\TrieService();

            $items = $model::all();

            foreach ($items as $item) {
                $value = strtolower($item->$field);
                $words = preg_split('/\s+/', $value);

                foreach ($words as $word) {
                    $trie->insert($field, $word, $item);
                }
            }

            $filtered = $trie->search($field, $prefix);
            $filtered = collect($filtered)->unique('id')->values();
            return $filtered;

            return ResponseService::responseGet($filtered);
        }

        $data = $model::paginate($request->input('limit', 20));
        return ResponseService::responseGet($data);
    }

    public static function store($model, $request, $name)
    {
        $data = $model::create($request);
        return ResponseService::responseCreate($name, $data);
    }

    public static function update($id, $table, $data, $responseName)
    {

        $query = DB::table($table)->where('id', $id);
        $query->update($data);
        $result = $query->first();
        return ResponseService::responseUpdate($responseName, $result);
    }

    public static function destroy($id, $model, $responseName)
    {
        $model->destroy($id);
        return ResponseService::responseDelete($responseName);
    }

    public static function show($id, $model)
    {
        $data = $model->findOrFail($id);
        return ResponseService::responseGet($data);
    }
}
