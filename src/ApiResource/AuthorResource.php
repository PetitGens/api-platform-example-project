<?php

namespace App\ApiResource;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Author;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
  shortName: 'Author',
  stateOptions: new Options(Author::class),
  normalizationContext: ['groups' => 'author'],
  operations: [
    new GetCollection(),
    new Get(),
  ],
)]
#[Map(target: Author::class)]
class AuthorResource
{
  #[Groups('author')]
  public int $id;

  #[Groups('author')]
  public string $name;
}
