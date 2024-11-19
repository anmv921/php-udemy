<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class TransactionService 
{
    public function __construct(private Database $db)
    {
    }

    public function create( array $formData ) {

        $formattedDate = "{$formData['date']} 00:00:00";

        $this->db->query(
            query: "INSERT INTO transactions (user_id, description, amount, date)
            VALUES (:user_id, :description, :amount, :date)",
            params: [
                'user_id' => $_SESSION["user"],
                'description' => $formData['description'],
                'amount' => $formData['amount'],
                'date' => $formattedDate
            ]);
    } // End function create

    public function getUserTransactions(
        int $length,
        int $offset
    ) {

        $searchTerm = addcslashes($_GET['s'] ?? '', '%_');

        $params = [
            "user_id" => $_SESSION["user"],
            "description" => "%{$searchTerm}%"
        ];

        $transactions = $this->db->query(
            query: "SELECT *, DATE_FORMAT(date, '%Y-%M-%d', 'pt_PT') as formatted_date
            FROM transactions 
            WHERE user_id = :user_id 
            AND description LIKE :description
            LIMIT {$length} OFFSET {$offset};",
            params: $params
        )->findAll();

        $transactionCount = $this->db->query(
            query: "SELECT COUNT(*)
            FROM transactions 
            WHERE user_id = :user_id 
            AND description LIKE :description;",
            params: $params
        )->count();

  

        return [$transactions, $transactionCount];
    } // End function getUserTransactions

} // End class