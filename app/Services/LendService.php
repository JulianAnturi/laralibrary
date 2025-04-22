<?php

namespace App\Services;

class LendService
{

    static function returnPerson($userModel): void
    {
        $userModel->lended = false;
        $userModel->save();
    }

    static function returnBook($bookModel): void
    {
        $bookModel->lended = $bookModel->lended - 1;
        $bookModel->save();
    }

    static function returnLend($lendModel): void
    {
        $lendModel->date_deliver = now()->format('Y-m-d');
        $lendModel->save();
    }
}
