<?php
/**
 * TranslatorCommand.php
 *
 * Author: Guo
 * Email jonasyeah@163.com
 *
 * Date:   2019-06-29 17:54
 */

namespace Jonas\TranslatorClient;

use Jonas\Translator\TranslateManager;
use Jonas\Translator\Translator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TranslatorCommand
 *
 * @package Jonas\TranslatorClient
 */
class TranslatorCommand extends Command
{
    /**
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('translator')
            ->setDescription('Smart translator in console')
            ->addArgument('statment', InputArgument::REQUIRED, 'the statment you want to translate')
            ->addOption('from', 'f', InputOption::VALUE_OPTIONAL, 'choose the translate engine', 'youdao');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $str  = $input->getArgument('statment');
            $from = array_filter(explode(',', trim($input->getOption('from'),',')));
            $translator = new Translator();
            $res  = $translator->translate($str, $from);
            $this->display($res, $output, count($from) >= 2);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param      $res
     * @param      $output
     * @param bool $is_multi_row
     */
    protected function display($res, $output, $is_multi_row = false)
    {
        if(!$is_multi_row) {
            $this->fromatDisplay($res, $output);
        }else {
            foreach ($res as $each) {
                $this->fromatDisplay($each, $output);
            }
        }
    }

    /**
     * @param $each
     * @param $output
     */
    private function fromatDisplay($each, $output)
    {
        switch($each['status']) {
            case TranslateManager::STATUS_SUCCESS:
                $output->writeln($this->color('Translated Successfully', 'cyan'));
                $output->writeln('来源:     ' . $this->color($each['gateway']));
                $output->writeln('长句翻译: ' . $this->color($each['result']->getTransResult()));
                if($each['result']->getDictResult()) {
                    $output->writeln('单词翻译: ' . $this->color(implode(',', array_map('trim', $each['result']->getDictResult()))));
                }
                break;
            case TranslateManager::STATUS_FAILURE:
                $output->writeln($this->color('Translated Fail', 'red'));
                $output->writeln('Fail Reason: ' . $this->color($each['exception']->getMessage()));
                break;
            default:
                $output->writeln($this->color('Translated Fail', 'red'));
                $output->writeln('Fail Reason: ' . $this->color('o(╥﹏╥)o Unkown'));
                break;
        }
    }

    /**
     * @param        $string
     * @param string $color
     *
     * @return string
     */
    protected function color($string , $color = 'yellow')
    {
        return sprintf("<fg=%s>%s</>", $color, $string);
    }
}