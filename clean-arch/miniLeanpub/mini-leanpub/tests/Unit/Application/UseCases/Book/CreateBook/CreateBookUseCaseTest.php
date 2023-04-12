<?php

namespace Test\MiniLeanpub\Unit\Application\UseCases\Book\CreateBook;

use App\Models\Book;
use PHPUnit\Framework\TestCase;
use MiniLeanpub\Application\UseCases\Book\CreateBook\CreateBookUseCase;
use MiniLeanpub\Application\UseCases\Book\CreateBook\DTO\{BookCreateInputDTO, BookCreateOutputDTO};
use MiniLeanpub\Infrastructure\Repository\Book\BookEloquentRepository;

class CreateBookUseCaseTest extends TestCase
{
    public function test_should_create_a_new_book_via_use_case()
    {
        $repository = $this->getRepositoryMock();

        $input = new BookCreateInputDTO('d156c4f7-d855-4abe-be29-42d4742f9092', 'My First Book', 'Description of my first book', 26.90, 'book_path', 'text/markdown');
        $useCase = new CreateBookUseCase($input, $repository);
        $result = $useCase->handle();

        $this->assertInstanceOf(BookCreateOutputDTO::class, $result);

        $data = $result->getData();

        $this->assertEquals('d156c4f7-d855-4abe-be29-42d4742f9092', $data['id']);
        $this->assertEquals('My First Book', $data['title']);
    }

    private function getRepositoryMock()
    {
        $return = new \stdClass();
        $return->id = 'd156c4f7-d855-4abe-be29-42d4742f9092';
        $return->title = 'My First Book';
        $return->description = 'Description of my first book';
        $return->price = 25.90;
        $return->book_path = 'book_path';

        $model = $this->createMock(Book::class);
        $mock = $this->getMockBuilder(BookEloquentRepository::class)
            ->onlyMethods(['create'])
            ->setConstructorArgs([$model])
            ->getMock();

        $mock->expects($this->once())
            ->method('create')
            ->willReturn($return);

        return $mock;
    }
}
