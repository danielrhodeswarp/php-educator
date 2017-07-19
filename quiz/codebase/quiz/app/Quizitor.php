<?php

namespace App;

class Quizitor
{
	protected $functionData;

	protected $config;

	protected $questionTypes = [
		'choose_summary_from_name',
		//'choose_versions_from_name',	//will be a tad tricky
		'choose_anonsig_from_name',
		//'choose_description_from_name',
		'choose_flatparameters_from_name',
		'choose_return_from_name',
		
		'choose_name_from_summary',
		//'choose_name_from_versions',	//will be difficult and obscure
		'choose_name_from_anonsig',
		//'choose_name_from_description',	//description too verbose and often contains the function name!
		'choose_name_from_flatparameters',
		'choose_name_from_return',
		
		'type_name_from_summary',
		//'type_name_from_versions',	//will be difficult and obscure
		'type_name_from_anonsig',
		//'type_name_from_description',
		//'type_name_from_flatparameters',
		//'type_name_from_return'	//too vague!
		//TODO questions on the more optional metadata (cautions, warning, changelog etc)
	];

	protected $questionTextPerType = [
		'choose_summary_from_name' => 'what is the summary for ',
		//'choose_versions_from_name' => 'what is the version applicability for ',
		'choose_anonsig_from_name' => 'what is the signature for ',
		//'choose_description_from_name' => 'what is the description for ',
		'choose_flatparameters_from_name' => 'what are the parameters for ',
		'choose_return_from_name' => 'what is returned by ',
		
		'choose_name_from_summary' => 'which function is summarised by: ',
		//'choose_name_from_versions' => 'Which function has the version applicability: ',	//will be difficult and obscure
		'choose_name_from_anonsig' => 'which function has the signature: ',
		//'choose_name_from_description' => 'Which function has the description: ',
		'choose_name_from_flatparameters' => 'which function has the parameters: ',
		'choose_name_from_return' => 'which function returns: ',
		
		'type_name_from_summary' => 'enter the function having the summary: ',
		//'type_name_from_versions' => 'Enter the function having the version applicability: ',	//will be difficult and obscure
		'type_name_from_anonsig' => 'enter the function having the signature: ',
		//'type_name_from_description' => 'enter the function having the description: ',
		//'type_name_from_flatparameters' => 'enter the function having the parameters: ',	//too difficult
		//'type_name_from_return' => 'enter the function that returns: ',	//too vague!
		//TODO the more optional metadata (cautions, warning etc)
	];

	public function __construct(array $functionData, array $config)
	{
		$this->functionData = $functionData;
		$this->config = $config;
	}

	//get random function from specified section (which, if null, will be randomly picked)
	public function getRandomFunction(?string $section)
	{
		if(is_null($section))
		{
			$section = $this->getRandomSection();
		}

		return $this->functionData[$section][array_rand($this->functionData[$section])];
	}

	//get random function section
	public function getRandomSection()
	{
		$sections = array_keys($this->functionData);
		
		return $sections[array_rand($sections)];
	}

	//generate a random question
	//
	//actual PHP exam has the following types of question:
	/*"Each question can be formulated in one of three ways: 

	As a multiple-choice question with only one right answer. 
	As a multiple-choice question with multiple correct answers. 
	As a free-form question for which the answer must be typed in."
*/
	public function generateQuestion()
	{
		//get random question type
		$type = $this->questionTypes[array_rand($this->questionTypes)];

		//get random section
		$section = $this->getRandomSection();

		//get random function (within the above section)
		$function = $this->getRandomFunction($section);

		$question = [];
		$question['type'] = $type;
		$question['section'] = $section;
		$question['function'] = $function;
		$question['text'] = "{$section} now, {$this->questionTextPerType[$type]}";
		$question['choices'] = [];
		$question['answer_text'] = '';
		$question['answer_index'] = '';	//in ['choices'] array


		return $this->fillQuestion($question);
	}

	//insert text, choices, answer_text and answer_index
	public function fillQuestion(array $question)
	{
		[$inputMode, $inputExpectation, $notUseful, $from] = explode('_', $question['type']);

		var_dump($inputMode, $inputExpectation, $notUseful, $from);
		//var_dump($question['function']['name']);

		if($inputMode == 'type')
		{
			$question['text'] .= $question['function'][$from] . ' ?';
			$question['answer_text'] = $question['function'][$inputExpectation];
		}

		elseif($inputMode == 'choose')
		{
			$question['answer_text'] = $question['function'][$inputExpectation];

			if($from == 'name')
			{
				$question['text'] .= $question['function']['name'] . '() ?';
			}

			else
			{
				$question['text'] .= $question['function'][$from] . ' ?';
			}

			$question['choices'] = $this->generateChoices($question);

			//put correct answer in (by clobbering one of generated choices)
			$randomChoice = array_rand($question['choices']);

			$question['choices'][$randomChoice] = $question['answer_text'];
			$question['answer_index'] = $randomChoice;
		}

		

		return $question;
	}

	//purely random and NOTE that the correct answer is not slotted in!
	public function generateChoices(array $question)
	{
		[$inputMode, $inputExpectation, $notUseful, $from] = explode('_', $question['type']);

		if($this->config['cross_sections_for_possible_answers'])
		{
			//TODO
		}

		else
		{
			//leave space for the correct answer to be slotted in!
			//(not done in this method BTW)
			//UPDATE: actually, no, we'll just clobber one to put the correct answer in
			//$count = $this->config['choices_per_question'] - 1;
			$count = $this->config['choices_per_question'];

			$randomKeys = array_rand($this->functionData[$question['section']], $count);

			$choices = [];

			foreach($randomKeys as $key)
			{
				$choices[] = $this->functionData[$question['section']][$key][$inputExpectation];
			}

			return $choices;

		}
	}

	public function generateQuiz()
	{

	}

	public function scoreQuestion()
	{

	}

	public function scoreQuiz()
	{

	}
}