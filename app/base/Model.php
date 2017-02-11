<?php

namespace app\base;

//use app\base\IDatabase;
#use app\helpers\Db;

abstract class Model
{
    /** @var \app\base\IDatabase Класс для работы с БД. */
    protected $db;

    public function __construct()
    {
        #$this->setDBHandle(Db::obj());
    }

    /**
     * Установка класса для работы с БД.
     *
     * @param \app\base\IDatabase $db
     */
    protected function setDBHandle(IDatabase $db)
    {
        $this->db = $db;
    }

    /**
     * Возвращает названия полей.
     *
     * @return array
     */
    abstract public function attributeLabels();
}