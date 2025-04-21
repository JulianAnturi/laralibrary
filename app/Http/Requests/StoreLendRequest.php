<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Book;
use App\Models\Person;

class StoreLendRequest extends FormRequest
{
    protected ?Book $book = null;

    public function authorize(): bool
    {
        return true; // Cambialo si querés usar políticas de autorización
    }

    public function rules(): array
    {
        return [
            'date_lend' => 'required|date',
            'date_deliver' => 'nullable|date',
            'user_id' => 'required|integer|exists:people,id',
            'book_id' => 'required|integer|exists:books,id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $bookId = $this->input('book_id');
            $userId = $this->input('user_id');
            $user  = Person::find($userId);
            if ($bookId) {
                $book = Book::find($bookId);

                if ($book && $book->lended >= $book->quantity) {
                    $validator->errors()->add('book_id', 'Este libro no esta disponible para prestar.');
                }
                $book->lended = $book->lended + 1;
                $book->save();
            }
            if ($user->lended == true)
                $validator
                    ->errors()
                    ->add('user_lended', 'Este usuario ya tiene un libro, no se puede prestar otro hasta que lo devuelva');
            $user->lended = true;
            $user->save();
        });
    }
}
