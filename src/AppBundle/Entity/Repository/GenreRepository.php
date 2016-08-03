<?php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class GenreRepository extends EntityRepository{
  public function findAll(){
    return $this->findBy(array(), array('libelle' => 'ASC'));
  }
}
