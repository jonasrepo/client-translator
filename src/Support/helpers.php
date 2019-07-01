<?php
/**
 * helpers.php
 *
 * Author: Guo
 * Email jonasyeah@163.com
 *
 * Date:   2019-06-29 21:06
 */

function show_help($argv, $output)
{
    if(in_array('-h', $argv)
        || in_array('--help', $argv)
        || in_array('-v', $argv)
        || count($argv) == 1
    )
    {
        $help = '<fg=green>
 ______  ____    ____  ____   _____ _       ____  ______   ___   ____
|      ||    \  /    ||    \ / ___/| |     /    ||      | /   \ |    \
|      ||  D  )|  o  ||  _  (   \_ | |    |  o  ||      ||     ||  D  )
|_|  |_||    / |     ||  |  |\__  || |___ |     ||_|  |_||  O  ||    /
  |  |  |    \ |  _  ||  |  |/  \ ||     ||  _  |  |  |  |     ||    \
  |  |  |  .  \|  |  ||  |  |\    ||     ||  |  |  |  |  |     ||  .  \
  |__|  |__|\_||__|__||__|__| \___||_____||__|__|  |__|   \___/ |__|\_|
</>
';

        $output->writeln($help);
        $output->writeln('<fg=cyan>php ./tsl \'to translate statment\' -f baidu,youdao</>');
        die;
    }
}
