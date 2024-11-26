<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookRent extends Model
{
    
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function scopeSearch($query) {

        $query->from('book_rents as br')
            ->join('books as b', 'b.id', '=', 'br.book_id')
            ->join('customers as c', 'c.id', '=', 'br.customer_id')
            ->select('br.*', 'b.title as book_title', 'c.name as customer_name');


        return $query;
    }

}
