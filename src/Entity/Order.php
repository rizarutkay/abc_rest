<?php
 namespace App\Entity;
 use Doctrine\ORM\Mapping as ORM;
 use Symfony\Component\ValorderCodeator\Constraints as Assert;
 /**
  * @ORM\Entity
  * @ORM\Table(name="orders")
  * @ORM\HasLifecycleCallbacks()
  */
 class Order implements \JsonSerializable {
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $orderCode;

  /**
   * @ORM\Column(type="integer")
   *
   */
  private $productid;
  /**
   * @ORM\Column(type="integer")
   */
  private $quantity;

    /**
   * @ORM\Column(type="string", length=255)
   */
  private $address;

    /**
   * @ORM\Column(type="date")
   */
  private $shippingDate;

  /**
   * @ORM\Column(type="datetime")
   */
  private $create_date;

  /////////GET-SET

  /**
   * @return mixed
   */
  public function getorderCode()
  {
   return $this->orderCode;
  }
  /**
   * @param mixed $orderCode
   */
  public function setorderCode($orderCode)
  {
   $this->orderCode = $orderCode;
  }
  /**
   * @return mixed
   */
  public function getproductid()
  {
   return $this->productid;
  }
  /**
   * @param mixed $productid
   */
  public function setproductid($productid)
  {
   $this->productid = $productid;
  }
  /**
   * @return mixed
   */
  public function getquantity()
  {
   return $this->quantity;
  }
  /**
   * @param mixed $quantity
   */
  public function setquantity($quantity)
  {
   $this->quantity = $quantity;
  }

   /**
   * @return mixed
   */
  public function getaddress()
  {
   return $this->address;
  }
  /**
   * @param mixed $address
   */
  public function setaddress($address)
  {
   $this->address = $address;
  }

   /**
   * @return mixed
   */
  public function getshippingDate()
  {
   return $this->shippingDate;
  }
  /**
   * @param mixed $shippingDate
   */
  public function setshippingDate($shippingDate)
  {
   $this->shippingDate = $shippingDate;
  }

  /**
   * @return mixed
   */
  public function getCreateDate(): ?\DateTime
  {
   return $this->create_date;
  }

  /**
   * @param \DateTime $create_date
   * @return Post
   */
  public function setCreateDate(\DateTime $create_date): self
  {
   $this->create_date = $create_date;
   return $this;
  }

  /**
   * @throws \Exception
   * @ORM\PrePersist()
   */
  public function beforeSave(){

   $this->create_date = new \DateTime('now', new \DateTimeZone('Europe/Istanbul'));
  }




  public function jsonSerialize()
  { 
    $date=$this->getshippingDate();  $date=$date->format('Y-m-d');
   // $date=date('Ymd', strtotime($date['date']));

   return [
    "productid" => $this->getproductid(),
    "quantity" => $this->getquantity(),
    "adress" => $this->getaddress(),
    "shippingDate" => $date
   ];
  }
 }