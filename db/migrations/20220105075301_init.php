<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

/**
 * Creates initial state of the data scheme
 */
final class Init extends AbstractMigration
{
    public function change(): void
    {
        $this
            ->table('book', ['id' => false, 'primary_key' => ['book_id']])
            ->addColumn('book_id', 'integer', ['identity' => true])
            ->addColumn('title', 'string', ['limit' => 255])
            ->addColumn('isbn', 'char', ['limit' => 13, 'null' => true])
            ->addColumn('published', 'datetime')
            ->addColumn('language_id', 'integer')
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('changed', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['isbn'], ['name' => 'i_isbn', 'unique' => true])
            ->create();
        $this
            ->table('language', ['id' => false, 'primary_key' => ['language_id']])
            ->addColumn('language_id', 'integer', ['identity' => true])
            ->addColumn('name', 'string', ['limit' => 100])
            ->addColumn('locale', 'char', ['limit' => 16])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('changed', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['locale'], ['name' => 'i_locale', 'unique' => true])
            ->create();
        $this
            ->table('author', ['id' => false, 'primary_key' => ['author_id']])
            ->addColumn('author_id', 'integer', ['identity' => true])
            ->addColumn('first_name', 'string', ['limit' => 100])
            ->addColumn('last_name', 'string', ['limit' => 100])
            ->addColumn('email', 'string', ['limit' => 100])
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('changed', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->create();
        $this
            ->table('book_author')
            ->addColumn('book_id', 'integer')
            ->addColumn('author_id', 'integer')
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
