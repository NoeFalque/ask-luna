<?php

use \App\System\App;

App::getEmitter()->addListener('coucou', function() {

});


App::getEmitter()->emit('coucou');
