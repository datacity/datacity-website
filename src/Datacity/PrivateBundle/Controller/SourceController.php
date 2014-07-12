<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Datacity\PublicBundle\Entity\DSource;
use Datacity\PublicBundle\Entity\Dataset;

class SourceController extends Controller
{
    private function thereIsAProblemHere() {
        return new JsonResponse(array('action' => 'failure'), 400);
    }

    public function saveAction(Request $request, Dataset $dataset) {
        $content = $request->getContent();
        if (!empty($content)) {
            $params = json_decode($content);

            $source = new DSource();
            $source->setTitle($params->metadata->title);
            $source->setSid($params->metadata->sid);
            $source->setLink($params->metadata->link);

            $freq = $this->getDoctrine()->getRepository("DatacityPublicBundle:Frequency")->findByName($params->metadata->frequency);
            $source->setFrequency($freq);

            $place = $this->getDoctrine()->getRepository("DatacityPublicBundle:Place")->findByName($params->metadata->location);
            $source->setPlace($place);

            $coverage = $this->getDoctrine()->getRepository("DatacityPublicBundle:CoverageTerritory")->findByName($params->metadata->coverageTerritory);
            $source->setCoverageTerritory($coverage);

            $source->setDataset($dataset);
            $catRepo = $this->getDoctrine()->getRepository("DatacityPublicBundle:Category");
            if (count($params->metadata->category) > $catRepo->getCount())
                return $this->thereIsAProblemHere();
            foreach ($params->metadata->category as $cat) {
                $category = $catRepo->findByName($cat);
                $qb = $this->getDoctrine()->getRepository('DatacityPublicBundle:Dataset')->createQueryBuilder('d');
                $res = $qb->where($qb->expr()->eq('d.id', ':datasetId'))
                        ->setParameter('datasetId', $dataset.getId())
                        ->leftJoin('d.category', 'c', Expr\Join::WITH, $qb->expr()->eq('cat.id', ':categoryId'))
                        ->setParameter('categoryId', $category.getId())
                        ->getQuery()->getOneOrNullResult();
                if ($res == null)
                    $dataset->addCategory($category);
            }
            $em->persist($dataset);

            //FIXME $source->setProducer(); MISSING

            $em = $this->getDoctrine()->getManager();
            $em->persist($source);

            $types = [];
            foreach ($params->dataModel as $column) {
                $data = new DataColumns();
                $data->setName($column->name);

                if (!array_key_exists($column->type->name, $types)) {
                    $types[$column->type->name] = $this->getDoctrine()->getRepository("DatacityPublicBundle:DataColumnsType")
                                                                    ->findByName($column->type->name);
                }
                $data->setType($types[$column->type->name]);

                $data->setDataset();
                $em->persist($data);
            }

            $em->flush();
            $response = new JsonResponse(array('action' => 'success'));
        } else {
            return $this->thereIsAProblemHere();
        }
        return $response;
    }
}