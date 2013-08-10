<?php 
namespace Datacity\PublicBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\Category;
 
class Categories implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $noms = array('Culture', 'Itinéraire', 'Tourisme', 'Évènement', 'Concerts', 'Musique', 'Cinémas');
 
    foreach($noms as $i => $name)
    {
      // On crée la catégorie
      $liste_categories[$i] = new Category();
      $liste_categories[$i]->setName($name);
 
      // On la persiste
      $manager->persist($liste_categories[$i]);
    }
 
    // On déclenche l'enregistrement
    $manager->flush();
  }
  
}
?>