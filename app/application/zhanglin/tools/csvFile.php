<?php


namespace app\application\zhanglin\tools;


class csvFile
{
    /**
     * @var string
     */
    private $csv_content;
    
    /**
     * @var string
     */
    private $csv_title_content;

    /**
     * @var array
     */
    private $titles;

    /**
     * @var array
     */
    private $lines;

    /**
     * @var string
     */
    private $csv_line_content;

    public function readCsvToArr($path): array
    {
        $data = file($path);
        $title = array_shift($data);
        $col_key_arr = explode(',', trim($title));
        foreach ($col_key_arr as &$col_key) {
            $col_key = trim($col_key);
            $col_key = trim($col_key, pack('H*', 'EFBBBF'));//移除BOM
        }
        unset($col_key);
        $arr = [];
        foreach ($data as $key => $value)
        {
            $line = explode(',', trim($value));
            foreach ($col_key_arr as $col => $item) {
                $arr[$key][$item] = $line[$col] ?? null;
            }
        }
        if (isset($key)){
            $this->setTitle(array_keys($arr[$key]));
            $this->setLines($arr);
        }
        return $arr;
    }

    public function writeToCsv($csv_name, $dir = null)
    {
        $path = sprintf('%s/%s', $this->meta_dir($dir), $this->csvName($csv_name));
        $this->setTitleContent();
        $this->setLinesContent();
        $this->csv_content = $this->csv_title_content . $this->csv_line_content;
        file_put_contents($path, $this->csv_content);
    }

    public function setTitle(array $titles)
    {
        $this->titles = $titles;
    }

    public function setLines(array $lines)
    {
        foreach ($lines as $line)
        {
            $this->setLine($line);
        }
    }







    protected function csvName($csv_name): string
    {
        return sprintf('%s.csv', $csv_name);
    }

    protected function meta_dir($dir): string
    {
        return '';
    }

    protected function setLine(array $line)
    {
        $this->lines[] = $line;
    }

    protected function setTitleContent()
    {
        $titles = $this->titles;
        foreach ($titles as &$title){
            $title = $this->gbkUtf($title);
        }
        $this->csv_title_content = join(",",$titles).PHP_EOL;
    }

    protected function setLinesContent()
    {
        foreach ($this->lines as $line){
            $this->setLineContent($line);
        }
    }

    protected function setLineContent($line)
    {
        $new_line = [];
        foreach ($this->titles as $title)
        {
            $new_line[$title] = $line[$title];
        }
        $this->csv_line_content .= join(",",$new_line).PHP_EOL;
    }

    protected function gbkUtf(string $value)
    {
        return $value ? iconv('UTF-8', 'GB2312//IGNORE', $value) : '';
    }
}