<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\DataColumns;

//Hey ! Too much Data here again !
class DataColumnsData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		//Concerts en France
		$data = new DataColumns();
		$data->setName('Position');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[0])); //GeoPoint
		$data->setDataset($this->getReference('dataset-1'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Nom');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[1])); //Texte
		$data->setDataset($this->getReference('dataset-1'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Nombre de parcipants');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[2])); //Nombre
		$data->setDataset($this->getReference('dataset-1'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Date');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[3])); //Date
		$data->setDataset($this->getReference('dataset-1'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Adresse');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[4])); //Adresse
		$data->setDataset($this->getReference('dataset-1'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Durée en jours');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[2])); //Nombre
		$data->setDataset($this->getReference('dataset-1'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Commune');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[1])); //Texte
		$data->setDataset($this->getReference('dataset-1'));
		$manager->persist($data);

		//Batiments non résidentiels
		$data = new DataColumns();
		$data->setName('Zone');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[2])); //Nombre
		$data->setDataset($this->getReference('dataset-2'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Périmètre');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[2])); //Nombre
		$data->setDataset($this->getReference('dataset-2'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Position');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[0])); //GeoPoint
		$data->setDataset($this->getReference('dataset-2'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Nom');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[1])); //Texte
		$data->setDataset($this->getReference('dataset-2'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Commune');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[1])); //Texte
		$data->setDataset($this->getReference('dataset-2'));
		$manager->persist($data);

		//Résultats des élections européennes
		$data = new DataColumns();
		$data->setName('Date');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[3])); //Date
		$data->setDataset($this->getReference('dataset-3'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Commune');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[1])); //Texte
		$data->setDataset($this->getReference('dataset-3'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Bureau');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[1])); //Texte
		$data->setDataset($this->getReference('dataset-3'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Circonscription');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[2])); //Nombre
		$data->setDataset($this->getReference('dataset-3'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Canton');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[2])); //Nombre
		$data->setDataset($this->getReference('dataset-3'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Inscrits');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[2])); //Nombre
		$data->setDataset($this->getReference('dataset-3'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Votants');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[2])); //Nombre
		$data->setDataset($this->getReference('dataset-3'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Nuls');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[2])); //Nombre
		$data->setDataset($this->getReference('dataset-3'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Blancs');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[2])); //Nombre
		$data->setDataset($this->getReference('dataset-3'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Exprimés');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[2])); //Nombre
		$data->setDataset($this->getReference('dataset-3'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Procurations');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[2])); //Nombre
		$data->setDataset($this->getReference('dataset-3'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('No candidat');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[2])); //Nombre
		$data->setDataset($this->getReference('dataset-3'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Nom candidat');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[1])); //Texte
		$data->setDataset($this->getReference('dataset-3'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Nombre de voix');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[2])); //Nombre
		$data->setDataset($this->getReference('dataset-3'));
		$manager->persist($data);

		//Omnis iste
		$data = new DataColumns();
		$data->setName('Position');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[0])); //GeoPoint
		$data->setDataset($this->getReference('dataset-4'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Nom');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[1])); //Texte
		$data->setDataset($this->getReference('dataset-4'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Date');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[3])); //Date
		$data->setDataset($this->getReference('dataset-4'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Adresse');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[4])); //Adresse
		$data->setDataset($this->getReference('dataset-4'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Durée en jours');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[2])); //Nombre
		$data->setDataset($this->getReference('dataset-4'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Commune');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[1])); //Texte
		$data->setDataset($this->getReference('dataset-4'));
		$manager->persist($data);

		$manager->flush();
	}
	
	public function getOrder()
	{
		return 15;
	}
}
