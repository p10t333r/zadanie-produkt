<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Product;

class ProductControllerTest extends \PHPUnit_Framework_TestCase {

    public function testCreatedTimestamps() {
        $Product = new Product();

        $Product->createdTimestamps();

        $this->assertInstanceOf(\DateTime::class, $Product->getCreateDate());
        
    }

}
