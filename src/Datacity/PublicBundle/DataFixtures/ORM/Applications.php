<?php 
namespace Datacity\PublicBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\Application;
 
class Applications implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $noms = array('Datacity Culture', 'Datacity Tourism', 'Datacity Street', 'Datacity Inch\'Allah');
    $downs = array(52, 1304, 422, 9999999);
    $descs = array("Application de référencement des principaux lieux culturels", "Application de référencement des principaux lieux touritiques", "Application de référencement des principales rues. ^^", "Application de référencement des principaux coins a eviter. <3");
 
    foreach($noms as $i => $name)
    {
      // On crée la catégorie
      $liste_apply[$i] = new Application();
      $liste_apply[$i]->setName($name);
      $liste_apply[$i]->setDownloaded($downs[$i]);
      $liste_apply[$i]->setDescription($descs[$i]);
      // On la persiste
      $manager->persist($liste_apply[$i]);
    }
 
    // On déclenche l'enregistrement
    $manager->flush();
  }
}
?>