<?php

namespace App\ApiResource;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Book;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
  shortName: 'Book',
  stateOptions: new Options(Book::class),
  normalizationContext: ['groups' => ['book', 'author']],
  operations: [
    new GetCollection(),
    new Get(),
  ],
)]
#[Map(source: Book::class)]
class BookResource
{
  #[Groups('book')]
  public int $id;

  #[Groups('book')]
  public string $title;

  #[Groups('book')]
  public AuthorResource $author;
}
