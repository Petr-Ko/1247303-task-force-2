<?php

namespace TaskForce\classes\db;

class ImportCsv extends \SplFileObject
{
    public const AVAILABLE_TABLE_DB = [
        'categories',
        'cities'
    ];

    /**
    * Записывает данные из CSV-файла (экземпляра данного класса).
    * @param string $table_name Имя таблицы БД, в которую необходимо импортировать данные из файла CSV;
    */
    public function SetDataInDb(string $table_name):void
    {
        $table_name_available = in_array($table_name, $this::AVAILABLE_TABLE_DB);

        if($table_name_available === false) {
            print("'$table_name' - недоступимое наименование таблицы БД.");
            exit();
        }

        $title = $this->fgetcsv();

        $array_from_csv = [];

        while (!$this->eof()) {

            $one_line = array_combine($title, $this->fgetcsv());

            array_push($array_from_csv, $one_line);   
        }

        if($table_name === "categories") {

            foreach ($array_from_csv as $item) {
                $this->addCategorieInDb($item);
            }
        }

        if($table_name === "cities") {

            foreach ($array_from_csv as $item) {
                $this->addCityInDb($item);
            }

        }
    }

    private function addCityInDb(?array $data):void
    {
        $request = 
            "INSERT INTO 
                `cities` (
                    `name`, 
                    `location`
                ) 
                VALUES 
                (
                    '{$data['name']}', 
                    ST_GeomFromText('POINT({$data['lat']} {$data['long']})')
                )";
        $this->setRequestDb($request);
    }

    private function addCategorieInDb(?array $data):void
    {
        
        $request = 
            "INSERT INTO 
                `categories` (
                    `name`, 
                    `icon`
                ) 
                VALUES 
                (
                    '{$data['name']}',
                    '{$data['icon']}' 
                    
                )";

        $this->setRequestDb($request);
    }

    private function setRequestDb(string $request):void
    {
        $connect = mysqli_connect('localhost', 'root', '', 'task_force');

        if ($connect == false) {
            print("Ошибка подключения: " . mysqli_connect_error());
            exit();
        }

        $query =  mysqli_query($connect, $request);

        if ($query == false) {
            print("Ошибка запроса в БД: " .  mysqli_error($connection));
            exit();
        }

        print("Запись '$request' добавлена в БД;"."<br>" );
    }


}





















