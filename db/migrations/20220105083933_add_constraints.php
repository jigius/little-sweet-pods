<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

/**
 * Adds constraints on the data scheme
 */
final class AddConstraints extends AbstractMigration
{
    public function change(): void
    {
        $this
            ->table('book')
            ->addForeignKey(
                'language_id',
                'language',
                'language_id',
                [
                    'delete' => 'NO_ACTION',
                    'update' => 'NO_ACTION',
                    'constraint' => 'FK_book_language'
                ]
            )
            ->save();
        $this
            ->table('book_author')
            ->addForeignKey(
                'book_id',
                'book',
                'book_id',
                [
                    'delete' => 'NO_ACTION',
                    'update' => 'NO_ACTION',
                    'constraint' => 'FK_bookauthor_book'
                ]
            )
            ->addForeignKey(
                'author_id',
                'author',
                'author_id',
                [
                    'delete' => 'NO_ACTION',
                    'update' => 'NO_ACTION',
                    'constraint' => 'FK_bookauthor_author'
                ]
            )
            ->save();
    }
}
