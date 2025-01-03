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

    public function getUserTransactions( int $length, int $offset ) {

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

        $transactions = array_map( function(array $transaction) {

            $transaction['receipts'] = $this->db->query(
                "SELECT * FROM receipts WHERE transaction_id = :transaction_id",
                [
                    "transaction_id" => $transaction["id"]
                ]
            )->findAll();

            return $transaction;

        }, $transactions);

        return [$transactions, $transactionCount];
    } // End function getUserTransactions


    public function getUserTransaction(string $id) {

        return $this->db->query(
            "SELECT *, DATE_FORMAT(date, '%Y-%m-%d') as formatted_date
            FROM transactions 
            WHERE id = :id AND user_id = :user_id",
            [
                'id' => $id,
                'user_id' => $_SESSION["user"]
            ]
        )->find();
    } // End function getUserTransaction

    public function update(array $formData, int $id) {

        $formattedDate = "{$formData['date']} 00:00:00";

        $this->db->query(
          "UPDATE transactions 
          SET description = :description,
            amount = :amount,
            date = :date
          WHERE id = :id 
          AND user_id = :user_id",
          [
            'id' => $id,
            'user_id' => $_SESSION["user"],
            'amount' => $formData['amount'],
            'date' => $formattedDate,
            'description' => $formData['description']
          ]);
    } // End function update

    public function delete(int $id) {
        $this->db->query(
            "DELETE FROM transactions
            WHERE id = :id
            AND user_id = :user_id",
            [
                "id" => $id,
                "user_id" => $_SESSION["user"]
            ]
        );
    }



} // End class