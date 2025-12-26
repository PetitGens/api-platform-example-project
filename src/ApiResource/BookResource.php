<?php

namespace App\ApiResource;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Book;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
  shortName: 'Book',
  stateOptions: new Options(Book::class),
  normalizationContext: ['groups' => 'book'],
  operations: [
    new GetCollection(),
    new Get(),
  ],
)]
class BookResource
{
  #[Groups('book')]
  public int $id;

  #[Groups('book')]
  public string $title;
}
