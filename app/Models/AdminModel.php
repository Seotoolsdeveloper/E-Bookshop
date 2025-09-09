<?php 
namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $DBGroup = 'default';

    /*==== Category ====*/
    public function createCategory($post)
    {
        $data = [
            'category' => $post['category'],
            'description' => $post['description'],
            'tag' => $post['tag']
        ];

        return $this->db->table('category')->insert($data);
    }

    public function getCategory()
    {
        return $this->db->table('category')->get()->getResult();
    }

    public function getCtgDetail($id)
    {
        return $this->db->table('category')->where('id', $id)->get()->getRow();
    }

    public function editCategory($id, $post)
    {
        $data = [
            'category' => $post['category'],
            'description' => $post['description'],
            'tag' => $post['tag']
        ];

        return $this->db->table('category')->where('id', $id)->update($data);
    }

    public function deleteCategory($id)
    {
        return $this->db->table('category')->where('id', $id)->delete();
    }

    /*==== Users ====*/
    public function getUsers()
    {
        return $this->db->table('users')->get()->getResult();
    }

    public function addUser($post)
    {
        $options = ['cost'=> 12];
        $passwordHash = password_hash($post['password'], PASSWORD_BCRYPT, $options);

        $data = [
            'name' => $post['name'],
            'contact' => $post['contact'],
            'email' => $post['email'],
            'address' => $post['address'],
            'city' => $post['city'],
            'password' => $passwordHash,
            'type' => $post['type']
        ];

        return $this->db->table('users')->insert($data);
    }

    public function deleteUser($id)
    {
        return $this->db->table('users')->where('id', $id)->delete();
    }

    /*==== Books ====*/
    public function addBooks($post, $uploadPath)
    {
        $data = [
            'book_name' => $post['book_name'],
            'description' => $post['description'],
            'author' => $post['author'],
            'publisher' => $post['publisher'],
            'price' => $post['price'],
            'quantity' => $post['quantity'],
            'categoryId' => $post['categoryId'],
            'book_image' => $uploadPath,
            'userId' => session()->get('id'),
            'status' => $post['status']
        ];

        return $this->db->table('books')->insert($data);
    }

    public function getBooks($limit, $offset)
    {
        return $this->db->table('books b')
            ->select('b.id, b.book_name, b.description, b.author, b.publisher, b.quantity, b.price, b.book_image, c.category, u.name')
            ->join('category c', 'b.categoryId = c.id')
            ->join('users u', 'b.userId = u.id')
            ->where('b.status', '1')
            ->orderBy('b.id', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->getResult();
    }

    public function countTotalBooks()
    {
        return $this->db->table('books')->where('status', '1')->get()->getResult();
    }

    public function getBookDetail($id)
    {
        return $this->db->table('books b')
            ->select('b.*, u.name, c.category')
            ->join('category c', 'b.categoryId = c.id')
            ->join('users u', 'b.userId = u.id')
            ->where('b.id', $id)
            ->get()
            ->getRow();
    }

    public function editBook($id, $post, $uploadPath)
    {
        $data = [
            'book_name' => $post['book_name'],
            'description' => $post['description'],
            'author' => $post['author'],
            'publisher' => $post['publisher'],
            'price' => $post['price'],
            'quantity' => $post['quantity'],
            'categoryId' => $post['categoryId'],
            'book_image' => $uploadPath,
            'userId' => session()->get('id'),
            'status' => $post['status']
        ];

        return $this->db->table('books')->where('id', $id)->update($data);
    }

    public function deleteBook($id)
    {
        return $this->db->table('books')->where('id', $id)->delete();
    }

    public function pendingBooks()
    {
        return $this->db->table('books b')
            ->select('b.*, u.name, c.category')
            ->join('category c', 'b.categoryId = c.id')
            ->join('users u', 'b.userId = u.id')
            ->where('b.status', '0')
            ->orderBy('b.id', 'DESC')
            ->get()
            ->getResult();
    }

    public function publishBook($id)
    {
        return $this->db->table('books')->where('id', $id)->update(['status' => 1]);
    }

    /*==== Orders ====*/
    public function getOrders()
    {
        return $this->db->table('orders')->orderBy('orderId', 'DESC')->get()->getResult();
    }

    public function getOrderDetail($orderId)
    {
        return $this->db->table('orders o')
            ->select('o.*, u.name, b.book_name')
            ->join('users u', 'o.userId = u.id')
            ->join('books b', 'o.bookId = b.id')
            ->where('o.orderId', $orderId)
            ->get()
            ->getRow();
    }

    public function acceptOrder($orderId)
    {
        return $this->db->table('orders')->where('orderId', $orderId)->update(['status' => 1]);
    }

    public function deleteOrder($orderId)
    {
        return $this->db->table('orders')->where('orderId', $orderId)->delete();
    }

    public function getOrdersToDeliver()
    {
        return $this->db->table('orders')->where('status', '1')->orderBy('orderId', 'DESC')->get()->getResult();
    }

    public function confirmDelivery($orderId)
    {
        return $this->db->table('orders')->where('orderId', $orderId)->update(['del_status' => 1]);
    }

    public function cancelDelivery($orderId)
    {
        return $this->db->table('orders')->where('orderId', $orderId)->update(['del_status' => 0]);
    }

    /*==== E-Books ====*/
    public function addEbooks($post, $uploadPath)
    {
        $data = [
            'ebook_name' => $post['ebook_name'],
            'description' => $post['description'],
            'author' => $post['author'],
            'categoryId' => $post['categoryId'],
            'book_file' => $uploadPath
        ];

        return $this->db->table('ebooks')->insert($data);
    }

    public function getEbooks()
    {
        return $this->db->table('ebooks e')
            ->select('e.*, c.category')
            ->join('category c', 'e.categoryId = c.id')
            ->orderBy('e.id', 'DESC')
            ->get()
            ->getResult();
    }

    public function getEbookDetail($id)
    {
        return $this->db->table('ebooks e')
            ->select('e.*, c.category')
            ->join('category c', 'e.categoryId = c.id')
            ->where('e.id', $id)
            ->get()
            ->getRow();
    }

    public function deleteEbook($id)
    {
        return $this->db->table('ebooks')->where('id', $id)->delete();
    }


}
