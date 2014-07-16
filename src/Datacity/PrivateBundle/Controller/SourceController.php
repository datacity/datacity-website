<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Datacity\PublicBundle\Entity\DSource;
use Datacity\PublicBundle\Entity\Dataset;
use Datacity\PublicBundle\Entity\Place;
use Datacity\PublicBundle\Entity\DataColumns;
use Doctrine\ORM\Query\Expr;

class SourceController extends Controller
{
    private function thereIsAProblemHere($error = 'failure') {
        return new JsonResponse(array('error' => $error), 400);
    }

    public function saveAction(Request $request, Dataset $dataset) {
        $content = $request->getContent();
        if (!empty($content)) {
            $params = json_decode($content);
            if (!$params)
                return $this->thereIsAProblemHere();

            if (!isset($params->metadata) || !isset($params->metadata->title) ||
                !isset($params->metadata->frequency) || !isset($params->metadata->location) ||
                !isset($params->metadata->coverageTerritory) || !isset($params->metadata->category))
                return $this->thereIsAProblemHere();

            $em = $this->getDoctrine()->getManager();

            //FIXME setSlug here
            $source = new DSource();
            $source->setTitle($params->metadata->title);
            if (isset($params->metadata->link))
                $source->setLink($params->metadata->link);

            $datasetRepo = $this->getDoctrine()->getRepository("DatacityPublicBundle:Dataset");

            $freq = $this->getDoctrine()->getRepository("DatacityPublicBundle:Frequency")->findOneByName($params->metadata->frequency);
            if (!$freq)
                return $this->thereIsAProblemHere('Unknown frequency "' . $params->metadata->frequency .'"');
            $source->setFrequency($freq);
            $datasetRepo->setLowestFrequency($dataset, $freq);

            $place = $this->getDoctrine()->getRepository("DatacityPublicBundle:Place")->findOneByName($params->metadata->location);
            if (!$place)
            {
                $place = new Place();
                $place->setName($params->metadata->location);
                $em->persist($place);
            }
            $source->setPlace($place);
            $datasetRepo->addUniquePlace($dataset, $place);

            $coverage = $this->getDoctrine()->getRepository("DatacityPublicBundle:CoverageTerritory")->findOneByName($params->metadata->coverageTerritory);
            if (!$coverage)
                return $this->thereIsAProblemHere('Unknown coverageTerritory "' . $params->metadata->coverageTerritory .'"');
            $source->setCoverageTerritory($coverage);
            $datasetRepo->setBiggestCoverageTerritory($dataset, $coverage);

            $datasetRepo->addUniqueContrib($dataset, $this->getUser());

            $source->setDataset($dataset);
            $catRepo = $this->getDoctrine()->getRepository("DatacityPublicBundle:Category");
            if (count($params->metadata->category) > $catRepo->getCount())
                return $this->thereIsAProblemHere('Invalid category list');

            $unkCat = $datasetRepo->addUniqueCategoriesByName($dataset, array_unique($params->metadata->category));
            if ($unkCat != null)
                $this->thereIsAProblemHere('Unknown category "' . $unkCat .'"');

            $em->persist($dataset);

            //FIXME Temporairement en dur
            $prod = $this->getDoctrine()->getRepository("DatacityPublicBundle:Producer")->findOneByName("Datacity");
            $source->setProducer($prod);

            $em->persist($source);

            $types = [];
            if (isset($params->dataModel)) {
                if ($dataset->getColumns()->count() > 0)
                    return $this->thereIsAProblemHere('Mapping already done for this dataset');
                foreach ($params->dataModel as $column) {
                    $data = new DataColumns();
                    $data->setName($column->name);

                    if (!array_key_exists($column->type, $types)) {
                        $types[$column->type] = $this->getDoctrine()->getRepository("DatacityPublicBundle:DataColumnsType")
                                                                        ->findOneByName($column->type);
                        if (!$types[$column->type])
                            return $this->thereIsAProblemHere('Unknown columnType"' . $column->type .'"');
                    }
                    $data->setType($types[$column->type]);

                    $data->setDataset($dataset);
                    $em->persist($data);
                }
            }

            $em->flush();
            $response = new JsonResponse(array('action' => 'success'));
        } else {
            return $this->thereIsAProblemHere();
        }
        return $response;
    }
}