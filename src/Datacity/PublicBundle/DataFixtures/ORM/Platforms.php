<?php 
namespace Datacity\PublicBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\Platform;
 
class platforms implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $noms = array('iOS', 'Android', 'Windows Phone', 'Blackberry');
 	$versions = array('7.0', '4.3', '7.8', '7.1');
    foreach($noms as $i => $name)
    {
      $liste_platforms[$i] = new Platform();
      $liste_platforms[$i]->setName($name);
      $liste_platforms[$i]->setVersion($versions[$i]);
      //$manager->persist($liste_platforms[$i]);
    }
 
    //$manager->flush();
  }
}
?>