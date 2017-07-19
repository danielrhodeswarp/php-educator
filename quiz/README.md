#Quiz

HOWTO

* vagrant up (you'll need Vagrant installed obvs)
* vagrant ssh
* cd quiz/quiz
* php artisan quiz:scrape-function-data [only need to do this once]
* php artisan quiz:play [the main event!]

TODO

* spit and polish
* scoring!
* perhaps quiz on non-function reference parts of php.net
* section weightings (to match the exam)