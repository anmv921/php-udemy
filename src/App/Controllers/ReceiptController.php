<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ReceiptService, TransactionService};

class ReceiptController
{
  public function __construct(
    private TemplateEngine $view,
    private ReceiptService $receiptService,
    private TransactionService $transactionService
  ) {
  }

  public function uploadView(array $params)
  {
    $transaction = $this->transactionService->getUserTransaction($params['transaction']);

    if (!$transaction) {
      redirectTo("/");
    }

    echo $this->view->render("receipts/create.php");
  }

  public function upload(array $params)
  {
    $transaction = $this->transactionService->getUserTransaction($params['transaction']);

    if (!$transaction) {
      redirectTo("/");
    }

   $receiptFile = $_FILES["receipt"] ?? null;

   $this->receiptService->validateFile($receiptFile);

   $this->receiptService->upload($receiptFile, $transaction["id"]);

    redirectTo("/");
  }

  public function download(array $params) {
    $transaction = $this->transactionService->getUserTransaction(
      id: $params["transaction"]);

    if (empty($transaction)) {
      redirectTo('/');
    }

    $receipt = $this->receiptService->getReceipt(id: $params["receipt"]);

    if (empty($receipt)) {
      redirectTo('/');
    }

    if ($transaction["id"] !== $receipt["transaction_id"]) {
      redirectTo('/');
    }

    $this->receiptService->read(receipt: $receipt);


  }
  

  
  public function delete(array $params) {


    $transaction = $this->transactionService->getUserTransaction(
      id: $params["transaction"]);

    if (empty($transaction)) {
      redirectTo('/');
    }

    $receipt = $this->receiptService->getReceipt(id: $params["receipt"]);

    if (empty($receipt)) {
      redirectTo('/');
    }

    if ($transaction["id"] !== $receipt["transaction_id"]) {
      redirectTo('/');
    }


    $this->receiptService->delete($receipt);

    redirectTo('/');

  }


} 