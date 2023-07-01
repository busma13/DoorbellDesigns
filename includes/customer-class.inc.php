<?php
use Square\Models\VoidTransactionResponse;

class Customer
{
  private $first;
  private $last;
  private $tel;
  private $email;
  private $address_line;
  private $city;
  private $state;
  private $zip;

  public function __construct()
  {
    $this->first = NULL;
    $this->last = NULL;
    $this->tel = NULL;
    $this->email = NULL;
    $this->address_line = NULL;
    $this->city = NULL;
    $this->state = NULL;
    $this->zip = NULL;
  }

  public function getFirst(): ?string
  {
    return $this->first;
  }

  public function setFirst(?string $first): void
  {
    $this->first = $first;
  }

  public function getLast(): ?string
  {
    return $this->last;
  }

  public function setLast(?string $last): void
  {
    $this->last = $last;
  }

  public function getTel(): ?string
  {
    return $this->tel;
  }

  public function setTel(?string $tel): void
  {
    $this->tel = $tel;
  }

  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function setEmail(?string $email): void
  {
    $this->email = $email;
  }

  public function getAddress_line(): ?string
  {
    return $this->address_line;
  }

  public function setAddress_line(?string $address): void
  {
    $this->address_line = $address;
  }

  public function getCity(): ?string
  {
    return $this->city;
  }

  public function setCity(?string $city): void
  {
    $this->city = $city;
  }

  public function getState(): ?string
  {
    return $this->state;
  }

  public function setState(?string $state): void
  {
    $this->state = $state;
  }

  public function getZip(): ?string
  {
    return $this->zip;
  }

  public function setZip(?string $zip): void
  {
    $this->zip = $zip;
  }

}