<?php


namespace app\aopV1;


interface INews
{
    function editNews(int $newsId);

    function delNews(int $newsId);
}