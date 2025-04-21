<?php

namespace App\Http\Controllers;

use App\Models\Lend as Model;
use Illuminate\Http\Request;
use Anturi\Larastarted\Controllers\BaseController;
use Anturi\Larastarted\Helpers\ResponseService;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreLendRequest;
use function PHPUnit\Framework\isEmpty;

class LendController extends BaseController
{
    protected $model;
    protected $table = 'lends';
    protected $class = 'LendController';
    protected $responseName = 'prestamo';

    public function __construct(Model $model)
    {
        parent::__construct($model, $this->class, $this->responseName, $this->table);
    }

    public function index(Request $request)
    {
        return $this->antIndex($request);
    }
    // Function to borrow a abook
    public function store(StoreLendRequest $request)
    // public function store(Request $request)
    {
        // $this->validateForm($request);
        $request->validated();
        // $book = $request->book();
        // return $book;
        // $bookId = request('book_id');
        // $book = Book::find($bookId);
        // return $book;
        // $book->quantity = 10;
        // $book->lended = 1;
        // $book->save();
        // $quantity = $book->quantity;
        // $lended = $book->lended;
        // if ($quantity <= $lended)
        //     return ResponseService::responseErrorUser('No hay libros disponibles, selecciona otro libro');
        // $lended + 1;
        // $book->lended = $lended;
        // $book->save();
        $data = $request->all();
        return $this->antStore($data);
    }

    public function return_book($userId, $bookId)
    {
        return $this->antShow($userId, $this->model);
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
        $request->validate(
            [
                'date_lend' => 'required',
                'date_deliver' => 'nullable|date',
                'user_id' => 'required|integer|exists:people,id',
                'book_id' => 'required|integer|exists:books,id',

            ],
            [
                'user_id.exists' => 'El usuario no está registrado.',
                'book_id.exists' => 'El libro no está registrado.',
            ]
        );
    }
}
