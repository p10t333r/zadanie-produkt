<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 * @ORM\Table(name="product")
 * @ORM\HasLifecycleCallbacks
 */
class Product {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length = 255)
     * 
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 100,
     *      minMessage = "Opis powinien zawierać co namniej {{ limit }} znaków",
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * 
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="numeric"
     * )
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createDate;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
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
     * Set description
     *
     * @param string $description
     *
     * @return Product
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
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return Product
     */
    public function setCreateDate($createDate) {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate() {
        return $this->createDate;
    }

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function createdTimestamps() {
        $this->setCreateDate(new \DateTime('now'));
    }

}
