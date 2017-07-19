<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Configurator;
use App\Quizitor;

class Play extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quiz:play';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Play the PHP Educator quiz!';

    

    //which function ref sections of php.net to quiz on?
    /*
    protected $sections = [
        'http://php.net/manual/en/ref.errorfunc.php',
        'http://php.net/manual/en/ref.outcontrol.php'
        http://php.net/manual/en/ref.csprng.php
        http://php.net/manual/en/ref.password.php
        http://php.net/manual/en/book.pdo.php (class ref not function ref!!!!!!!!!!!!!!!!!!!)
        http://php.net/manual/en/book.datetime.php (like above (but *does* have functional versions as well))
        http://php.net/manual/en/ref.dir.php
        http://php.net/manual/en/ref.fileinfo.php
        http://php.net/manual/en/ref.filesystem.php
        http://php.net/manual/en/ref.mbstring.php
        http://php.net/manual/en/ref.json.php
        http://php.net/manual/en/ref.misc.php
        //SPL stuff?
        http://php.net/manual/en/ref.session.php
        http://php.net/manual/en/ref.strings.php
        http://php.net/manual/en/ref.pcre.php
        http://php.net/manual/en/ref.array.php
        http://php.net/manual/en/ref.classobj.php
        http://php.net/manual/en/ref.funchand.php
        http://php.net/manual/en/ref.var.php
        http://php.net/manual/en/ref.info.php

    ];
    */

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function renderQuestion(array $question)
    {
        [$inputMode, $inputExpectation, $notUseful, $from] = explode('_', $question['type']);

        if($inputMode == 'type')
        {
            return $this->ask($question['text']);
        }

        elseif($inputMode == 'choose')
        {
            return $this->choice($question['text'], $question['choices']);
        }
    }

    public function answerIsCorrect($answer, array $question)
    {
        [$inputMode, $inputExpectation, $notUseful, $from] = explode('_', $question['type']);

        //allow 'strpos()' as well as 'strpos' for questions where a function name has to be input
        if($inputMode == 'type')
        {
            $answer = rtrim($answer, '()');
        }

        return $answer == $question['answer_text'];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(!file_exists(storage_path() . '/app/function_data.serialised.php'))
        {
            $this->info('Please run [php artisan quiz:scrape-function-data] as you do not have function data stored.');

            exit;
        }


        

        
        

        //$exitCode = $this->call('quiz:scrape-function-data');   //there's also callSilent()

        $choice = $this->choice('What would you like to do? (arrow up or down or type the number)',
            [
                'Round of 10',
                'Round of 20',
                'Round of 30',
                'Round of 40',
                'Settings',
                'Exit'

            ]
        );

        if($choice == 'Exit')
        {
            exit;
        }

        if($choice == 'Settings')
        {
            $this->settings();
        }

        if(strpos($choice, 'Round of') === 0)
        {
            $parts = explode(' ', $choice);

            $this->quiz($parts[2]);
        }
    }

    public function quiz(int $questionCount)
    {
        //$this->info("{$questionCount} qs");

        $config = new Configurator();

        $functionData = unserialize(file_get_contents(storage_path() . '/app/function_data.serialised.php'));

        
        $quizitor = new Quizitor($functionData, $config->getQuizSettings());

        $correct = 0;

        for($loop = 0 ; $loop < $questionCount; $loop++)
        {
        
            $question = $quizitor->generateQuestion();

            //var_dump($question);

            $result = $this->renderQuestion($question);

            var_dump($this->answerIsCorrect($result, $question));

            if($result)
            {
                $correct++;
            }
        }

        $this->info("{$correct} correct answers from {$questionCount} questions");
    }

    /**
     *
     */
    public function settings()
    {
        $choice = $this->choice('SETTINGS. What would you like to do? (arrow up or down or type the number)',
            [
                'Sections',
                'Difficulty',
                'Back'

            ]
        );

        if($choice == 'Back')
        {
            $this->handle();
        }
    }
}
