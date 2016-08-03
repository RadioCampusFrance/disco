<?php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class SupportRepository extends EntityRepository{
  public function findAll(){
    return $this->findBy(array(), array('libelle' => 'ASC'));
  }
}
