<?php

namespace App\Http\Controllers;

use App\Models\Person as Model;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class PersonController extends BaseController
{
    protected $model;
    protected $table = 'people';
    protected $class = 'PersonController';
    protected $responseName = 'Person';

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
            'name' => 'required|string|max:45',
            'email' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'identification' => 'required|string|max:45',
            'phone' => 'required|string|max:13',

        ]);
    }
}
