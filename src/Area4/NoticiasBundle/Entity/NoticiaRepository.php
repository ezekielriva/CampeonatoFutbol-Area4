<?php

namespace Area4\NoticiasBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * NoticiaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NoticiaRepository extends EntityRepository {

	
	/**
	 * Lista las ultimas 3 noticias
	 * @param integer $cant
	 * @return Noticia[]
	 */
	public function getUltimas($cant=3) {
		/* @var $qry Query */
		$qry = $this->QryLista()
						->setMaxResults($cant)
					//	->setLimit($cant)
						->getQuery();
		
		return $qry->getResult();
	}
	/**
	 * Query generadora de las listas 
	 * @return Query
	 */
	public function QryLista(){
		return $this->createQueryBuilder('p')
					->orderBy('p.created_at','DESC');
						
	}

}