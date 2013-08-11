<?php 
namespace Datacity\PublicBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\City;
 
class Cities implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $noms = array('Montpellier', 'Ales', 'Nimes', 'Paris', 'Lyon', 'Catalogne (village)');
 
    foreach($noms as $i => $name)
    {
      $liste_cities[$i] = new City();
      $liste_cities[$i]->setName($name);
 
      $manager->persist($liste_cities[$i]);
    }
 
    $manager->flush();
  }
  
}
?>