<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;
use App\Services\TransactionService;

class HomeController
{

    // Container.php loads the view if I understand it correctly
    public function __construct(
        private TemplateEngine $view,
        private TransactionService $transactionService
    )
    {}

    public function home()
    {
        $page = $_GET['p'] ?? 1;
        $page = (int) $page;
        $length = 3;
        $offset = ($page - 1) * $length;
        $searchTerm = $_GET['s'] ?? null;

        [$transactions, $count] = $this->transactionService->getUserTransactions(
            length: $length,
            offset: $offset
        );

        $lastPage = ceil($count / $length);

        echo $this->view->render(
            template: "/indexTemplate.php",
            data: [
                "transactions" => $transactions,
                "currentPage" => $page,
                "previousPageQuery" => http_build_query([
                    "p" => $page - 1,
                    "s" => $searchTerm
                ]),
                "lastPage" => $lastPage,
                "nextPageQuery" => http_build_query([
                    "p" => $page + 1,
                    "s" => $searchTerm
                ])
            ]
        );
    }
}
