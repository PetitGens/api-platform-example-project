<?php

namespace App\ApiResource;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Entity\Book;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
  shortName: 'Book',
  stateOptions: new Options(Book::class),
  normalizationContext: ['groups' => ['book', 'author']],
  denormalizationContext: ['groups' => 'book:write'],
  operations: [
    new GetCollection(),
    new Post(),
    new Get(),
  ],
)]
#[Map(source: Book::class)]
#[Map(target: Book::class)]
class BookResource
{
  #[Groups('book')]
  public int $id;

  #[Groups(['book', 'book:write'])]
  public string $title;

  #[Groups(['book', 'book:write'])]
  public AuthorResource $author;
}
