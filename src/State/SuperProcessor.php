<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\AuthorRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class SuperProcessor implements ProcessorInterface
{
  public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private readonly ProcessorInterface $persistProcessor,
        private readonly AuthorRepository $authorRepository,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
      //TODO make this generic
      $data->setAuthor($this->authorRepository->find($data->getAuthor()->getId()));
      return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
