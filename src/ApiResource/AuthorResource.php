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
    operations: [
      new GetCollection(),
      new Get(),
    ],
    normalizationContext: ['groups' => 'author'],
    stateOptions: new Options(Author::class),
)]
#[Map(target: Author::class)]
class AuthorResource
{
  #[Groups('author')]
  public int $id;

  #[Groups('author')]
  public string $name;
}
