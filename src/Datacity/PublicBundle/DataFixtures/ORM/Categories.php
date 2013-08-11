<?php 
namespace Datacity\PublicBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\Category;
 
class Categories implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $noms = array('Culture', 'Itinéraire', 'Tourisme', 'Évènement', 'Concerts', 'Musique', 'Cinémas');
 
    foreach($noms as $i => $name)
    {
      $liste_categories[$i] = new Category();
      $liste_categories[$i]->setName($name);
 
      //$manager->persist($liste_categories[$i]);
    }
 
    //->flush();
  }
  
}
?>