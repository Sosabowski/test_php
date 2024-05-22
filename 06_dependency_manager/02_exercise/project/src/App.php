<?php

use Symfony\Component\Yaml\Yaml;
use Storage\Storage;
use Widget\Widget;
use Widget\Link;
use Widget\Button;

class App
{
    public function run(string $storageTypeName): void
    {
        $fullStorageTypeName = "\\Storage\\$storageTypeName";

        echo "Test for: $fullStorageTypeName<br/>";

        $storage = new $fullStorageTypeName();

        if (!$storage instanceof Storage) {
            exit("Storage type is invalid!");
        }
        /*
        $widgets = [
            new Link(1), new Link(2), new Link(3),
            new Button(1), new Button(2), new Button(3)
        ];
        */

        $widgets = [
            ['type' => 'Link', 'id' => 1],
            ['type' => 'Link', 'id' => 2],
            ['type' => 'Link', 'id' => 3],
            ['type' => 'Button', 'id' => 1],
            ['type' => 'Button', 'id' => 2],
            ['type' => 'Button', 'id' => 3]
        ];
        $yamlData = Yaml::dump($widgets);

        file_put_contents('widgets.yaml', $yamlData);

        $loadedWidgets = Yaml::parseFile('widgets.yaml');

        if (!is_array($loadedWidgets)) {
            exit("Failed to load widgets from YAML file.");
        }

        foreach ($loadedWidgets as $widgetData) {
            if (!is_array($widgetData)) {
                continue; // Pomijamy dane, które nie są tablicami
            }
            $widget = $this->createWidgetFromData($widgetData);
            if ($widget instanceof Widget) {
                $storage->store($widget);
            }
        }

        foreach ($storage->loadAll() as $distinguishable) {
            if ($distinguishable instanceof Widget) {
                $this->render($distinguishable);
            }
        }
    }

    private function createWidgetFromData(array $data): ?Widget
    {
        if (!isset($data['type']) || !isset($data['id'])) {
            return null; // Jeśli brakuje kluczowych danych, zwracamy null
        }
        switch ($data['type']) {
            case 'Link':
                return new Link($data['id']);
            case 'Button':
                return new Button($data['id']);
            default:
                return null;
        }
    }

    private function render(Widget $widget): void
    {
        $widget->draw();
    }
}
