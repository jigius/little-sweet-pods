<?php

use Phinx\Seed\AbstractSeed;

class Init extends AbstractSeed
{
    const AUTHORS_COUNT = 20;
    const BOOKS_COUNT = 10;

    private array $lang = [
        [
            'name' => 'English',
            'locale' => 'en_US'
        ],
        [
            'name' => 'French',
            'locale' => 'fr_FR'
        ],
        [
            'name' => 'Russian',
            'locale' => 'ru_RU'
        ],
        [
            'name' => 'Deutsch',
            'locale' => 'de_DE'
        ]
    ];

    public function run()
    {
        $this->getAdapter()->beginTransaction();
        try {
            $this->seedsLanguage();
            $this->seedsAuthor();
            $this->seedsBook();
            $this->seedsBookAuthor();
            $this->getAdapter()->commitTransaction();
        } catch (Throwable $ex) {
            $this->getAdapter()->rollbackTransaction();
            throw $ex;
        }
    }

    private function seedsLanguage()
    {
        $conn = $this->getAdapter()->getConnection();
        array_walk(
            $this->lang,
            function ($value, $index) use ($conn) {
                $sql = [
                    "INSERT INTO `language`",
                        "(`language_id`, `name`, `locale`)",
                    "VALUES",
                        "(%d, %s, %s)"
                ];
                $this->execute(
                    sprintf(
                        implode(" ", $sql),
                        $conn->quote($index + 1, PDO::PARAM_INT),
                        $conn->quote($value['name'], PDO::PARAM_STR),
                        $conn->quote($value['locale'], PDO::PARAM_STR)
                    )
                );
            }
        );
    }

    private function seedsAuthor()
    {
        $conn = $this->getAdapter()->getConnection();
        foreach ($this->lang as $idx => $lang) {
            $faker = Faker\Factory::create($lang['locale']);
            for ($i = 0; $i < self::AUTHORS_COUNT; $i++) {
                $sql = [
                    "INSERT INTO `author`",
                        "(`author_id`, `first_name`, `last_name`, `email`)",
                    "VALUES",
                        "(%d, %s, %s, %s)"
                ];
                if (rand() % 2 === 0) {
                    $gender = "male";
                } else {
                    $gender = "female";
                }
                $this->execute(
                    sprintf(
                        implode(" ", $sql),
                        $conn->quote($idx * self::AUTHORS_COUNT + $i + 1, PDO::PARAM_INT),
                        $conn->quote($faker->firstName($gender), PDO::PARAM_STR),
                        $conn->quote($faker->lastName($gender), PDO::PARAM_STR),
                        $conn->quote($faker->safeEmail(), PDO::PARAM_STR)
                    )
                );
            }
        }
    }

    private function seedsBook()
    {
        $conn = $this->getAdapter()->getConnection();
        foreach ($this->lang as $idx => $lang) {
            $faker = Faker\Factory::create($lang['locale']);
            for ($i = 0; $i < self::BOOKS_COUNT; $i++) {
                $sql = [
                    "INSERT INTO `book`",
                        "(`book_id`, `title`, `isbn`, `language_id`, `published`)",
                    "VALUES",
                        "(%s, %s, %s, %s, %s)"
                ];
                $this->execute(
                    sprintf(
                        implode(" ", $sql),
                        $conn->quote($idx * self::BOOKS_COUNT + $i + 1, PDO::PARAM_INT),
                        $conn->quote($faker->realText(40), PDO::PARAM_STR),
                        $conn->quote($faker->isbn13(), PDO::PARAM_STR),
                        $conn->quote($idx + 1, PDO::PARAM_INT),
                        $conn->quote($faker->dateTimeBetween()->format("Y-m-d H:i:s"), PDO::PARAM_STR)
                    )
                );
            }
        }
    }

    private function seedsBookAuthor()
    {
        $conn = $this->getAdapter()->getConnection();
        $sql = [
            "INSERT INTO `book_author`",
                "(`book_id`, `author_id`)",
            "VALUES",
                "(%s, %s)"
        ];
        foreach ($this->lang as $idx => $lang) {
            $qnty = rand(floor(self::BOOKS_COUNT/2), self::BOOKS_COUNT);
            $books = [];
            while (count($books) < $qnty) {
                do {
                    $id = $idx * self::BOOKS_COUNT + rand(1, self::BOOKS_COUNT);
                } while (in_array($id, $books));
                $books[] = $id;
            }
            foreach ($books as $bid) {
                $authors = [];
                $qnty = rand(1, 3);
                while (count($authors) < $qnty) {
                    do {
                        $id = $idx * self::AUTHORS_COUNT + rand(1, self::AUTHORS_COUNT);
                    } while (in_array($id, $authors));
                    $authors[] = $id;
                }
                foreach ($authors as $aid) {
                    $this->execute(
                        sprintf(
                            implode(" ", $sql),
                            $conn->quote($bid, PDO::PARAM_INT),
                            $conn->quote($aid, PDO::PARAM_INT)
                        )
                    );
                }
            }
        }
    }
}

