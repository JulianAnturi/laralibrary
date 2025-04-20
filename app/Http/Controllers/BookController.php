<?php

namespace App\Http\Controllers;

use App\Models\Book as Model;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

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
        return $this->antIndex($request);
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
        return $this->antDestroy($id);
    }

    private function validateForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'isbn' => 'required|string|max:20',
            'url' => 'required|string',
            'state' => 'nullable|string',
            'qantity' => 'required|integer',
            'price' => 'required|integer',
            'sypnosis' => 'nullable|string',

        ]);
    }
}
