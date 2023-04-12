<?php

namespace App\Jobs\Book;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Storage;
use MiniLeanpub\Infrastructure\Service\BookConverter\BookConverterService;

class ConvertBookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $bookCode)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $chapters = Storage::disk('books')->allFiles($this->bookCode . '/chapters');

        $chapters = array_map(fn($line) => storage_path('app/books/' . $line), $chapters);

        $converter = new BookConverterService($chapters, storage_path('app/books/' . $this->bookCode));

        $converter->makeConversion();
    }
}
