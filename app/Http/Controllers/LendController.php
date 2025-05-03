<?php

namespace App\Http\Controllers;

use App\Models\Lend as Model;
use Illuminate\Http\Request;
use Anturi\Larastarted\Controllers\BaseController;
use Anturi\Larastarted\Helpers\ResponseService;
use App\Exceptions\ModelNotFoundCustomException;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreLendRequest;
use App\Http\Requests\ReturnBookRequest;
use App\Models\Person;

use App\Services\LendService;

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
    {
        $request->validated();
        $data = $request->only(['user_id', 'book_id']);
        $data['date_lend'] = now()->format('y-m-d');
        return $this->antStore($data);
    }

    public function returnBook($id)
    {
        $person = Person::find($id);

        if (!$person) {
            return ResponseService::responseNotFound('persona');
        }
        $lend =  $person->lends()->orderBy('id', 'desc')->first();

        if ($lend->date_deliver != null)
            return ResponseService::responseErrorUser('Este usuario ya ha devuelto el libro');
        $bookId = $lend->book_id;
        $book = Book::find($bookId);
        $this->validateIfExists($book, 'libro');
        LendService::returnBook($book);
        LendService::returnPerson($person);
        LendService::returnLend($lend);
        return ResponseService::responseGet([$lend, $person, $book]);
    }

    private function validateIfExists($model, $modelName)
    {
        if (!$model)
            throw new ModelNotFoundCustomException($modelName);
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request);
        $data = $request->all();
        return $this->antUpdate($data, $id);
    }
    public function show($id)
    {
        $person = Person::find($id);
        if (!$person)
            throw new ModelNotFoundCustomException('persona');
        $lendByPerson = $person->lends()->paginate(20);
        return $lendByPerson;
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
