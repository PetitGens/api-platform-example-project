<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\AssociationMapping;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ReloadDetachedRelationshipsPersistProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private readonly ProcessorInterface $persistProcessor,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $this->reloadDetachedSubentities($data);

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }

    private function reloadDetachedSubEntities(mixed $entity): void
    {
        /**
         * @var ClassMetadata
         */
        $metadata = $this->entityManager->getMetadataFactory()->getMetadataFor($entity::class);
        $associations = $metadata->getAssociationMappings();

        /**
         * @var AssociationMapping[] ManyToOne or OneToOne
         */
        $toOneAssociations = \array_filter($associations, static fn (AssociationMapping $as): bool => $as->isToOneOwningSide());
        $fieldNames = \array_map(static fn (AssociationMapping $as): string => $as->fieldName, $toOneAssociations);

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $subEntities = \array_map(
            fn ($fieldName) => $propertyAccessor->getValue($entity, $fieldName),
            $fieldNames,
        );

        // Replace every relationship by an Entity obtained from its Repository
        foreach ($subEntities as $key => $subEntity) {
            if (null === $subEntity) {
                continue;
            }
            $repository = $this->entityManager->getRepository($subEntity::class);
            $propertyAccessor->setValue(
                $entity,
                $fieldNames[$key],
                $repository->find($subEntity->getId()),
            );
        }
    }
}
