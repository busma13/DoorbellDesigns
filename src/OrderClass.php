<?php

namespace App;

use App\CustomerClass;

class OrderClass
{
  private $id;
  private $customer;
  private $products;

  public function __construct()
  {
    $this->id = uniqid('ID', true);
    $this->customer = NULL;
    $this->products = NULL;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getCustomer(): ?CustomerClass
  {
    return $this->customer;
  }

  public function setCustomer(CustomerClass $customer)
  {
    $this->customer = $customer;
  }

  public function getProducts(): ?array
  {
    return $this->products;
  }

  public function setProducts($products)
  {
    $this->products = $products;
  }

  public function orderHasEmptyFields()
  {
    return $this->customer->customerHasEmptyFields() || empty($this->products);
  }

}