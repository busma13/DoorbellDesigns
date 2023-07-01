<?php

class DDOrder
{
  private $id;
  private $customer;
  private $products;

  public function __construct()
  {
    $this->id = NULL;
    $this->customer = NULL;
    $this->products = NULL;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getCustomer(): ?Customer
  {
    return $this->customer;
  }

  public function setCustomer(Customer $customer)
  {
    $this->customer = $customer;
  }

  public function getProducts(): ?array
  {
    return $this->products;
  }
}