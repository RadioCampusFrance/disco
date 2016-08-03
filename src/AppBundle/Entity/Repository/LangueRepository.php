<?php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class LangueRepository extends EntityRepository{
  public function findAll(){
    return $this->findBy(array(), array('libelle' => 'ASC'));
  }
}
