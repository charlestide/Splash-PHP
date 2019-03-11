<?php
/**
 * Created by PhpStorm.
 * User: tangkeyu
 * Date: 2019-03-10
 * Time: 23:02
 */

namespace SplashPhp\Libraries;


use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

class Output extends ConsoleOutput
{

    /**
     * @param $message
     * @param null $style
     * @param bool $newLine
     */
    public function put($message,$style = null, $newLine = true) {
        $styled = $style ? "<$style>$message</$style>" : $message;
        $this->write($styled, $newLine, $this->getVerbosity());
    }


    /**
     * Write a string as information output.
     *
     * @param  string  $string
     * @param  bool $newLine
     * @return void
     */
    public function info($string, $newLine = true)
    {
        $this->put($string,'info', $newLine);
    }

    /**
     * Write a string as comment output.
     *
     * @param  string  $string
     * @param  bool $newLine
     * @return void
     */
    public function comment($string, $newLine = true)
    {
        $this->put($string,'comment', $newLine);
    }

    /**
     * Write a string as question output.
     *
     * @param  string  $string
     * @param  bool $newLine
     * @return void
     */
    public function question($string, $newLine = true)
    {
        $this->put($string, 'question', $newLine);
    }

    /**
     * Write a string as error output.
     *
     * @param  string  $string
     * @param  bool $newLine
     * @return void
     */
    public function error($string, $newLine = true)
    {
        $this->put($string, 'error', $newLine);
    }

    /**
     * Write a string in an alert box.
     *
     * @param  string  $string
     * @param  bool $newLine
     * @return void
     */
    public function alert($string, $newLine = true)
    {
        $this->comment(str_repeat('*', strlen($string) + 12));
        $this->comment('*     '.$string.'     *');
        $this->comment(str_repeat('*', strlen($string) + 12));

        if ($newLine) {
            $this->put('');
        }
    }

    /**
     * Write a string as warning output.
     *
     * @param  string  $string
     * @param  bool $newLine
     * @return void
     */
    public function warn($string, $newLine = true)
    {
        if (! $this->getFormatter()->hasStyle('warning')) {
            $style = new OutputFormatterStyle('yellow');

            $this->getFormatter()->setStyle('warning', $style);
        }

        $this->put($string, 'warning', $newLine);
    }

    /**
     * @param $string
     * @param null $style
     */
    public function line($string, $style = null) {
        $this->put($string,$style,true);
    }

    /**
     * write a key-value string
     *
     * @param $title
     * @param $value
     * @param bool $newLine
     */
    public function field($title,$value, $newLine = true) {
        $message = "<fg=default;bg=default>$title ：</>";
        $message .= "<fg=blue;bg=default> $value </>";
        $this->put($message,null,$newLine);
    }

    /**
     * 使用vsprintf 输出
     *
     * @param $message
     * @param null $args
     * @param bool $newLine
     * @param string $color
     */
    public function printf($message,$args = null,$newLine = true,$color = 'blue') {
        if ($args) {
            if (!is_array($args)) {
                $args = [$args];
            }
            foreach($args as $k => $arg) {
                $args[$k] = "<fg=default;bg=$color> $arg </>";
            }

            $message = vsprintf($message,$args);
        } else {
            $message = "<fg=default;bg=$color> $message </>";;
        }
        $this->put($message,null,$newLine);
    }

    /**
     * 输出一组key-value数组
     *
     * @param $title
     * @param array $fields
     * @param array $headers
     */
    protected function fields($title,array $fields, array $headers = ['字段','值']) {
        $this->info($title);
        $data = [];
        foreach($fields as $field => $value) {
            $data[] = [
                'field' =>  $field,
                'value' =>  $value
            ];
        }
        $this->grid($headers,$data);
    }

    /**
     * @param array $headers
     * @param $rows
     * @param string $style
     */
    public function grid(array $headers, $rows, $style = 'default') {
            $table = new Table($this);

            if ($rows instanceof Arrayable) {
                $rows = $rows->toArray();
            }

            $table->setHeaders($headers)->setRows($rows)->setStyle($style)->render();
    }

    /**
     * @param Model $model
     */
//    public function printDirty(Model $model) {
//        $this->warn(get_class($model).' at #'.$model->id);
//        $this->fields('Dirty Fields in '.get_class($model).'：',$model->getDirty());
//    }

    /**
     * @param string $title
     * @param $content
     */
    public function block(string $title,$content) {

        if (is_string($content)) {
            $content = collect([$content]);
        } else if (is_array($content)) {
            $content = collect($content);
        }

        $maxLength = $content->reduce(function ($carry,$item) {
            if ($carry <= strlen($item)) {
                $carry = strlen($item);
            }
            return $carry;
        });

        $maxLength = max($maxLength,strlen($title)) + 10;

        $this->comment(str_repeat('-',$maxLength));

        $this->blockLine('',$maxLength);
        $this->blockLine($title,$maxLength);

        foreach ($content as $item) {
            $this->blockLine($item,$maxLength);
        }

        $this->comment(str_repeat('-',$maxLength));
    }

    /**
     * @param string $content
     * @param int $maxLength
     */
    private function blockLine(string $content, int $maxLength) {
        $contentLength = strlen($content);

        $spaceLength = ceil(($maxLength - $contentLength - 2) / 2);
        $spaceLength -= ceil(mb_strlen($content) - $contentLength) / 2;

        $rightSpaceLength = $maxLength - $spaceLength - $contentLength - 1;
        $rightSpaceLength -= ceil(mb_strlen($content) - $contentLength) / 2;

        $leftSpace = str_repeat(' ',$spaceLength);
        $rightSpace = str_repeat(' ',$rightSpaceLength);
        $this->comment("|{$leftSpace}{$content}{$rightSpace}|");
    }

    /**
     * @param string $content
     * @param bool $newLine
     */
    public function green(string $content,bool $newLine = true) {
        $this->put("<fg=green>{$content}</>",null,$newLine);
    }

    /**
     * @param string $content
     * @param bool $newLine
     */
    public function red(string $content, bool $newLine = true) {
        $this->put("<fg=red>{$content}</>",null,$newLine);
    }

    /**
     * @param string $content
     * @param bool $newLine
     */
    public function blue(string $content, bool $newLine = true) {
        $this->put("<fg=blue>{$content}</>",null,$newLine);
    }

    /**
     * @param string $content
     * @param bool $newLine
     */
    public function white(string $content, bool $newLine = true) {
        $this->put("<fg=white>{$content}</>",null,$newLine);
    }

    /**
     * @param string $content
     * @param bool $newLine
     */
    public function arrow(string $content, bool $newLine = true) {
        $this->put("<fg=blue>==></> <fg=white>{$content}</>",null,$newLine);
    }
}