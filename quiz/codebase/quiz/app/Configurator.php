<?php

namespace App;

class Configurator
{
	//initial settings (can be changed by user) for quiz:play
	public static function getQuizSettings(): array
	{
		$settings = [
			'choices_per_question' => 4,
			'use_section_emphasis_for_scoring' => false,
			'cross_sections_for_possible_answers' => false,
			'show_correct_answers_as_you_go' => false,
			'show_correct_answers_at_the_end' => false,
			'include_version_applicability_questions' => false,

		];

		return $settings;
	}

	//list of exam topics from zend.com
	/*
	List of Exam Topics

-PHP Basics
Syntax
Operators
Variables
Control Structures
Language Constructs and Functions
Namespaces 
Extensions
Config
Performance/bytecode caching

-Functions
Arguments
Variables
References
Returns
Variable Scope
Anonymous Functions, closures
Type Declarations

-Data Format & Types
XML Basics
SimpleXML
XML Extension
Webservices Basics
SOAP
JSON 
DateTime 
DOMDocument


-Web Features
Sessions
Forms
GET and POST data
Cookies
HTTP Headers
HTTP Authentication
HTTP Status Codes 

-I/O
Files
Reading
Writing
File System Functions
Streams
Contexts

-Object Oriented Programming
Instantiation
Modifiers/Inheritance
Interfaces
Return Types
Autoload
Reflection
Type Hinting
Class Constants
Late Static Binding
Magic (_*) Methods
Instance Methods & Properties
SPL
Traits

-Security
Configuration
Session Security
Cross-Site Scripting
Cross-Site Request Forgeries
SQL Injection
Remote Code Injection
Email Injection
Filter Input
Escape Output
Encryption, Hashing algorithms
File uploads
PHP Configuration
Password hashing API 

-Strings & Patterns
Quoting
Matching
Extracting
Searching
Replacing
Formatting
PCRE
NOWDOC
Encodings

-Databases & SQL
SQL
Joins
Prepared Statements
Transactions
PDO

-Arrays
Associative Arrays
Array Iteration
Array Functions
SPL, Objects as arrays 
Casting

-Error Handling
Handling Exceptions
Errors
Throwables
	*/

	//TODO missing URLs from Play.php in most relevant (or a new?!) section
	public static function getStudyGuideSections(): array
	{
		//emphasis is as mentioned in the 7.1 study guide
		//format of php.net_func_manual_refs is, eg, 'info' for http://php.net/manual/en/ref.info.php
		$all = [
			'Basics' => [
				'emphasis' => 2,
				'php.net_func_manual_refs' => [
					'info',	//on the rather tricky side actually...
					'var',


				]
			],
			
			'Data formats and types' => [
				'emphasis' => 0,
				'php.net_func_manual_refs' => [
					//'datetime',	//(class ref not function ref!!!!!!!!!!!!!!!!!!!)
					
					'json',
					
					//'soapclient',	//(class ref not function ref!!!!!!!!!!!!!!!!!!!)
					//'soapserver',	//(class ref not function ref!!!!!!!!!!!!!!!!!!!)
					'soap',
					
					'simplexml',
					//'simplexmlelement'	//(class ref not function ref!!!!!!!!!!!!!!!!!!!)

					'xml',	//xml parser


					'dom',
					//'domdocument'	//(class ref not function ref!!!!!!!!!!!!!!!!!!!)
					
				]
			],
			
			'Strings' => [
				'emphasis' => 1,
				'php.net_func_manual_refs' => [
					'strings',
					'pcre',
					'mbstring'
					
				]
			],

			'Arrays' => [
				'emphasis' => 1,
				'php.net_func_manual_refs' => [
					'array',
					//'arrayobject'	//(class ref not function ref!!!!!!!!!!!!!!!!!!!)
					
				]
			],

			'Input / output' => [
				'emphasis' => 0,
				'php.net_func_manual_refs' => [
					'filesystem',
					'dir',
					'fileinfo',
					'stream',

				]
			],

			'Functions' => [
				'emphasis' => 1,
				'php.net_func_manual_refs' => [
					'funchand',
					//'closure'	//(class ref not function ref!!!!!!!!!!!!!!!!!!!)
					
				]
			],

			'OOP' => [
				'emphasis' => 2,
				'php.net_func_manual_refs' => [
					'classobj',
					//'reflection'	//(class ref not function ref!!!!!!!!!!!!!!!!!!!)
					//SPL stuff?? (study guide mentions ArrayIterator and ArrayObject)
					//'generator'	//(class ref not function ref!!!!!!!!!!!!!!!!!!!)
				]
			],

			'Databases' => [
				'emphasis' => 0,
				'php.net_func_manual_refs' => [
					//'pdo'	//(class ref not function ref!!!!!!!!!!!!!!!!!!!)
					
				]
			],

			'Security' => [
				'emphasis' => 2,
				'php.net_func_manual_refs' => [
					'session',	//also in "Web features" section
					'password',
					//'filter',	//?
					//'openssl',	//? (seems a bit full-on)
					
				]
			],

			'Web features' => [
				'emphasis' => 1,
				'php.net_func_manual_refs' => [
					'session',	//also in "Security" section
					//'network',	//a bit of a stretch (apart from header*() funcs as mentioned in study guide)
				]
			],

			'Error handling' => [
				'emphasis' => 0,
				'php.net_func_manual_refs' => [
					'errorfunc',
					
				]
			],
			
			
		];

		return $all;

	}

}