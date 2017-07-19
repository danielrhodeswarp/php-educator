<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Goutte\Client;

use App\Configurator;

class ScrapeFunctionData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quiz:scrape-function-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape (and store for the quiz) function reference information from php.net';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(file_exists(storage_path() . '/app/function_data.serialised.php'))
        {
            $this->info('Looks like you have the function data stored already so no need to run this again. You can jump straight to the quiz [php artisan quiz:play].');

            exit;
        }

        $functionData = [];

        $config = new Configurator();

        $sections = $config->getStudyGuideSections();

        
        foreach($sections as $sectionName => $section)
        {
            $this->info("====Scraping function data for '{$sectionName}' section:");

            foreach($section['php.net_func_manual_refs'] as $urlSlug)
            {
                $url = "http://php.net/manual/en/ref.{$urlSlug}.php";

                $this->info("========Scraping functions from {$url}");

                $funcs = $this->scrapeFunctionReference($url);

                $functionData[$sectionName] = $funcs;
            }
        }

        file_put_contents(storage_path() . '/app/function_data.serialised.php', serialize($functionData));

        
    }

    //scrape one func ref url
    public function scrapeFunctionReference(string $url): array
    {
        $client = new Client();

        //$crawler = $client->request('GET', 'http://php.net/manual/en/ref.strings.php');
        $crawler = $client->request('GET', $url);

        $detailUrls = $crawler->filter('ul[class="chunklist chunklist_reference"] > li')->each(function($node){

            $base = 'http://php.net/manual/en/'; //TODO
            return($base . $node->filter('a')->attr('href'));

        });

        //dump($detailUrls);
        
        $functions = [];

        foreach($detailUrls as $url)
        {
            //some "function" pages are actually dummy placeholder type entries
            //(which we don't want to process)
            if($url == 'http://php.net/manual/en/function.main.php' or $url == 'http://php.net/manual/en/function.delete.php')
            {
                continue;   //FTTB
            }

            $this->info("============Scraping {$url}");

            //I can't for the life of me suss out how to select a <div class="one two">
            //with xpath or cssSelector. But in this case we can use the function name slug
            //which is used in id names for PHP.net things
            $functionNameSlug = explode('.', $url)[2]; //get from $url

            $crawler = $client->request('GET', $url);

            $function = [];

            $function['name'] = $crawler->filter('h1[class="refname"]')->text();
            $function['summary'] = $crawler->filter('span[class="dc-title"]')->text();
            $function['versions'] = $crawler->filter('p[class="verinfo"]')->text();

            $function['signature'] = $crawler->filter("div[id='refsect1-function.{$functionNameSlug}-description']")->children()->eq(1)->text();
            $function['signature'] = $this->cleanSignature($function['signature']);
            $function['anonsig'] = $this->anonymiseSignature($function['signature']);

            $function['description'] = $crawler->filter("div[id='refsect1-function.{$functionNameSlug}-description']")->children()->filter('p')->each(function($node){

                return trim($node->text());
            });
            $function['description'] = implode(PHP_EOL, $function['description']);

            //pages for alias functions etc don't have a return values section
            if($crawler->filter("div[id='refsect1-function.{$functionNameSlug}-returnvalues']")->count() > 0)
            {
                $function['return'] = $crawler->filter("div[id='refsect1-function.{$functionNameSlug}-returnvalues']")->children()->filter('p')->each(function($node){

                    return trim($node->text());
                });
                $function['return'] = implode(PHP_EOL, $function['return']);
            }

            /*
            
            //why not working?
            $function['return'] = $crawler->filter("div[id='refsect1-function.{$functionNameSlug}-returnvalues']")->children()->filter('p')->each(function($node){

                return $node->text();
            });*/

            //
            $function['parameters'] = $crawler->filter("div[id='refsect1-function.{$functionNameSlug}-parameters'] > dl > dt")->each(function($node){

                $parmName = trim($node->text());
                //var_dump($node->parents()->eq(0));//->nextAll()->text() . PHP_EOL;
                $parmDesc = trim($node->nextAll()->eq(0)->text());

                return [$parmName => $parmDesc];
            });
            $function['parameters'] = $this->removeIntermediaryIndex($function['parameters']);
            $function['flatparameters'] = implode(', ', array_keys($function['parameters']));

            //can be zero, one or more blockquote[class="note"]
            $function['notes'] = $crawler->filter('blockquote[class="note"]')->each(function($node){
            
                return trim($node->text());

            });
            $function['notes'] = implode(PHP_EOL, $function['notes']);

            //can be zero, one or more div[class="caution"]
            $function['cautions'] = $crawler->filter('div[class="caution"]')->each(function($node){
            
                return trim($node->text());

            });
            $function['cautions'] = implode(PHP_EOL, $function['cautions']);


            //can be zero, one or more div[class="warning"]
            $function['warnings'] = $crawler->filter('div[class="warning"]')->each(function($node){
            
                return trim($node->text());

            });
            $function['warnings'] = implode(PHP_EOL, $function['warnings']);

            //TODO "warnings" and "cautions" sound like the same thing so check if
            //any function page has both (else merge into one category)


            //sometimes there's a changelog
            //echo $crawler->filter('div[class="changelog"]')->filter('div[class="refsect1"]')->count() . PHP_EOL;
            
            $function['changelog'] = [];

            if($crawler->filter("div[id='refsect1-function.{$functionNameSlug}-changelog']")->count() > 0)
            {
                //echo "we have a changelog for {$functionNameSlug} !" . PHP_EOL;

                $entries = $crawler->filter("div[id='refsect1-function.{$functionNameSlug}-changelog']")->filter('table > tbody > tr')->each(function($node){


                    //echo "one changelog entry" . PHP_EOL;

                    $cells = $node->filter('td');

                    return [$cells->eq(0)->text() => trim($cells->eq(1)->text())];
                });

                $function['changelog'] = $entries;
                $function['changelog'] = $this->removeIntermediaryIndex($function['changelog']);
            }
            


            //for good luck?
            $function = array_map(function($arrayValue){if(!is_array($arrayValue)){return trim($arrayValue);} return $arrayValue;}, $function);

            //var_dump($function);

            //add this function to pool
            $functions[] = $function;
        }

        return $functions;
    }

    //----from here is helper stuff

    //remove newlines from func sig
    public function cleanSignature(string $sig)
    {
        $noNewlines = str_replace(["\r", "\n"], '', trim($sig));

        return preg_replace('/[ ]{2,}/', ' ', $noNewlines);
    }

    //remove function name from its signature (for quizzing purposes)
    public function anonymiseSignature(string $cleanSig)
    {
        //we will have a couple of duff signatures for functions that are aliases of other functions
        if(strpos($cleanSig, 'This function is an alias of:') === 0)
        {
            return $cleanSig;
        }

        $parts = explode(' ', $cleanSig);

        $parts[1] = '??????';

        return implode(' ', $parts);
    }

    //eg. [0 => ['someKey' => 'someValue'], 1 => ['anotherKey' => 'anotherValue']] to
    //['someKey' => 'someValue', 'anotherKey' => 'anotherValue']
    public function removeIntermediaryIndex(array $array)
    {
        $result = [];

        foreach($array as $keyToRemove => $entry)
        {
            $key = array_keys($entry)[0];
            $value = array_values($entry)[0];

            $result[$key] = $value;
        }

        return $result;
    }
}
