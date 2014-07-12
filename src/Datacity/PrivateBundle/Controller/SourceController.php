<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Datacity\PublicBundle\Entity\DSource;
use Datacity\PublicBundle\Entity\Dataset;
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

            $source = new DSource();
            $source->setTitle($params->metadata->title);
            $source->setSid($params->metadata->sid);
            if (isset($params->metadata->link))
                $source->setLink($params->metadata->link);

            $freq = $this->getDoctrine()->getRepository("DatacityPublicBundle:Frequency")->findOneByName($params->metadata->frequency);
            if (!$freq)
                return $this->thereIsAProblemHere('Unknown frequency "' . $params->metadata->frequency .'"');
            $source->setFrequency($freq);

            $place = $this->getDoctrine()->getRepository("DatacityPublicBundle:Place")->findOneByName($params->metadata->location);
            if (!$place)
                return $this->thereIsAProblemHere('Unknown place "' . $params->metadata->location .'"');
            $source->setPlace($place);

            $coverage = $this->getDoctrine()->getRepository("DatacityPublicBundle:CoverageTerritory")->findOneByName($params->metadata->coverageTerritory);
            if (!$coverage)
                return $this->thereIsAProblemHere('Unknown coverageTerritory "' . $params->metadata->coverageTerritory .'"');
            $source->setCoverageTerritory($coverage);

            $source->setDataset($dataset);
            $catRepo = $this->getDoctrine()->getRepository("DatacityPublicBundle:Category");
            if (count($params->metadata->category) > $catRepo->getCount())
                return $this->thereIsAProblemHere('Invalid category list');
            $currentCategories = $dataset->getCategories();
            //TODO Probablement plus optimal en une requete SQL
            $cats = array_filter(
                array_unique($params->metadata->category),
                function ($e) use (&$currentCategories) {
                    foreach ($currentCategories as $cat) {
                        if ($cat->getName() === $e)
                            return false;
                    }
                    return true;
                }
            );
            foreach ($cats as $cat) {
                $category = $catRepo->findOneByName($cat);
                if (!$category)
                    return $this->thereIsAProblemHere('Unknown category "' . $cat .'"');
                $dataset->addCategory($category);
            }
            $em = $this->getDoctrine()->getManager();
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

                    if (!array_key_exists($column->type->name, $types)) {
                        $types[$column->type->name] = $this->getDoctrine()->getRepository("DatacityPublicBundle:DataColumnsType")
                                                                        ->findOneByName($column->type->name);
                        if (!$types[$column->type->name])
                            return $this->thereIsAProblemHere('Unknown columnType"' . $column->type->name .'"');
                    }
                    $data->setType($types[$column->type->name]);

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