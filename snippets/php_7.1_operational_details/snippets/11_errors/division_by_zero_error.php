<?php

//Divide by zero - used to be E_WARNING and false returned. Now divide (‘/’) returns a float of -INF, +INF or NAN. and modulo (‘%’) throws DivisionByZeroError
