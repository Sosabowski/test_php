<?php

namespace Storage;

use Concept\Distinguishable;
use Config\Directory;

class FileStorage implements Storage
{
    public function store(Distinguishable $distinguishable): void
    {
        file_put_contents(Directory::storage() . $distinguishable->key(), serialize($distinguishable));
    }

    /**
     * @return Distinguishable[]
     */
    public function loadAll(): array
    {
        $ignored = ['..', '.', '.gitignore', 'db.sqlite'];

        $files = scandir(Directory::storage());

        if (!$files) {
            exit("Cannot scan director!");
        }

        $files = array_diff($files, $ignored);

        $result = [];

        foreach ($files as $file) {
            $contents = file_get_contents(Directory::storage() . $file);
            if (!$contents) {
                exit("Cannot get file contents!");
            }
            $object = unserialize($contents);
            if (!$object instanceof Distinguishable) {
                exit("Deserialized object is not a " . Distinguishable::class . "!");
            }
            $result[] = $object;
        }

        return $result;
    }
}
