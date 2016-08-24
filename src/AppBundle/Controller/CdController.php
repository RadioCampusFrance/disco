<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\DiscoController;
use AppBundle\Entity\Cd;
use AppBundle\Entity\CdNote;
use AppBundle\Entity\CdComment;
use AppBundle\Entity\Piste;
use AppBundle\Form\CdType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Validator\Constraints\EmailValidator;
use HTML2PDF;


class CdController extends DiscoController
{
    /**
     * @Route("/cd", name="cd")
     */
    public function indexAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Une connexion est nécessaire.');

    	$doctrine = $this->getDoctrine();
	    $em = $doctrine->getManager();
    	$limit = $this->container->getParameter('listinglimit');

    	$retour = null;
    	$langues = $doctrine->getRepository('AppBundle:Langue')->findAll();
    	$genres = $doctrine->getRepository('AppBundle:Genre')->findAll();
    	$rotations = $doctrine->getRepository('AppBundle:Rotation')->findAll();
    	$supports = $doctrine->getRepository('AppBundle:Support')->findAll();
    	$types = $doctrine->getRepository('AppBundle:Type')->findAll();
    	if($request->isMethod("POST")) {
    		$num = $request->request->getInt('num',-1);
    		$artiste = $request->request->get("artiste");
    		$titre = $request->request->get("titre","");
    		$label = $request->request->get("label");
    		$annee = $request->request->getInt("annee");
    		$langue = $request->request->getInt("langue",-1);
    		$genre = $request->request->getInt("genre",-1);
    		$rotation = $request->request->getInt("rotation",-1);
    		$support = $request->request->getInt("support",-1);
    		$type = $request->request->getInt("type",-1);
	    	if($num >= 1) {

	    		return $this->redirect($this->generateUrl('showCd',array('id'=>$num)));
	    	}

    		$retour = $em->getRepository('AppBundle:Cd')->createQueryBuilder('c')
    			->andWhere('c.titre LIKE :titre_l')
    			->setParameter('titre_l','%'.$titre.'%')
                ->orWhere('c.titre = :titre')
                ->setParameter('titre',$titre);
			if(!empty($artiste)) {
				$retour = $retour->innerJoin('c.artiste','a')
				->andWhere('a.libelle LIKE :artiste_l')
				->setParameter('artiste_l','%'.$artiste.'%')
                ->orWhere('a.libelle = :artiste')
                ->setParameter('artiste',$artiste);
			}
			if(!empty($label)) {
				$retour = $retour->innerJoin('c.label','l')
				->andWhere('l.libelle LIKE :label_l')
				->setParameter('label_l','%'.$label.'%')
                ->orWhere('l.libelle = :label')
                ->setParameter('label',$label);

			}
			if($annee != 0) {
				$retour = $retour->andWhere('c.annee = :annee')
				->setParameter('annee',$annee);
			}
			if(!empty($langue)) {
				$retour = $retour->andWhere('c.langue = :langue')
				->setParameter('langue', $langue);
			}
			if(!empty($genre)) {
				$retour = $retour->andWhere('c.genre = :genre')
				->setParameter('genre', $genre);
			}
			if(!empty($rotation)) {
				$retour = $retour->andWhere('c.rotation = :rotation')
				->setParameter('rotation', $rotation);
			}
			if(!empty($support)) {
				$retour = $retour->andWhere('c.support = :support')
				->setParameter('support', $support);
			}
			if(!empty($type)) {
				$retour = $retour->andWhere('c.type = :type')
				->setParameter('type', $type);
			}

			$retour = $retour->orderBy('c.titre', 'ASC')
                ->andWhere('c.suppr != 1')
				->setMaxResults($limit)
				->getQuery()
				->getResult();

            if (empty($retour)) {
                $this->addFlash('error', 'Aucun disque trouvé !');
            }

    	} else {
    		$retour = $em->getRepository('AppBundle:Cd')->createQueryBuilder('c')
                ->where('c.suppr != 1')
    			->orderBy('c.cd','DESC')
    			->setMaxResults($limit)
    			->getQuery()
    			->getResult();
    	}

        return $this->render('cd/search.html.twig',array(
	        	'recherche'=>$retour,
	        	'langues'=>$langues,
	        	'genres'=>$genres,
	        	'rotations'=>$rotations,
	        	'supports'=>$supports,
	        	'types'=>$types,
	        	'post'=>$request->request->all()
        	));
    }

    /**
     * @Route("/cd/a-traiter", name="cdNonTraites")
     */
    public function nonTraitesAction()
    {
        $this->denyAccessUnlessGranted('ROLE_PROGRA', null, 'Seuls les programmateurs ont accès à cette page.');

        $cds = $this->getDoctrine()->getRepository('AppBundle:Cd')->createQueryBuilder('cd')
            ->where('cd.retourLabel = 0')
            ->orderBy('cd.dsaisie', 'ASC')
            ->orderBy('cd.userProgra', 'ASC')
            ->orderBy('cd.rotation', 'ASC')
            ->setMaxResults($this->container->getParameter('listinglimit'))
            ->getQuery()
            ->getResult();

        return $this->render(
            'cd/traitements.html.twig',
            array('cds' => $cds)
        );
    }

    /**
     * @Route("/cd/show/{id}", name="showCd", options={"expose"=true})
     */
    public function showAction($id) {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Une connexion est nécessaire.');

        $cd = $this->getDoctrine()
            ->getRepository('AppBundle:Cd')
            ->find($id);

        if(!$cd || $cd->getSuppr()) {
            throw $this->createNotFoundException(
                'Aucun cd trouvé pour cet id : '.$id
            );
        }

        return $this->render(
            'cd/show.html.twig',
            array('cd' => $cd)
        );
    }

    /**
	 * @Route("/cd/delete/{id}", name="deleteCd", options={"expose"=true})
     */
	public function deleteAction($id) {
        $this->denyAccessUnlessGranted('ROLE_PROGRA', null, 'Seul un programmateur peut supprimer un disque.');

		$cd = $this->getDoctrine()
			->getRepository('AppBundle:Cd')
			->find($id);

		if(!$cd) {
			throw $this->createNotFoundException(
            	'Aucun cd trouvé pour cet id : '.$id
        	);
		}

		$em = $this->getDoctrine()->getManager();
        $cd->setSuppr(1);
        $em->persist($cd);
        $em->flush();

        $this->discoLog("suppression logique du CD ".$cd->getCd()." ".$cd->getTitre());
        $this->addFlash('success','Le Cd ne s\'affichera plus. Si cela est une erreur, contactez l\'admin !');
        return $this->redirect($this->generateUrl('cd'));
	}

    /**
     * @Route("/cd/removePochette/{id}", name="removePochette", options={"expose"=true})
     */
    public function removePochetteAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_PROGRA', null, 'Seul un programmateur peut supprimer une pochette.');

        $cd = $this->getDoctrine()
            ->getRepository('AppBundle:Cd')
            ->find($id);

        if(!$cd) {
            throw $this->createNotFoundException(
                'Aucun cd trouvé pour cet id : '.$id
            );
        }

        $cd->removeImg();
        $this->getDoctrine()->getManager()->flush();

        $response = new JsonResponse();
        $response->setData(array('ok'=>true));
        return $response;
    }

    /**
     * @Route("/cd/edit/{id}", name="editCd")
     */
    public function editAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_PROGRA', null, 'Seul un programmateur peut éditer un disque.');

        $em = $this->getDoctrine()->getManager();
        $cd = $em->getRepository('AppBundle:Cd')->find($id);

        if(!$cd || $cd->getSuppr()) {
            throw $this->createNotFoundException(
                'Aucun cd trouvé pour cet id : '.$id
            );
        }

        $form = $this->createForm(new CdType(),$cd);
        $form->add('submit', 'submit', array(
                'label' => 'Sauvegarder le CD',
                'attr' => array('class' => 'btn btn-success btn-block','style'=>'font-weight:bold')
            ));

        $form->handleRequest($request);

        $req = $request->request->get('appbundle_cd');

        $full_fr = true;
        foreach ($cd->getPistes() as $key => $piste) {
            if(!$piste->getLangue()) { $full_fr = false; break; }
        }

        if ($form->isValid()) {
            $cd->prepareUpload();

            $artiste = $em->getRepository('AppBundle:Artiste')->findOneByLibelle($req['artiste']);

            if(!$artiste or empty($req['artiste'])) {
                $this->addFlash('error','L\'artiste renseigné n\'existait pas.');

                if($request->request->get('full_fr')) {
                    $pistes_var['full_fr'] = 1;
                }
                $pistes = $this->savePistes($req['nbPiste'],$request);
            } else {
                $cd->setArtiste($artiste);
            }
            $label = $em->getRepository('AppBundle:Label')->findOneByLibelle($req['label']);

            if($label) {
                $cd->setLabel($label);
            }
            $maison = $em->getRepository('AppBundle:Label')->findOneByLibelle($req['maison']);

            if($maison) {
                $cd->setMaison($maison);
            }
            $distrib = $em->getRepository('AppBundle:Label')->findOneByLibelle($req['distrib']);

            if($distrib) {
                $cd->setDistrib($distrib);
            }


            $em->createQuery(
                    'DELETE FROM AppBundle:Piste p
                    WHERE p.cd = :cd'
                )
                ->setParameter('cd',$cd)
                ->getResult();

            for($i = 1; $i <= $req['nbPiste']; $i++) {
                $piste = new Piste();
                $piste->setCd($cd);
                $piste->setPiste($i);
                $piste->setTitre($request->request->get('titre_'.$i));
                if(empty($request->request->get('artiste_'.$i))) {
                    $p_artiste = $cd->getArtiste();
                } else {
                    $p_artiste = $em->getRepository('AppBundle:Artiste')->findOneByLibelle($request->request->get('artiste_'.$i));
                    if(empty($p_artiste)) {
                        $p_artiste = $cd->getArtiste();
                    }
                }

                $piste->setArtiste($p_artiste);
                if($request->request->get('fr_'.$i)) {
                    $piste->setLangue(true);
                } else {
                    $piste->setLangue(false);
                }
                if ($request->request->get('anim_'.$i)) {
                  $piste->chooseAnim();
                }
                if ($request->request->get('rivendell_'.$i)) {
                  $piste->chooseRivendell();
                }
                if ($request->request->get('star_'.$i)) {
                  $piste->chooseStar();
                }

                $em->persist($piste);
            }

            $em->flush();

            $pistes = $this->savePistes($req['nbPiste'],$request);

            $this->discoLog("a modifié le CD ".$cd->getCd()." ".$cd->getTitre());
            $this->addFlash('success','Le CD a bien été sauvegardé !');

        } else {
            if ($request->isMethod('POST')) {
                $this->addFlash('error','Les champs ont été mal renseignés.');
                $pistes = $this->savePistes($req['nbPiste'],$request);
            } else {
                $pistes = array();
                $i = 0;
                foreach ($cd->getPistes() as $key => $piste) {
                    $pistes[$i]['titre'] = $piste->getTitre();
                    $pistes[$i]['artiste'] = $piste->getArtiste();
                    if($piste->getLangue()){
                        $pistes[$i]['fr'] = 1;
                    } else { $pistes[$i]['fr'] = 0; }
                    if($piste->getRivendell()){
                        $pistes[$i]['rivendell'] = 1;
                    } else { $pistes[$i]['rivendell'] = 0; }
                    if($piste->getStar()){
                        $pistes[$i]['star'] = 1;
                    } else { $pistes[$i]['star'] = 0; }
                    if($piste->getAnim()){
                        $pistes[$i]['anim'] = 1;
                    } else { $pistes[$i]['anim'] = 0; }
                    $i++;
                }
            }
            if($request->request->get('full_fr')) {
                $pistes_var['full_fr'] = 1;
            }
        }

        return $this->render('cd/edit.html.twig', array(
                'cd' => $cd,
                'form' => $form->createView(),
                'pistes' => $pistes,
                'full_fr' => $full_fr
            ));

    }

    /**
     * @Route("/cd/create", name="createCd")
     */
    public function createAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_PROGRA', null, 'Seul un programmateur peut créer un disque.');

        $valid = true;

        $cd = new Cd();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user != false) { $cd->setUserProgra($user); }
        $form = $this->createForm(new CdType(),$cd);
        $form->add('submit', 'submit', array(
                'label' => 'Créer le CD',
                'attr' => array('class' => 'btn btn-success btn-block','style'=>'font-weight:bold')
            ));

        $req = $request->request->get('appbundle_cd');

        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $pistes_var['full_fr'] = false;

        $artiste = $em->getRepository('AppBundle:Artiste')->findOneByLibelle($req['artiste']);

        if($request->isMethod('POST') && (!$artiste or empty($req['artiste']))) {
            $this->addFlash('error','L\'artiste renseigné n\'existe pas.');
            $valid = false;
        }

        if($form->isValid() && $valid) {
            $cd->setLabel(null);
            $cd->setMaison(null);
            $cd->setDistrib(null);

            $cd->setArtiste($artiste);

            $label = $em->getRepository('AppBundle:Label')->findOneByLibelle($req['label']);

            if($label) {
                $cd->setLabel($label);
            }
            $maison = $em->getRepository('AppBundle:Label')->findOneByLibelle($req['maison']);

            if($maison) {
                $cd->setMaison($maison);
            }
            $distrib = $em->getRepository('AppBundle:Label')->findOneByLibelle($req['distrib']);

            if($distrib) {
                $cd->setDistrib($distrib);
            }

            for($i = 1; $i <= $req['nbPiste']; $i++) {
                $piste = new Piste();
                $piste->setCd($cd);
                $piste->setPiste($i);
                $piste->setTitre($request->request->get('titre_'.$i));
                if(empty($request->request->get('artiste_'.$i))) {
                    $p_artiste = $cd->getArtiste();
                } else {
                    $p_artiste = $em->getRepository('AppBundle:Artiste')->findOneByLibelle($request->request->get('artiste_'.$i));
                    if(empty($p_artiste)) { $p_artiste = $cd->getArtiste(); }
                }

                $piste->setArtiste($p_artiste);
                if($request->request->get('fr_'.$i)) {
                    $piste->setLangue(true);
                } else {
                    $piste->setLangue(false);
                }

                if ($request->request->get('anim_'.$i)) {
                  $piste->chooseAnim();
                }
                if ($request->request->get('rivendell_'.$i)) {
                  $piste->chooseRivendell();
                }
                if ($request->request->get('star_'.$i)) {
                  $piste->chooseStar();
                }

                $em->persist($piste);
            }

            $em->persist($cd);
            $em->flush();

            $num = $cd->getCd();

            $this->discoLog("a créé le CD $num ".$cd->getTitre());
            $this->addFlash('success','Le CD a bien été créé !');

            return $this->redirect($this->generateUrl('showCd',array('id'=>$num)));

        } else {
            if ($request->isMethod('POST')) {
                $this->addFlash('error','Les champs ont été mal renseignés.');
            }
            if($request->request->get('full_fr')) {
                $pistes_var['full_fr'] = 1;
            }
            $pistes = $this->savePistes($req['nbPiste'],$request);
            return $this->render('cd/create.html.twig',array(
                'form'=>$form->createView(),
                'pistes' => $pistes,
                'pistes_var' => $pistes_var
            ));
        }
    }

    private function savePistes($nbPistes, $request)
    {
        $pistes = null;
        if ($nbPistes>0) {
            for ($i=1; $i <= $nbPistes; $i++) {
                $pistes[$i]['titre'] = $request->request->get('titre_'.$i);
                $pistes[$i]['artiste'] = $this->getDoctrine()->getManager()->getRepository('AppBundle:Artiste')->find($request->request->get('artiste_'.$i));
                if($request->request->get('fr_'.$i)){
                    $pistes[$i]['fr'] = 1;
                } else { $pistes[$i]['fr'] = 0; }

                $pistes[$i]['rivendell'] = $request->request->get('rivendell_'.$i) ? 1 : 0;
                $pistes[$i]['star'] = $request->request->get('star_'.$i) ? 1 : 0;
                $pistes[$i]['anim'] = $request->request->get('anim_'.$i) ? 1 : 0;
            }
        }
        return $pistes;
    }

    /**
     *  @Route("/cd/autocomplete/{like}", name="autocompleteTitre")
     */
    public function autocompleteAction($like, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecté pour chercher un disque.');
        $limit = $this->container->getParameter('autocompletelimit');

        $em = $this->getDoctrine()->getManager();
        $res = $em->getRepository('AppBundle:Cd')->createQueryBuilder('c')
            ->select('c.cd AS num, c.titre AS label, c.titre AS value');
        if($like) {
            $res = $res->where('c.titre LIKE :titre')
                ->setParameter('titre','%'.$request->query->get('term').'%');
        } else {
            $res = $res->where('c.titre = :titre')
                ->setParameter('titre',$request->query->get('term'));
        }
        $res= $res
            ->orderBy('c.titre','ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        $response = new JsonResponse();
        $response->setData($res);
        return $response;
    }

    /**
     * @Route("/cd/{id}/comment", name="commentCd")
     */
    public function commentAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecté pour poster un commentaire.');
        $em = $this->getDoctrine()->getManager();

        $post = $request->request;
        $comment = new CdComment();
        $cd = $em->getRepository('AppBundle:Cd')->find($id);


        $comment->setComment($post->get('message'));
        $comment->setUser($this->get('security.token_storage')->getToken()->getUser());
        $comment->setCd($cd);

        $em->persist($comment);
        $em->flush();

        $response = new JsonResponse();
        $response->setData();
        return $response;
    }

    /**
     * @Route("/cd/{cd}/comments/{comment}", name="recupComments")
     */
    public function recupComment(Request $request, $cd, $comment)
    {
        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository('AppBundle:CdComment')->createQueryBuilder('c')
            ->select('c')
            ->where('c.cd = :cd')
            ->setParameter('cd',$cd)
            ->andWhere('c.dbkey > :last_comment')
            ->setParameter('last_comment',$comment)
            ->orderBy('c.dbkey','ASC')
            ->getQuery()
            ->getResult();

        $retour = array();
        foreach ($comments as $key => $comment) {
            $retour[$key]['user'] = $comment->getUser()->getLibelle();
            $retour[$key]['dbkey'] = $comment->getDbkey();
            $retour[$key]['chrono'] = $comment->getChrono()->format("d/m/Y - H:i");
            $retour[$key]['comment'] = $comment->getComment();
        }


        $response = new JsonResponse();
        $response->setData($retour);
        return $response;
    }

    /**
     * @Route("/cd/note/{id}", name="noteCd")
     */
    public function noteAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_PROGRA', null, 'Seuls les programmateurs peuvent noter un CD.');
        $note = $request->request->get('note');
        if(is_numeric($note) && $note >= 0 && $note <= 20) {
            $note = round($note);

            $em = $this->getDoctrine()->getManager();

            $user = $this->get('security.token_storage')->getToken()->getUser();
            $cd = $em->getRepository('AppBundle:Cd')->find($id);

            if(!$cd) {
                throw $this->createNotFoundException(
                    'Aucun cd trouvé pour cet id : '.$id
                );
            }

            $repository = $em->getRepository('AppBundle:CdNote');
            $verif_note = $repository->findOneBy(array('user'=>$user,'cd'=>$cd));

            if($verif_note) {
                $ex = $verif_note->getNote();
                $verif_note->setNote($note);
                $em->flush();

                $this->addFlash('success',"Votre note a été mise à jour (ancienne note: $ex)");
            } else {
                $cd_note = new CdNote();
                $cd_note->setCd($cd);
                $cd_note->setUser($user);
                $cd_note->setNote($note);

                $em->persist($cd_note);

                $note_moy = $em->getRepository('AppBundle:CdNote')->createQueryBuilder('n')
                    ->select('avg(n.note)')
                    ->where('n.cd = :cd')
                    ->setParameter('cd',$cd)
                    ->getQuery()
                    ->getResult();

                $cd->setNoteMoy($note_moy[0][1]);

                $em->persist($cd);
                $em->flush();

                $this->addFlash('success','La note que vous avez choisie a été affectée au CD.');
            }

        } else {
            $this->addFlash('error','La note d\'un CD doit être numérique, comprise entre 0 et 20.');
        }

        return $this->redirect($this->generateUrl('showCd',array('id'=>$id)));
    }

    /**
     * @Route("/cd/{id}/editRetour", name="editRetourLabel")
     */
    public function editRetourLabelAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_PROGRA', null, 'Seuls les programmateurs peuvent éditer le retour label.');

        $em = $this->getDoctrine()->getManager();

        $cd = $em->getRepository('AppBundle:Cd')->find($id);

        if(!$cd) {
            throw $this->createNotFoundException(
                'Aucun cd trouvé pour cet id : '.$id
            );
        }

        $cd->setRetourComment($request->request->get('retour_comment'));

        $em->persist($cd);
        $em->flush();

        $this->discoLog("a modifié le message de retour au label du disque ".$cd->getCd()." ".$cd->getTitre());
        $this->addFlash('info','Le message de retour label a été modifié.');

        return $this->redirect($this->generateUrl('showCd',array('id'=>$id)));
    }

    /**
     * @Route("/cd/getinfos/{id}", name="getInfosCd", options={"expose"=true})
     */
    public function getInfosAction($id)
    {
        if(is_numeric($id)) {
            $cd = $this->getDoctrine()->getManager()->getRepository('AppBundle:Cd')->find($id);
        } else {
            $cd = $this->getDoctrine()->getManager()->getRepository('AppBundle:Cd')->findOneByTitre($id);
        }

        if(!$cd || $cd->getSuppr()) {
          $response = new JsonResponse();
          $response->setData(array('erreur' => 'CD non trouvé'));
          return $response;
        }

        $tab = array(
            'cd' => $cd->getCd(),
            'artiste'=>$cd->getArtiste()->getLibelle(),
            'titre' => $cd->getTitre(),
            'annee' => $cd->getAnnee(),
            'note' => $cd->getNoteMoy(),
            'ecoute' => $cd->getEcoute()
        );
        if ($cd->getRotation()) {
            $tab['rotation'] = $cd->getRotation()->getLibelle();
        } else {
            $tab['rotation'] = '';
        }
        if ($cd->getGenre()) {
            $tab['genre'] = $cd->getGenre()->getLibelle();
        } else {
            $tab['genre'] = '';
        }
        if ($cd->getType()) {
            $tab['type'] = $cd->getType()->getLibelle();
        } else {
            $tab['type'] = '';
        }

        $tab['star'] = 0;
        $tab['rivendell'] = 0;
        $tab['anim'] = 0;

        foreach ($cd->getPistes() as $key => $piste) {
            if($piste->getStar()) {
                $tab['star']++;
            }
            if($piste->getRivendell()) {
                $tab['rivendell']++;
            }
            if($piste->getAnim()) {
                $tab['anim']++;
            }
        }

        $tab['commentaire'] = mb_strimwidth($cd->getComment(),0,28,"...","UTF-8");

        if (empty($cd->getImg())) {
          $tab['editImg'] = $this->generateUrl('editCd', array('id' => $cd->getCd()));
        } else {
          $tab['img'] = $this->getRequest()->getUriForPath('/'.$cd->getImgWebPath());
        }

        $response = new JsonResponse();
        $response->setData($tab);
        return $response;

    }

    /**
     * @Route("/cd/retourLabel/page/{page}", name="retourLabel")
     */
    public function retourLabelAction(Request $request, $page=1)
    {
        $this->denyAccessUnlessGranted('ROLE_PROGRA', null, 'Seuls les programmateurs peuvent accéder à cette page.');

        $em = $this->getDoctrine()->getManager();
        $rq = $request->request;
        $limit = $this->container->getParameter('listinglimit');
        $from = $this->container->getParameter('retourLabelFromAddress');
        $erreurs = array();

        $retours = $rq->get('check_retour');


        if($request->isMethod('POST') && !empty($retours)) {
            $nbRetours = 0;
            foreach ($retours as $key => $retour) {
                $mail_retour = $rq->get('mail_retour')[$key];

                $cd = $em->getRepository('AppBundle:Cd')->find($key);

                if(!empty($mail_retour)) {

                    $airplay_cd = $em->getRepository('AppBundle:AirplayCd')->findByCd($cd);
                    $destinataires = explode(';', $mail_retour);

                    $mailer = $this->get('mailer');

                    $message = $mailer->createMessage()
                        ->setSubject("Retour d'écoute Radio Campus Grenoble / ".$cd->getArtiste()->getLibelle()." - ".$cd->getTitre())
                        ->setFrom($from)
                        ->setTo($destinataires)
                        ->setBody(
                          $this->renderView('mails/retour-label.txt.twig', array('cd' => $cd, 'airplays' => $airplay_cd)),
                          'text/plain'
                        );

                    if($mailer->send($message, $failures)) {
                        $cd->setRetourMail($mail_retour);
                        $cd->setRetourLabel(true);
                        $nbRetours++;
                    } else {
                        foreach($failures as $fail) {
                          $erreurs[$cd->getCd()] = $fail;
                        }
                    }

                } else {
                    $this->addFlash('error','Aucune adresse renseignée pour le disque #'.$cd->getCd().'.');
                }
            }

            if (!empty($erreurs)) {
              foreach($erreurs as $numCd => $erreur) {
                $this->addFlash('error',"L'adresse $erreur n'a pas pour fonctionné pour le disque $numCd.");
              }
            }

            $this->discoLog("a effectué ".$nbRetours." retours Label.");
            $this->addFlash('success',$nbRetours.' retour(s) Label effectué(s) avec succès.');

            $em->flush();
        }


        if($page < 1) { $page=1; }

        $date_mini = $this->dateMini($rq->get('date_mini'));

        if($rq->get('annee_mini')) {
            $annee_mini = $rq->get('annee_mini');
        } else {
            $annee_mini = date("Y")-1;
        }
        $label = $rq->get('label');
        $tout_voir = $rq->get('tout_voir');
        $label_mail = $rq->get('label_mail');
        $retour_fait = $rq->get('retour_fait');

        if($tout_voir) {
            $cds = $em->createQueryBuilder()
                ->select('cd')
                ->from('AppBundle:Cd', 'cd')
                ->orderBy('cd.cd', 'DESC')
                ->setFirstResult(($page-1)*$limit)
                ->setMaxResults(50)
                ->getQuery()
                ->getResult();

            $nbRes = $em->createQueryBuilder()
                ->select('count(cd)')
                ->from('AppBundle:Cd', 'cd')
                ->getQuery()
                ->getSingleScalarResult();

        } else {
            $cds = $em->createQueryBuilder()
                ->select('cd')
                ->from('AppBundle:Cd', 'cd')
                ->leftJoin('AppBundle:Label', 'l', 'WITH', 'l.label = cd.label')
                ->where('l.libelle LIKE :label')
                ->setParameter('label', '%'.$label.'%')
                ->andWhere('cd.dsaisie >= :dsaisie')
                ->setParameter('dsaisie', $date_mini)
                ->andWhere('cd.annee >= :annee')
                ->setParameter('annee', $annee_mini);
            if (!$retour_fait) {
                $cds = $cds->andWhere('cd.retourLabel = 0');
            }
            if($label_mail) {
                $cds = $cds->andWhere($cds->expr()->isNotNull('l.mailProgra'));
            }

            $cds = $cds->orderBy('cd.cd', 'DESC')
                ->setFirstResult(($page-1)*$limit)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

            $nbRes = $em->createQueryBuilder()
                ->select('count(cd)')
                ->from('AppBundle:Cd', 'cd')
                ->leftJoin('AppBundle:Label', 'l', 'WITH', 'l.label = cd.label')
                ->where('l.libelle LIKE :label')
                ->setParameter('label', '%'.$label.'%')
                ->andWhere('cd.dsaisie >= :dsaisie')
                ->setParameter('dsaisie', $date_mini)
                ->andWhere('cd.annee >= :annee')
                ->setParameter('annee', $annee_mini);
            if (!$retour_fait) {
                $nbRes = $nbRes->andWhere('cd.retourLabel = 0');
            }
            if($label_mail) {
                $nbRes = $nbRes->andWhere($nbRes->expr()->isNotNull('l.mailProgra'));
            }
            $nbRes = $nbRes->getQuery()
                ->getSingleScalarResult();
        }

        $pageMax = ceil($nbRes/$limit);

        return $this->render('cd/retour-label.html.twig',array(
                'cds'=>$cds,
                'date_mini' => $date_mini,
                'annee_mini' => $annee_mini,
                'label' => $label,
                'tout_voir' => $tout_voir,
                'label_mail' => $label_mail,
                'retour_fait' => $retour_fait,
                'page' => $page,
                'pageMax' => $pageMax
            ));
    }

    /**
     * Création d'une date minimale
     */
    private function dateMini($date_mini)
    {
        if(!empty($date_mini)) {
            return substr($date_mini,6,4).'-'.substr($date_mini,3,2).'-'.substr($date_mini,0,2);
        } else {
            return date("Y-m-d", mktime(0,0,0,date("m")-3, date("d"), date("Y")));
        }
    }


    /**
     * @Route("/cd/etiquettes", name="listeEtiquettes")
     */
    public function listeEtiquettesAction()
    {
        return $this->render('cd/liste-etiquettes.html.twig');
    }

    /**
     * @Route("/cd/etiquettes/generate", name="generateEtiquettes")
     */
    public function generateEtiquettesAction(Request $request)
    {
        $liste = $request->request->get('liste_etiquettes');

        if ($request->isMethod('POST') && !empty($liste)) {
            $etiquettes = explode(',', $liste);
            $cds = array();
            $IDs = '';

            foreach ($etiquettes as $key => $etiquette) {
                $cd = $this->getDoctrine()->getManager()->getRepository('AppBundle:Cd')->find($etiquette);
                if($cd) {
                    $cds[] = $cd;
                    $IDs .= ', '.$cd->getCd();
                }
            }

            $pdf = new \FPDF();
            $pdf->SetAutoPageBreak(false, 0);

            $logo = __DIR__.DIRECTORY_SEPARATOR.$this->container->getParameter('upload_root_dir').DIRECTORY_SEPARATOR."css/campusGrenoble.png";

            foreach ($cds as $key => $cd) {
                if ($key % 24 == 0) {
                    $pdf->addPage();
                }

                $pdf->setXY(($key%3)*70+6,floor($key%24/3)*37+1);
                $pdf->setTextColor(0,0,0);

                $pdf->SetFont('Arial','B',12);
                $titre = mb_strimwidth(utf8_decode($cd->getTitre()),0,28,"...");
                $pdf->Cell(60, 10, $titre);

                $pdf->SetFont('Arial','',10);
                $pdf->setXY(($key%3)*70+6,floor($key%24/3)*37+5);
                $artiste = mb_strimwidth(utf8_decode($cd->getArtiste()->getLibelle()),0,28,"...");
                $pdf->Cell(60, 10, $artiste);

                $label = '';
                $sep = '';
                if($cd->getLabel()) {
                    $label .= $cd->getLabel()->getLibelle();
                    $sep = ' / ';
                }
                if ($cd->getMaison()) {
                    $label .= $sep.$cd->getMaison()->getLibelle();
                    $sep = ' / ';
                }
                if ($cd->getDistrib()) {
                    $label .= $sep.$cd->getDistrib()->getLibelle();
                    $sep = ' / ';
                }
                if (!empty($label)) {
                    $label = mb_strimwidth(utf8_decode($label),0,32,"...");
                    $pdf->SetFont('Arial','',8);
                    $pdf->setXY(($key%3)*70+6,floor($key%24/3)*37+8);
                    $pdf->Cell(60,10,$label);
                }

                $pdf->setXY(($key%3)*70+7,floor($key%24/3)*37+15);
                $pdf->Cell(32,18,"","LTB");
                $pdf->SetFont('Arial','',7);

                $pdf->setXY(($key%3)*70+7.5,floor($key%24/3)*37+17);
                if($cd->getRotation()) {
                    $pdf->Cell(20,3,"Rotation : ".utf8_decode($cd->getRotation()->getLibelle()));
                } else {
                    $pdf->Cell(20,3,"Rotation : ");
                }

                $pdf->setXY(($key%3)*70+7.5,floor($key%24/3)*37+21);
                $rivendell = "Rivendell : ";
                foreach ($cd->getPistes() as $piste) {
                    if($piste->getRivendell()) { $rivendell .= $piste->getPiste()." "; }
                }
                $pdf->Cell(20,3,$rivendell);

                $pdf->setXY(($key%3)*70+7.5,floor($key%24/3)*37+25);
                if($cd->getLangue()) {
                    $pdf->Cell(20,3,utf8_decode($cd->getLangue()->getLibelle()));
                }

                $pdf->setXY(($key%3)*70+7.5,floor($key%24/3)*37+29);
                if($cd->getGenre()) {
                    $pdf->Cell(20,3,utf8_decode($cd->getGenre()->getLibelle()));
                }

                $pdf->SetFont('Arial','B',16);
                $pdf->setXY(($key%3)*70+38,floor($key%24/3)*37+15);
                $pdf->Cell(32,6,$cd->getCd());

                $pdf->setXY(($key%3)*70+40,floor($key%24/3)*37+26);
                $pdf->Image($logo,null,null,25);
            }

            $response = new Response($pdf->Output('', 'S'));

            $response->headers->set('Content-Type', 'application/pdf');
            $d = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                'etiquettes.pdf'
            );
            $response->headers->set('Content-Disposition', $d);

            return $response;

        } else {
            $this->addFlash('error','Les étiquettes n\'ont pas pu être générées.');
            return $this->redirect($this->generateUrl('listeEtiquettes'));
        }
    }

    /**
     * @Route("/cd/{cd}/rivendellInfo", name="rivendellInfo")
     */
    public function rivendellInfo(Request $request, $cd)
    {
      $em = $this->getDoctrine()->getManager();
      $cd = $em->getRepository('AppBundle:Cd')->find($cd);

      if ($cd) {
        $artistCD = $cd->getartiste()->getLibelle();

        $scheduler_codes = [$cd->getGenre()->getSchedulerCode()];

        foreach ($cd->getStyles() as $key => $genre) {
          $scheduler_codes[] = $genre->getSchedulerCode();
        }

        $scheduler_codes = array_values(array_unique($scheduler_codes));
        $pistes = array();

        foreach ($cd->getPistes() as $key => $piste) {
          $pistes[$piste->getPiste()] = array(
            "title" => $piste->getTitre(),
            "artist" => $piste->getArtiste() ? $piste->getArtiste()->getLibelle() : $artistCD,
            "rivendell" => $piste->getRivendell()
          );
        }

        $retour = array(
          "artist" => $artistCD,
          "title" => $cd->getTitre(),
          "scheduler_codes" => $scheduler_codes,
          "tracks" => $pistes
        );
      } else {
        $retour = array();
      }

      $response = new JsonResponse();
      $response->setData($retour);
      return $response;
    }
}
