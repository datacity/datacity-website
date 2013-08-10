<?php 
namespace Datacity\PublicBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\Platform;
 
class platforms implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $noms = array('iOS', 'Android', 'Windows Phone', 'Blackberry');
 	$versions = array('7.0', '4.3', '7.8', '7.1');
    foreach($noms as $i => $name)
    {
      // On crée la catégorie
      $liste_platforms[$i] = new Platform();
      $liste_platforms[$i]->setName($name);
      $liste_platforms[$i]->setVersion($versions[$i]);
      // On la persiste
      $manager->persist($liste_platforms[$i]);
    }
 
    // On déclenche l'enregistrement
    $manager->flush();
  }
}
?>