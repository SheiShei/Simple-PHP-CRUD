<?php

class Post extends BaseModel
{
    const TABLE_NAME = 'posts';

    public function __construct()
    {
        parent::__construct(self::TABLE_NAME);
    }
}