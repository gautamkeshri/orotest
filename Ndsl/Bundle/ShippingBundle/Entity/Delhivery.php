<?php

namespace Ndsl\Bundle\ShippingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Ndsl\Bundle\ShippingBundle\Model\ExtendDelhivery;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

//use Oro\Bundle\AddressBundle\Entity\AddressType;

/**
 * Delhivery
 *
 * @ORM\Table(name="ndsl_shipping")
 * @ORM\Entity
 * @Config(
 *      routeName="ndsl_index",
 *      routeView="ndsl_index_view",
 *      defaultValues={
 *			"ownership"={
 *              "owner_type"="USER",
 *              "owner_field_name"="owner",
 *              "owner_column_name"="user_owner_id",
 *              "organization_field_name"="organization",
 *              "organization_column_name"="organization_id"
 *          },
 *          "entity"={
 *              "icon"="icon-suitcase"
 *          },
 *          "security"={
 *              "type"="ACL",
 *              "group_name"=""
 *          },
 *          "note"={
 *              "immutable"=true
 *          },
 *          "grouping"={
 *              "groups"={"activity"}
 *          },
 *          "activity"={
 *              "immutable"=true
 *          },
 *          "attachment"={
 *              "immutable"=true
 *          }
 *      }
 *
 * )
 */
class Delhivery extends ExtendDelhivery {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var Order
	* @ORM\ManyToOne(targetEntity="OroCRM\Bundle\MagentoBundle\Entity\Order")
    * @ORM\JoinColumn(name="order_no", referencedColumnName="id", onDelete="SET NULL")
    */
    private $orderNo;

    /**
     * @var string
     *
     * @ORM\Column(name="invoice_no", type="string", length=255)
     */
    private $invoiceNo;

	/**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text")
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255)
     */
    private $state;

    /**
     * @var integer
     *
     * @ORM\Column(name="pincode", type="integer")
     */
    private $pincode;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var float
     *
     * @ORM\Column(name="weight", type="float")
     */
    private $weight;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var integer
     *
     * @ORM\Column(name="qty", type="integer")
     */
    private $qty;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set orderNo
     *
     * @param Order $order
     *
     * @return Delhivery
     */
    public function setOrderNo($order) {
        $this->orderNo = $order;

        return $this;
    }

    /**
     * Get orderNo
     *
     * @return Order
     */
    public function getOrderNo() {
        return $this->orderNo;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Delhivery
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Delhivery
     */
    public function setAddress($address) {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return Delhivery
     */
    public function setPhone($phone) {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Delhivery
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Delhivery
     */
    public function setCity($city) {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return Delhivery
     */
    public function setState($state) {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState() {
        return $this->state;
    }

    /**
     * Set pincode
     *
     * @param integer $pincode
     *
     * @return Delhivery
     */
    public function setPincode($pincode) {
        $this->pincode = $pincode;

        return $this;
    }

    /**
     * Get pincode
     *
     * @return integer
     */
    public function getPincode() {
        return $this->pincode;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Delhivery
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Delhivery
     */
    public function setUrl($url) {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Set weight
     *
     * @param float $weight
     *
     * @return Delhivery
     */
    public function setWeight($weight) {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return float
     */
    public function getWeight() {
        return $this->weight;
    }

    /**
     * Set amount
     *
     * @param float $amount
     *
     * @return Delhivery
     */
    public function setAmount($amount) {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * Set invoiceNo
     *
     * @param string $invoiceNo
     *
     * @return Delhivery
     */
    public function setInvoiceNo($invoiceNo) {
        $this->invoiceNo = $invoiceNo;

        return $this;
    }

    /**
     * Get invoiceNo
     *
     * @return string
     */
    public function getInvoiceNo() {
        return $this->invoiceNo;
    }

    /**
     * Set qty
     *
     * @param integer $qty
     *
     * @return Delhivery
     */
    public function setQty($qty) {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Get qty
     *
     * @return integer
     */
    public function getQty() {
        return $this->qty;
    }
}	