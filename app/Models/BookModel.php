<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $DBGroup      = 'default';
    protected $table        = 'books';
    protected $primaryKey   = 'id';
    protected $returnType   = 'object';
    protected $allowedFields = [
        'book_name', 'categoryId', 'userId', 'description',
        'status', 'file', 'cover'
    ];

    protected $useTimestamps = true;

    /* ================= BOOK LIST ================= */
    public function getBooksWithCategory()
    {
        return $this->select('books.*, c.category, c.tag')
            ->join('category c', 'books.categoryId = c.id', 'left')
            ->where('books.status', '1');
    }

    public function paginateBooks($perPage = 18)
    {
        return $this->getBooksWithCategory()
            ->orderBy('books.id', 'DESC')
            ->paginate($perPage);
    }

    /* ================= SINGLE BOOK ================= */
    public function getBookDetail($id)
    {
        return $this->getBooksWithCategory()
            ->where('books.slug', $id)
            ->first();
    }

    /* ================= SEARCH ================= */
    public function searchBooks($query, $perPage = 18)
    {
        return $this->getBooksWithCategory()
            ->like('books.book_name', $query)
            ->orderBy('books.id', 'DESC')
            ->paginate($perPage);
    }


    public function recentBooks()
{
    return $this->asObject()
        ->where('status', 1)
        ->orderBy('id', 'DESC')
        ->limit(6)
        ->find();
}

public function cseBooks()
{
    return $this->asObject()
        ->where(['status' => 1, 'categoryId' => 1])
        ->orderBy('id', 'DESC')
        ->limit(6)
        ->find();
}







public function generateSlugsForAllBooks()
{
    // Get all books
    $books = $this->db->table('books')->get()->getResult();

    foreach ($books as $book) {
        if (!empty($book->book_name)) {
            // Generate slug
            $slug = url_title($book->book_name, '-', true);

            // Update book with slug
            $this->db->table('books')
                ->where('id', $book->id)
                ->update(['slug' => $slug]);
        }
    }

    return true;
}

}
