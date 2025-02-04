<?php

namespace App\Handler;

use App\Contract\GetObservationsQueryInterface;
use App\Contract\ObservationRepositoryInterface;
use App\Entity\Observation;
use App\ValueObject\Pagination;
use App\Response\GetResourcesResponse;
use App\Response\ObservationResponse as ResponseModel;

class GetObservationsHandler
{
    public function __construct(
        private readonly ObservationRepositoryInterface $observationRepository
    ) {}

    public function __invoke(GetObservationsQueryInterface $query): GetResourcesResponse
    {
        $pagination = $query->pagination ?? new Pagination();
        $observations = \array_map(
            fn(Observation $observation) => new ResponseModel($observation->getUuid(), $observation->getName()),
            $this->observationRepository->findAllForList($pagination)
        );

        return new GetResourcesResponse($observations, $pagination);
    }
}
