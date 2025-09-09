<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['name', 'contact', 'email', 'address', 'city', 'password', 'type'];

    public function registerUser(array $post)
    {
        $passwordHash = password_hash($post['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        return $this->insert([
            'name'     => $post['name'],
            'contact'  => $post['contact'],
            'email'    => $post['email'],
            'address'  => $post['address'],
            'city'     => $post['city'],
            'password' => $passwordHash,
            'type'     => 'U'
        ]);
    }

    public function loginUser(string $email, string $password)
    {
        $user = $this->where('email', $email)->first();
        return ($user && password_verify($password, $user->password)) ? $user : false;
    }

    


    public function get_reviews()
    {
        return $this->orderBy('id', 'DESC')->findAll();
    }



    // Fetch user details by ID
    public function getUserDetails($id)
    {
        return $this->find($id); // CI4 Model provides find() to get row by primary key
    }

    // Update user profile
    public function editProfile($id, $data)
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $options = ['cost' => 12];
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT, $options);
        }

        return $this->update($id, $data); // CI4 update method
    }




    public function myBooks($userId = null)
    {
        $userId = $userId ?? session()->get('id');

        $builder = $this->db->table('books b');
        $builder->select('b.*, c.*');
        $builder->join('category c', 'b.categoryId = c.id');
        $builder->where('b.userId', $userId);
        $builder->orderBy('b.id', 'DESC');

        return $builder->get()->getResult();
    }

    public function myPublishedBooks($userId = null)
    {
        $userId = $userId ?? session()->get('id');

        return $this->db->table('books')
                        ->where('userId', $userId)
                        ->where('status', '1')
                        ->get()
                        ->getResult();
    }

    public function deleteBook($id)
    {
        return $this->db->table('books')->where('id', $id)->delete();
    }

    public function reviews($bookId)
    {
        $data = [
            'review' => $this->request->getPost('review'),
            'userId' => session()->get('id'),
            'bookId' => $bookId
        ];

        return $this->db->table('reviews')->insert($data);
    }

    public function getReviews($bookId)
    {
        return $this->db->table('reviews r')
                        ->select('r.*, u.*')
                        ->join('users u', 'r.userId = u.id')
                        ->where('r.bookId', $bookId)
                        ->orderBy('r.id', 'DESC')
                        ->get()
                        ->getResult();
    }

   public function addOrders(array $cartItems, array $postData, float $shippingFee = 400)
    {
        $userId = session()->get('id');
        $total = 0;
        $books = [];
        $quantities = [];

        foreach ($cartItems as $item) {
            $books[] = $item['id'];
            $quantities[] = $item['qty'];
            $total += $item['price'] * $item['qty'];
        }

        $data = [
            'userId'       => $userId,
            'ship_name'    => $postData['name'] ?? '',
            'address'      => $postData['address'] ?? '',
            'city'         => $postData['city'] ?? '',
            'email'        => $postData['email'] ?? '',
            'contact'      => $postData['contact'] ?? '',
            'zipcode'      => $postData['zipcode'] ?? '',
            'paymentcheck' => $postData['paymentcheck'] ?? '',
            'total_price'  => $total + $shippingFee,
            'bookId'       => implode(',', $books),
            'quantity'     => implode(',', $quantities),
            'created_at'   => date('Y-m-d H:i:s')
        ];

        return $this->insert($data);
    }



    

    public function myOrders($userId = null)
    {
        $userId = $userId ?? session()->get('id');

        return $this->db->table('orders')
                        ->where('userId', $userId)
                        ->orderBy('orderId', 'DESC')
                        ->get()
                        ->getResult();
    }

    public function myReviews($userId = null)
    {
        $userId = $userId ?? session()->get('id');

        return $this->db->table('reviews')
                        ->where('userId', $userId)
                        ->orderBy('id', 'DESC')
                        ->get()
                        ->getResult();
    }



   public function addbooks($data)
{
    $data['userId'] = session()->get('id'); // Add user ID
    if (isset($data['book_name'])) {
        $data['slug'] = url_title($data['book_name'], '-', true); // 'true' converts to lowercase
    } else {
        $data['slug'] = null;
    }
    return $this->db->table('books')->insert($data);
}

}
