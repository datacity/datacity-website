<?php 
namespace Datacity\PublicBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\Customer;
 
class customers implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $noms = array('Montpellier Mairie', 'Paris Mairie');
 	$cities = array('Montpellier', 'Paris');
 	$cfn = array('Alfred', 'Francois');
 	$cln = array('Lecatalan', 'Hollande');
 	$cm = array('al@gmail.com', 'fh@gmail.com');
 	$cp = array('0658698754', '0812458652');
 	$s = array('1545456465123', '546546846654');
    foreach($noms as $i => $name)
    {
      // On crée la catégorie
      $liste_customers[$i] = new Customer();
      $liste_customers[$i]->setName($name);
      $liste_customers[$i]->setContactFirstName($cfn[$i]);
      $liste_customers[$i]->setContactLastName($cln[$i]);
      $liste_customers[$i]->setContactMail($cm[$i]);
      $liste_customers[$i]->setContactPhone($cp[$i]);
      $liste_customers[$i]->setSiret($s[$i]);
      // On la persiste
  //    $manager->persist($liste_customers[$i]);
    }
 
    // On déclenche l'enregistrement
//    $manager->flush();
  }
}
?>
