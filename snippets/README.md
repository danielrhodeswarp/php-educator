#Snippets

HOWTO

* Run *all* snippets in each folder with "sh docker-run.sh" in that folder (after a one-off "sh docker-build.sh")
* obvs you'll need Docker installed

TODO

* Figure out custom (?) error trapping
* A way (?) to *carry on regardless* even if a snippet PARSE errors
* Maybe use docker-compose instead of the shell scripts
* can prob use get_defined_constants() in run_all_snippets.php (for the error type names)