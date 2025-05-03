<?php

namespace App\Http\Controllers;

use App\Models\Book as Model;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Exceptions\ModelNotFoundCustomException;
use Anturi\Larastarted\Helpers\ResponseService;
use App\Services\CrudService;

class BookController extends BaseController
{
    protected $model;
    protected $table = 'books';
    protected $class = 'BookController';
    protected $responseName = 'Book';

    public function __construct(Model $model)
    {
        parent::__construct($model, $this->class, $this->responseName, $this->table);
    }

    public function index(Request $request)
    {
        $prefix = strtolower($request->input('prefix'));
        $field = $request->input('field');

        $items = Model::where('state', '<>', 2);

        if ($prefix && $field) {
            $trie = new \App\Services\TrieService();

            foreach ($items->get() as $item) {
                $value = strtolower($item->$field);
                $words = preg_split('/\s+/', $value);

                foreach ($words as $word) {
                    $trie->insert($field, $word, $item);
                }
            }

            $filtered = $trie->search($field, $prefix);
            $filtered = collect($filtered)->unique('id')->values();

            return ResponseService::responseGet($filtered);
        }
        $data = $items->paginate($request->input('limit', 20));
        return ResponseService::responseGet($data);
    }

    public function store(Request $request)
    {
        $this->validateForm($request);
        $data = $request->all();
        return $this->antStore($data);
    }

    public function show($id)
    {
        return $this->antShow($id, $this->model);
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);
        $data = $request->all();
        return $this->antUpdate($data, $id);
    }

    public function destroy($id)
    {

        $book = Model::find($id);
        if (!$book)
            throw new ModelNotFoundCustomException('book');

        if ($book->lended > 0)
            $res = ResponseService::responseErrorUser('este libro no puede ser eliminado, porque alguien tiene un ejemplar');

        $res = ResponseService::responseDelete('libro');
        $book->state = 2;
        $book->save();

        return $res;
    }

    private function validateForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'isbn' => 'required|string|max:20',
            'url' => 'required|string',
            'state' => 'nullable|integer',
            'quantity' => 'required|integer',
            'price' => 'required|integer',
            'sypnosis' => 'nullable|string',

        ]);
    }
}
